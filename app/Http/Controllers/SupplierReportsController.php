<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierReportsController extends Controller
{
    public function supplier_balance()
    {
        $suppliers = Supplier::get();
        return view('reports.supplier.supplier_balance', compact('suppliers'));
    }
    public function supplier_balance_search()
    {
        $suppliersAccounts = Supplier::query();
        $suppliers = Supplier::get();
        if (request()->supplier_id != null) {
            if (request()->supplier_id == 0) {
                $suppliersAccounts = Supplier::query();
            } else {
                $suppliersAccounts = Supplier::where('id', request()->supplier_id);
            }
        }
        $supplier_id_request = request()->supplier_id;
        if ($supplier_id_request == null) {
            $supplier_id_request = -1;
        }
        if (request()->start_date == null) {
            $start_date = $suppliersAccounts->orderBy('created_at', 'asc')->pluck('created_at')->first()->format('Y-m-d');
        } else {
            $start_date = request()->start_date;
        }
        if (request()->end_date == null) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = request()->end_date;
        }

        $balance_before = $suppliersAccounts->with(['invoices' => function ($q) use ($start_date) {
            $q->whereDate('invoices.invoice_date', '<', $start_date);
        }])->with(['invoicesRefund' => function ($q) use ($start_date) {
            $q->whereDate('invoice_refunds.invoice_date', '<', $start_date);
        }])->with(['payments' => function ($q) use ($start_date) {
            $q->whereDate(DB::raw('DATE(payments.created_at)'), '<', $start_date);
        }]);

        $balance_before = $balance_before->get();
        $suppliersAccounts->with(['invoices' => function ($q) use ($start_date, $end_date) {
            $q->whereBetween('invoices.invoice_date', [$start_date, $end_date]);
        }])->with(['invoicesRefund' => function ($q) use ($start_date, $end_date) {
            $q->whereBetween('invoice_refunds.invoice_date', [$start_date, $end_date]);
        }])->with(['payments' => function ($q) use ($start_date, $end_date) {
            $q->whereBetween(DB::raw('DATE(payments.created_at)'), [$start_date, $end_date]);
        }]);
        $suppliersAccounts = $suppliersAccounts->get();
        return view('reports.supplier.supplier_balance', compact('suppliers', 'suppliersAccounts', 'balance_before', 'start_date', 'end_date', 'supplier_id_request'));
    }

    public function supplier_guide()
    {
        $suppliers = Supplier::get();
        return view('reports.supplier.supplier_guide', compact('suppliers'));
    }
    public function supplier_guide_search()
    {
        $suppliers = Supplier::get();
        $suppliersAccounts = Supplier::orderBy('created_at','desc');
        if (request()->supplier_id != null) {
            if (request()->supplier_id == 0) {
                $suppliersAccounts = Supplier::query();
            } else {
                $suppliersAccounts = Supplier::where('id', request()->supplier_id);
            }
        }
        $suppliersAccounts = $suppliersAccounts->get();

        $supplier_id_request = request()->supplier_id;
        if ($supplier_id_request == null) {
            $supplier_id_request = -1;
        }
        return view('reports.supplier.supplier_guide', compact('suppliers','suppliersAccounts','supplier_id_request'));

    }


    public function supplier_payments()
    {
        $suppliers =Supplier::get();
        return view('reports.supplier.supplier_payments',compact('suppliers'));
    }
    public function supplier_payments_search()
    {
        $suppliersAccounts = Supplier::query();
        $suppliers = Supplier::get();
        if (request()->supplier_id != null) {
            if (request()->supplier_id == 0) {
                $suppliersAccounts = Supplier::query();
            } else {
                $suppliersAccounts = Supplier::where('id', request()->supplier_id);
            }
        }
        $supplier_id_request = request()->supplier_id;

        if ($supplier_id_request == null) {
            $supplier_id_request = -1;
        }

        if (request()->start_date == null) {
            $start_date = $suppliersAccounts->orderBy('created_at', 'asc')->pluck('created_at')->first()->format('Y-m-d');
        } else {
            $start_date = request()->start_date;
        }
        if (request()->end_date == null) {
            $end_date = date('Y-m-d');
        } else {
            $end_date = request()->end_date;
        }
            $suppliersAccounts->whereHas('payments',function($q)use($start_date,$end_date){
                $q->whereBetween(DB::raw('DATE(payments.created_at)'), [$start_date, $end_date]);
            })->with(['payments'=>function($q)use($start_date,$end_date){
                $q->whereBetween(DB::raw('DATE(payments.created_at)'), [$start_date, $end_date])->orderBy('created_at','desc');
            }]);
        $suppliersAccounts = $suppliersAccounts->get();

         $totalPaid = 0;
        foreach ($suppliersAccounts as $clientPayment)
        {
            $totalPaid += $clientPayment->payments->sum('paid');
        }

        return view('reports.supplier.supplier_payments',compact('suppliers','suppliersAccounts','start_date','end_date','supplier_id_request','totalPaid'));

    }
}
