<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\MethodPayment;
use App\Models\Payments;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payments::where('paid', '!=', 0)->whereHas('invoice',function ($q){
            $q->where('type',1);
        })->orderBy('created_at','desc')->get();
        return view('payments.index',compact('payments'));
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
        return view('payments.create', compact('invoice','method_payments'));
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
        $invoice = Invoice::find($request->id);
        if(($invoice->total_due - $invoice->invoicesRefund->sum('total_refund')) <= $invoice->payments->sum('paid'))
        {
            return redirect()->route('invoice.show', $request->id)->with('error', 'هذه الفاتورة مدفوعة لا يتم عليها اى دفع آخر');
        }
        Payments::create([
            'invoice_id' => $request->id,
            'paid' => $request->paid,
            'method_payment_id' => $request->method_payment_id,
            'user_id' => auth()->user()->id,
        ]);
        return redirect()->route('invoice.show', $request->id)->with('success', 'تم إضافة عملية الدفع بنجاح');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Payments $payment)
    {
        return view('payments.view',compact('payment'));
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
      return view('payments.edit', compact('payment','invoice','method_payments'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Payments $payment)
    {
       $payment->paid = $request->paid;
       $payment->method_payment_id = $request->method_payment_id;
       $payment->save();
        return redirect()->route('invoice.show', $payment->invoice->id)->with('success', 'تم تعديل عملية الدفع بنجاح');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payments $payment)
    {
        $payment->delete();
        return redirect()->back()->with('success', 'تم حذف عملية الدفع بنجاح');
    }
}
