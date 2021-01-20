<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClientRequest;
use App\Models\Client;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $clients = Client::query();
        if(request()->keywords != null)
        {
         $clients =  $clients->search(request()->keywords);
        }
        $clients = $clients->paginate(6);
        return view('clients.index', compact('clients'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('clients.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientRequest $request)
    {

        $client   = Client::create([
                'name' => $request->name,
                'email'=> $request->email,
                'address'=> $request->address,
                'phone'=> $request->phone
            ]);
            return redirect()->back()->with('success', 'تم إضافة العميل '.$client->name. ' بنجاح ');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Client $client)
    {
        $letBell = $client->invoices()->where('type',1)->where('status', 4)->count();
        $listPaid = $client->payments()->whereHas('invoice', function($q){
            $q->where('type',1);
        })->where('paid', '!=', 0)->orderBy('created_at','asc')->get();
        $invoices = $client->invoices()->where('type',1)->orderBy('created_at','desc')->get();
        $payments = $client->payments()->whereHas('invoice', function($q){
            $q->where('type',1);
        })->where('paid', '!=',0)->orderBy('created_at', 'desc')->paginate(6);
        return view('clients.view', compact('client', 'letBell', 'listPaid','invoices','payments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Client $client)
    {
        return view('clients.edit', compact('client'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,Client $client)
    {
        $this->validate($request, [
            'name' => 'required|string',
            "email"=> "email|unique:clients,email,$client->id|nullable",
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
        $client->update([
            'name' => $request->name,
            'email'=> $request->email,
            'address'=> $request->address,
            'phone'=> $request->phone
        ]);
        return redirect()->route('client.index')->with('success', 'تم تعديل العميل ' . $client->name . ' بنجاح ');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Client $client)
    {
        if(!$client->invoices->isEmpty()){
         return redirect()->back()->with('error', 'لم يتم حذف العميل ' . $client->name . ' لأن حسابه به حركات ');
        }
        $client->delete();
        return redirect()->back()->with('success', 'تم حذف العميل ' . $client->name . ' بنجاح ');
    }

    public function print(Client $client)
    {
        $accountPayments = $client->payments()->whereHas('invoice',function($q){
            $q->where('type',1);
        })->where('paid','!=',0)->get();
        $accountInvoices = $client->invoices()->where('type',1)->get();
        $accountInvoicesRefund = $client->invoicesRefund;
        $accounts = [];
        foreach ($accountInvoices as $acc){
            $accounts[] = $acc;
        }
        foreach ($accountPayments as $ac){
            $accounts[] = $ac;
        }
        foreach ($accountInvoicesRefund as $ac){
            $accounts[] = $ac;
        }
        $accounts = collect($accounts)->sortBy('created_at');
        return view('clients.print', compact('accounts','client'));
    }

}
