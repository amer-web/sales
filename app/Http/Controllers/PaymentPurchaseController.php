<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\MethodPayment;
use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentPurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payments::where('paid', '!=', 0)->whereHas('invoice',function ($q){
            $q->where('type',2);
        })->orderBy('created_at','desc')->get();
        return view('payments-purchase.index',compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $invoice = Invoice::find($id);
        $method_payments = MethodPayment::get();
        return view('payments-purchase.create', compact('invoice','method_payments'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $this->validate($request, [
            'paid' => 'required|numeric|min:1',
            'method_payment_id' => 'required'
        ], [
            'paid.required' => 'يرجى إدخال المبلغ',
            'paid.numeric' => 'يرجى ادخال المبلغ بشكل صحيح',
            'paid.min' => 'يجب أن يكون المبلغ أكثر أو يساوى 1',
            'method_payment_id.required' => 'يرجى ادخال طريقة الدفع'
        ]);

        Payments::create([
            'invoice_id' => $request->id,
            'paid' => $request->paid,
            'method_payment_id' => $request->method_payment_id,
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('purchase-invoice.show', $request->id)->with('success', 'تم إضافة عملية الدفع بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Payments $payment_purchase)
    {
        $payment = $payment_purchase;
        return view('payments-purchase.view',compact('payment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
      $payment = Payments::find($id);
      $method_payments = MethodPayment::get();
      $invoice = $payment->invoice;
      return view('payments-purchase.edit', compact('payment','invoice','method_payments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Payments $payment_purchase)
    {
       $payment_purchase->paid = $request->paid;
       $payment_purchase->method_payment_id = $request->method_payment_id;
       $payment_purchase->save();
        return redirect()->route('purchase-invoice.show', $payment_purchase->invoice->id)->with('success', 'تم تعديل عملية الدفع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payments $payment_purchase)
    {
        $payment_purchase->delete();
        return redirect()->back()->with('success', 'تم حذف عملية الدفع بنجاح');
    }
}
