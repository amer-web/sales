<?php

namespace App\Http\Controllers;

use App\Models\BellSale;
use App\Models\Invoice;
use App\Models\Payments;
use App\Models\Product;
use App\Models\SalesRefund;
use App\Traits\HelperTrait;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    use HelperTrait;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
       return $invoice = Product::find(2)->bellSales()->sum('total');
        return view('home');
    }
    public function home_page()
    {
        $this->setStatus();
        $totalSales = BellSale::sum('total') - SalesRefund::sum('total');
        $totalDue =  $totalSales - Payments::whereHas('invoice',function ($q){
            $q->where('type',1);
            })->sum('paid');
        $invoicesSales = Invoice::where('type',1)->where('status','!=',5)->get()->count();
        $invoicesPurchase = Invoice::where('type',2)->where('status','!=',5)->get()->count();
        $invoicePaid = Invoice::where('type',1)->where('status',1)->count();
        $invoiceUnPaid = Invoice::where('type',1)->where('status',0)->count();
        $invoicePartPaid = Invoice::where('type',1)->where('status',2)->count();
        $chartjs = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 400, 'height' => 200])
            ->labels(['مدفوعة', 'غير مدفوعة','مدفوعة جزئياً'])
            ->datasets([
                [
                    'backgroundColor' => ['#36A2EB','#FF6384', ],
                    'hoverBackgroundColor' => ['#36A2EB','#FF6384' ],
                    'data' => [$invoicePaid, $invoiceUnPaid,$invoicePartPaid]
                ]
            ])
            ->options([]);

        $invoices = Invoice::where('type',1)->orderBy('created_at', 'desc')->get()->take(5);
        return view('index',compact('totalSales','totalDue','invoicesSales','invoicesPurchase','chartjs','invoices'));
    }
}
