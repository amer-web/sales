<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $suppliers = Supplier::orderBy('created_at','desc');
        if(request()->keywords != null)
        {
            $suppliers =  $suppliers->search(request()->keywords);
        }
        $suppliers = $suppliers->paginate(6);
        return view('suppliers.index', compact('suppliers'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('suppliers.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {
        $supplier   = Supplier::create([
                'name' => $request->name,
                'email'=> $request->email,
                'address'=> $request->address,
                'phone'=> $request->phone
            ]);
            return redirect()->back()->with('success', 'تم إضافة المورد '.$supplier->name. ' بنجاح ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Supplier $supplier)
    {

        $letBell = $supplier->invoices()->where('status', 4)->count();
        $listPaid = $supplier->payments()->where('paid', '!=', 0)->orderBy('created_at','asc')->get();
        $invoices = $supplier->invoices()->orderBy('created_at','desc')->get();
        $payments = $supplier->payments()->where('paid', '!=',0)->orderBy('created_at', 'desc')->paginate(6);
        return view('suppliers.view', compact('supplier', 'letBell', 'listPaid','invoices','payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', compact('supplier'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Supplier $supplier)
    {
        $this->validate($request, [
            'name' => 'required|string',
            "email"=> "email|unique:clients,email,$supplier->id|nullable",
            'address'=> 'string|nullable',
            'phone'=> 'string|numeric|regex:/^(01)[0-9]{9}/i|nullable'
        ],[
            'name.required' => 'يرجى إدخال اسم العميل',
            'name.string' => 'يرجى إدخال العنوان بشكل صحيح',
            'email.email' => 'يرجى إدخال الايميل بشكل صحيح',
            'email.unique' => ' يرجى استخدام ايميل آخر لان الايميل هذا موجود بالفعل',
            'address.string' => 'يرجى إدخال العنوان بشكل صحيح',
            'phone.string' => 'يرجى إدخال رقم الهاتف بشكل صحيح',
            'phone.numeric' => 'يرجى إدخال رقم الهاتف بشكل صحيح',
            'phone.regex' => 'يرجى إدخال رقم الهاتف بشكل صحيح',
        ]);
        $supplier->update([
            'name' => $request->name,
            'email'=> $request->email,
            'address'=> $request->address,
            'phone'=> $request->phone
        ]);
        return redirect()->route('supplier.index')->with('success', 'تم تعديل المورد ' . $supplier->name . ' بنجاح ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Supplier $supplier)
    {

        if(!$supplier->invoices->isEmpty()){
         return redirect()->back()->with('error', 'لم يتم حذف المورد ' . $supplier->name . ' لأن حسابه به حركات ');
        }
        $supplier->delete();
        return redirect()->back()->with('success', 'تم حذف المورد ' . $supplier->name . ' بنجاح ');
    }

    public function print(Supplier $supplier)
    {
        $accountPayments = $supplier->payments()->where('paid','!=',0)->get();
        $accountInvoices = $supplier->invoices()->get();
        $accounts = [];
        foreach ($accountInvoices as $acc){
            $accounts[] = $acc;
        }
        foreach ($accountPayments as $ac){
            $accounts[] = $ac;
        }
        $accounts = collect($accounts)->sortBy('created_at');
        return view('suppliers.print', compact('accounts','supplier'));
    }

}
