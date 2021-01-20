<?php

namespace App\Http\Controllers;

use App\Models\BellPurchase;
use App\Models\BellSale;
use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceRefund;
use App\Models\MethodPayment;
use App\Models\Payments;
use App\Models\Product;
use App\Models\PurchaseRefund;
use App\Models\SalesRefund;
use App\Models\Supplier;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InvoiceRefundPurchaseController extends Controller
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
        $invoicesRefund = InvoiceRefund::whereHas('invoice',function($q){
            $q->where('type',2);
        })->get();
        return view('invoices-refund-purchase.index', compact('invoicesRefund'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Invoice $invoice)
    {
        $products = Product::get();
        $products_id = $invoice->bellPurchase()->get()->pluck('product_id')->toArray();
        return view('invoices-refund-purchase.create')->with([
            'invoice' => $invoice,
            'products' => $products,
            'products_id' => $products_id
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
        $invoiceRefund = InvoiceRefund::create([
            'invoice_id' => $request->invoice_id,
            'invoice_date' => $request->invoice_date,
            'discount' => $request->discount,
            'vat' => $request->vat,
        ]);
        foreach ($request->invoice as $value) {
            if ($value['product_id'] != null & $value['purchase_price'] != null & $value['amount'] != null) {
                $data['product_id'] = $value['product_id'];
                $data['invoice_refund_id'] = $invoiceRefund->id;
                $data['purchase_price'] = $value['purchase_price'];
                $data['amount'] = $value['amount'];
                $data['total'] = $value['purchase_price'] * $value['amount'];
                $invoiceRefund->purchaseRefund()->create($data);
            }
        }
        $totalSales = $invoiceRefund->purchaseRefund()->sum('total');
        $rateVat = ($invoiceRefund->vat * ($totalSales - $invoiceRefund->discount)) / 100;
        $invoiceRefund->value_rate = $rateVat;
        $invoiceRefund->save();
        $total_refund = ($totalSales - $invoiceRefund->discount) + $invoiceRefund->value_rate;
        $invoiceRefund->total_refund = $total_refund;
        $invoiceRefund->save();
        return redirect()->route('purchase-invoice.show', $invoiceRefund->invoice_id)->with('success', 'تم حفظ الفاتورة بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(InvoiceRefund $invoice_refund_purchase)
    {
       $invoice_refund =  $invoice_refund_purchase;
        return view('invoices-refund-purchase.view', compact('invoice_refund'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit(InvoiceRefund $invoice_refund_purchase)
    {
        $products = Product::get();
        $suppliers = Supplier::get();
        $products_id = $invoice_refund_purchase->invoice->bellPurchase()->get()->pluck('product_id')->toArray();
        return view('invoices-refund-purchase.edit')->with([
            'invoice_refund' => $invoice_refund_purchase,
            'suppliers' => $suppliers,
            'products' => $products,
            'products_id' => $products_id
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,InvoiceRefund $invoice_refund_purchase)
    {
        $invoice_refund = $invoice_refund_purchase;
        $invoice_refund->update([
            'invoice_date' => $request->invoice_date,
            'discount' => $request->discount,
            'vat' => $request->vat,
        ]);
        $invoice_refund->purchaseRefund()->forceDelete();
        foreach ($request->invoice as $value) {
            if ($value['product_id'] != null & $value['purchase_price'] != null & $value['amount'] != null) {
                $data['product_id'] = $value['product_id'];
                $data['invoice_refund_id'] = $invoice_refund->id;
                $data['purchase_price'] = $value['purchase_price'];
                $data['amount'] = $value['amount'];
                $data['total'] = $value['purchase_price'] * $value['amount'];
                $invoice_refund->purchaseRefund()->create($data);
            }
        }
        $totalSales = $invoice_refund->purchaseRefund()->sum('total');
        $rateVat = ($invoice_refund->vat * ($totalSales - $invoice_refund->discount)) / 100;
        $invoice_refund->value_rate = $rateVat;
        $invoice_refund->save();
        $total_refund = ($totalSales - $invoice_refund->discount) + $invoice_refund->value_rate;
        $invoice_refund->total_refund = $total_refund;
        $invoice_refund->save();
        return redirect()->route('purchase-invoice.show', $invoice_refund->invoice_id)->with('success', 'تم تعديل الفاتورة المرتجعة بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(InvoiceRefund $invoice_refund_purchase)
    {
        $invoice_refund_purchase->forceDelete();
        return redirect()->back()->with('success', 'تم حذف الفاتورة المرتجعة بنجاح');
    }

    public function purchasePrice(Request $request)
    {
        $id = $request->id;
        $invoice_id = $request->invoice_id;
        $productRefundAmount =  PurchaseRefund::where('product_id',$id)->whereHas('invoiceRefund',function($q) use ($invoice_id){
            $q->where('invoice_id',$invoice_id);
        })->sum('amount');
        $purchase_price = Invoice::find($invoice_id)->bellPurchase()->where('product_id',$id)->first();
        $availableRefundProduct = ($purchase_price->amount - $productRefundAmount);
        return response()->json(['purchase_price' => $purchase_price,'available' =>$availableRefundProduct]);
    }

    public function print($id)
    {
        $invoice_refund = InvoiceRefund::find($id);
        return view('invoices-refund-purchase.print', compact('invoice_refund'));
    }
}
