<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClientReportsController extends Controller
{
    public function client_balance()
    {
        $clients = Client::get();
        return view('reports.client.client_balance', compact('clients'));
    }

    public function client_balance_search()
    {
        $clientsAccounts = Client::query();
        $clients = Client::get();
        if (request()->client_id != null) {
            if (request()->client_id == 0) {
                $clientsAccounts = Client::query();
            } else {
                $clientsAccounts = Client::where('id', request()->client_id);
            }
        }
        $client_id_request = request()->client_id;
        if ($client_id_request == null) {
            $client_id_request = -1;
        }
        if (request()->start_date == null) {
            $start_date = $clientsAccounts->orderBy('created_at', 'asc')->pluck('created_at')->first()->format('Y-m-d');
        } else {
            $start_date = request()->start_date;
        }
        if (request()->end_date == null) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = request()->end_date;
        }

        $balance_before = $clientsAccounts->with(['invoices' => function ($q) use ($start_date) {
            $q->whereDate('invoices.invoice_date', '<', $start_date);
        }])->with(['invoicesRefund' => function ($q) use ($start_date) {
            $q->whereDate('invoice_refunds.invoice_date', '<', $start_date);
        }])->with(['payments' => function ($q) use ($start_date) {
            $q->whereDate(DB::raw('DATE(payments.created_at)'), '<', $start_date);
        }]);

        $balance_before = $balance_before->get();
        $clientsAccounts->with(['invoices' => function ($q) use ($start_date, $end_date) {
            $q->whereBetween('invoices.invoice_date', [$start_date, $end_date]);
        }])->with(['invoicesRefund' => function ($q) use ($start_date, $end_date) {
            $q->whereBetween('invoice_refunds.invoice_date', [$start_date, $end_date]);
        }])->with(['payments' => function ($q) use ($start_date, $end_date) {
            $q->whereBetween(DB::raw('DATE(payments.created_at)'), [$start_date, $end_date]);
        }]);
        $clientsAccounts = $clientsAccounts->get();
        return view('reports.client.client_balance', compact('clients', 'clientsAccounts', 'balance_before', 'start_date', 'end_date', 'client_id_request'));
    }

    public function client_guide()
    {
        $clients = Client::get();
        return view('reports.client.client_guide', compact('clients'));
    }
    public function client_guide_search()
    {
        $clients = Client::get();
        $clientsAccounts = Client::orderBy('created_at','desc');
        if (request()->client_id != null) {
            if (request()->client_id == 0) {
                $clientsAccounts = Client::query();
            } else {
                $clientsAccounts = Client::where('id', request()->client_id);
            }
        }
        $clientsAccounts = $clientsAccounts->get();

        $client_id_request = request()->client_id;
        if ($client_id_request == null) {
            $client_id_request = -1;
        }
        return view('reports.client.client_guide', compact('clients','clientsAccounts','client_id_request'));

    }

    public function client_payments()
    {
        $clients =Client::get();
        return view('reports.client.client_payments',compact('clients'));
    }
    public function client_payments_search()
    {
        $clientsAccounts = Client::query();
        $clients = Client::get();
        if (request()->client_id != null) {
            if (request()->client_id == 0) {
                $clientsAccounts = Client::query();
            } else {
                $clientsAccounts = Client::where('id', request()->client_id);
            }
        }
        $client_id_request = request()->client_id;
        if ($client_id_request == null) {
            $client_id_request = -1;
        }
        if (request()->start_date == null) {
            $start_date = $clientsAccounts->orderBy('created_at', 'asc')->pluck('created_at')->first()->format('Y-m-d');
        } else {
            $start_date = request()->start_date;
        }
        if (request()->end_date == null) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = request()->end_date;
        }
            $clientsAccounts->whereHas('payments',function($q)use($start_date,$end_date){
                $q->whereBetween(DB::raw('DATE(payments.created_at)'), [$start_date, $end_date]);
            })->with(['payments'=>function($q)use($start_date,$end_date){
                $q->whereBetween(DB::raw('DATE(payments.created_at)'), [$start_date, $end_date])->orderBy('created_at','desc');
            }]);
        $clientsAccounts = $clientsAccounts->get();

         $totalPaid = 0;
        foreach ($clientsAccounts as $clientPayment)
        {
            $totalPaid += $clientPayment->payments->sum('paid');
        }

        return view('reports.client.client_payments',compact('clients','clientsAccounts','start_date','end_date','client_id_request','totalPaid'));

    }
}
