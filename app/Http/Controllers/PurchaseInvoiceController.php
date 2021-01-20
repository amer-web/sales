<?php

namespace App\Http\Controllers;

use App\Models\supplier;
use App\Models\Invoice;
use App\Models\MethodPayment;
use App\Models\Payments;
use App\Models\Product;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;

class PurchaseInvoiceController extends Controller
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
        $suppliers = supplier::get();
        $requestStatus = -1;
        $requestSupplier = -1;
        $invoices = Invoice::where('type', 2)->orderBy('created_at', 'desc');
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
                    $requestStatus = request()->status;
                }
                if (request()->supplier_id != null) {
                    $invoices->where('supplier_id', request()->supplier_id);
                    $requestSupplier = request()->supplier_id;
                }
            }
        }
        $invoices = $invoices->get();
        return view('invoices-purchase.index', compact('invoices', 'requestRadio','requestStatus','suppliers','requestSupplier'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $products = Product::get();
        $suppliers = Supplier::get();
        $method_payments = MethodPayment::get();
        return view('invoices-purchase.create')->with([
            'suppliers' => $suppliers,
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
            'supplier_id' => $request->supplier_id,
            'type' => 2,
            'user_id' => auth()->user()->id,
        ]);
        foreach ($request->invoice as $value) {
            if ($value['product_id'] != null & $value['purchase_price'] != null & $value['amount'] != null) {
                $data['product_id'] = $value['product_id'];
                $data['invoice_id'] = $invoice->id;
                $data['purchase_price'] = $value['purchase_price'];
                $data['amount'] = $value['amount'];
                $data['total'] = $value['purchase_price'] * $value['amount'];
                $invoice->bellPurchase()->create($data);
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
        $totalPurachase = $invoice->bellPurchase()->sum('total');
        $rateVat = ($invoice->vat * ($totalPurachase - $invoice->discount)) / 100;
        $invoice->value_rate = $rateVat;
        $invoice->save();
        $total_due = ($totalPurachase - $invoice->discount) + $invoice->value_rate;
        $invoice->total_due = $total_due;
        $invoice->save();
        $this->setStatus();
        return redirect()->route('purchase-invoice.show', $invoice->id)->with('success', 'تم حفظ الفاتورة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Invoice $purchase_invoice)
    {
        $invoice = $purchase_invoice;
        $payments = $purchase_invoice->payments()->where('paid', '!=', 0)->orderBy('created_at', 'desc')->get();
        return view('invoices-purchase.view', compact('invoice', 'payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $purchase_invoice)
    {
        $products = Product::get();
        $suppliers = supplier::get();
        return view('invoices-purchase.edit')->with([
            'invoice' => $purchase_invoice,
            'suppliers' => $suppliers,
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
    public function update(Request $request, Invoice $purchase_invoice)
    {

        $purchase_invoice->update([
            'invoice_date' => $request->invoice_date,
            'due_date' => $request->due_date,
            'discount' => $request->discount,
            'vat' => $request->vat,
            'supplier_id' => $request->supplier_id,
            'user_id' => auth()->user()->id,
        ]);
        $purchase_invoice->bellPurchase()->forceDelete();
        foreach ($request->invoice as $value) {
            if ($value['product_id'] != null & $value['purchase_price'] != null & $value['amount'] != null) {
                $data['product_id'] = $value['product_id'];
                $data['invoice_id'] = $purchase_invoice->id;
                $data['purchase_price'] = $value['purchase_price'];
                $data['amount'] = $value['amount'];
                $data['total'] = $value['purchase_price'] * $value['amount'];
                $purchase_invoice->bellPurchase()->create($data);
            }
        }

        $totalSales = $purchase_invoice->bellPurchase()->sum('total');
        $rateVat = ($purchase_invoice->vat * ($totalSales - $purchase_invoice->discount)) / 100;
        $purchase_invoice->value_rate = $rateVat;
        $purchase_invoice->save();
        $total_due = ($totalSales - $purchase_invoice->discount) + $purchase_invoice->value_rate;
        $purchase_invoice->total_due = $total_due;
        $purchase_invoice->save();
        $this->setStatus();
        return redirect()->route('purchase-invoice.show', $purchase_invoice->id)->with('success', 'تم تعديل الفاتورة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $purchase_invoice)
    {
        $purchase_invoice->bellPurchase()->delete();
        $purchase_invoice->delete();
        return redirect()->back()->with('success', 'تم حذف فاتورة المورد  ' . $purchase_invoice->supplier->name . ' بنجاح ');
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
        return view('invoices-purchase.print', compact('invoice'));
    }
}
