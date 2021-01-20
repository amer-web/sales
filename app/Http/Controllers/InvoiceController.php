<?php

namespace App\Http\Controllers;

use App\Jobs\DeleteInvoiceAfterSend;
use App\Mail\SendInvoiceToClientMail;
use App\Models\BellPurchase;
use App\Models\BellSale;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\MethodPayment;
use App\Models\Payments;
use App\Models\Product;
use App\Models\SalesRefund;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Route;
use PDF;

class InvoiceController extends Controller
{
    use HelperTrait;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->setStatus();
        $clients = Client::get();
        $requestStatus = -1;
        $requestClient = -1;
        $invoices = Invoice::where('type', 1)->orderBy('created_at', 'desc');
        if (request()->rdio == null) {
            $requestRadio = 0;
        } else {
            $requestRadio = request()->rdio;
            if (request()->rdio == 2) {
                if (request()->invoice_id != null) {
                    $invoices->where('id', request()->invoice_id);
                }
            } else {
                if (request()->status != null) {
                    $invoices->where('status', request()->status);
                    $requestStatus = request()->status ;
                }
                if (request()->client_id != null) {
                    $invoices->where('client_id', request()->client_id);
                    $requestClient = request()->client_id ;
                }
            }
        }

        $invoices = $invoices->get();
        return view('invoices.index', compact('invoices', 'requestRadio','requestStatus','clients','requestClient'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::get();
        $clients = Client::get();
        $method_payments = MethodPayment::get();
        return view('invoices.create')->with([
            'clients' => $clients,
            'products' => $products,
            'method_payments' => $method_payments
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $invoice = Invoice::create([
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'discount' => $request->discount,
            'vat' => $request->vat,
            'client_id' => $request->client_id,
            'user_id' => auth()->user()->id,
        ]);
        foreach ($request->invoice as $value) {
            if ($value['product_id'] != null & $value['sale_price'] != null & $value['amount'] != null) {
                $data['product_id'] = $value['product_id'];
                $data['sale_price'] = $value['sale_price'];
                $data['amount'] = $value['amount'];
                $data['total'] = $value['sale_price'] * $value['amount'];
                $bellSale = BellSale::create($data);
                $invoice->bellSales()->attach($bellSale->id);
            }
        }
        if ($request->paid != null) {
            Payments::create([
                'invoice_id' => $invoice->id,
                'paid' => $request->paid,
                'method_payment_id' => $request->method_payment_id,
                'user_id' => auth()->user()->id,
            ]);
        }
        $totalSales = $invoice->bellSales()->sum('total');
        $rateVat = ($invoice->vat * ($totalSales - $invoice->discount)) / 100;
        $invoice->value_rate = $rateVat;
        $invoice->save();
        $total_due = ($totalSales - $invoice->discount) + $invoice->value_rate;
        $invoice->total_due = $total_due;
        $invoice->save();
        $this->setStatus();
        return redirect()->route('invoice.show', $invoice->id)->with('success', 'تم حفظ الفاتورة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $invoice)
    {
        $payments = $invoice->payments()->where('paid', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('invoices.view', compact('invoice', 'payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        $products = Product::get();
        $clients = Client::get();
        return view('invoices.edit')->with([
            'invoice' => $invoice,
            'clients' => $clients,
            'products' => $products
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {

        $invoice->update([
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'discount' => $request->discount,
            'vat' => $request->vat,
            'client_id' => $request->client_id,
            'user_id' => auth()->user()->id,
        ]);
        $invoice->bellSales()->forceDelete();
        $invoice->bellSales()->detach();

        foreach ($request->invoice as $value) {
            if ($value['product_id'] != null & $value['sale_price'] != null & $value['amount'] != null) {
                $data['product_id'] = $value['product_id'];
                $data['sale_price'] = $value['sale_price'];
                $data['amount'] = $value['amount'];
                $data['total'] = $value['sale_price'] * $value['amount'];
                $bellSale = BellSale::create($data);
                $invoice->bellSales()->attach($bellSale->id);
            }
        }

        $totalSales = $invoice->bellSales()->sum('total');
        $rateVat = ($invoice->vat * ($totalSales - $invoice->discount)) / 100;
        $invoice->value_rate = $rateVat;
        $invoice->save();
        $total_due = ($totalSales - $invoice->discount) + $invoice->value_rate;
        $invoice->total_due = $total_due;
        $invoice->save();
        $this->setStatus();
        return redirect()->route('invoice.show', $invoice->id)->with('success', 'تم تعديل الفاتورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Invoice $invoice)
    {
        if (file_exists(public_path('invoicessent/') . 'فاتورة رقم ' . $invoice->id . '.pdf')) {
            unlink(public_path('invoicessent/') . 'فاتورة رقم ' . $invoice->id . '.pdf');
        }
        $invoice->bellSales()->forceDelete();
        $invoice->invoicesRefund()->forceDelete();
        $invoice->forceDelete();
        if ($request->url == 'client.show') {
            return redirect()->back()->with('success', 'تم حذف فاتورة العميل  ' . $invoice->client->name . ' بنجاح ');
        }
        return redirect()->route('invoice.index')->with('success', 'تم حذف فاتورة العميل  ' . $invoice->client->name . ' بنجاح ');
    }

    public function salePrice(Request $request)
    {
        $id = $request->id;
        $sellingPrice = Product::find($id)->sellingPrice;
        return response()->json($sellingPrice);
    }

    public function print($id)
    {
        $invoice = Invoice::find($id);
        return view('invoices.print', compact('invoice'));
    }

    public function pdf($id)
    {
        $invoice = Invoice::find($id);
        $data['invoice_id'] = $invoice->id;
        $data['invoice_date'] = $invoice->invoice_date;
        $data['client'] = $invoice->client->name;
        $data['address'] = $invoice->client->address;
        $data['phone'] = $invoice->client->phone;
        $items = [];
        foreach ($invoice->bellSales as $sales) {
            $items [] = [
                'product_name' => $sales->product->name,
                'sale_price' => $sales->sale_price,
                'amount' => $sales->amount,
                'total' => $sales->total
            ];
        }
        $data['items'] = $items;
        $data['total_price'] = $invoice->bellSales()->sum('total');
        $data['discount'] = $invoice->discount;
        $data['vat'] = $invoice->vat;
        $data['value_rate'] = $invoice->value_rate;
        $data['total_due'] = $invoice->total_due;
        $data['total_refund'] = $invoice->invoicesRefund()->sum('total_refund');
        $data['paid'] = $invoice->payments()->sum('paid');
        $data['paid_due'] = ($invoice->total_due - $invoice->invoicesRefund()->sum('total_refund')) - $invoice->payments()->sum('paid');
        $data['created_at'] = date('Y-m-d H:i');
        $pdf = PDF::loadView('invoices.pdf', $data);
        if (Route::currentRouteName() == 'send.pdf') {
            return $pdf->stream('فاتورة رقم ' . $invoice->id . '.pdf');
        } else {
            $pdf->save(public_path('invoicessent/') . 'فاتورة رقم ' . $invoice->id . '.pdf');
            return 'فاتورة رقم ' . $invoice->id . '.pdf';
        }

    }

    public function sendMail($id)
    {
        $invoice = Invoice::find($id);
        if ($invoice->client->email == null) {
            return redirect()->back()->with('error', 'يرجى أولاً تسجيل بريد الكترونى للعميل ' . $invoice->client->name);
        }
        $this->pdf($id);
        Mail::to($invoice->client->email)->queue(new SendInvoiceToClientMail($invoice));
        dispatch(new DeleteInvoiceAfterSend($invoice))->delay(now()->addMinute());
        return redirect()->back()->with('success', 'تم ارسال الإيميل بنجاح');
    }
}
