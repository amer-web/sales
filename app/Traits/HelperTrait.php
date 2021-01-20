<?php


namespace App\Traits;


use App\Models\Invoice;

trait HelperTrait
{
    public function setStatus()
    {
       $invoices = Invoice::get();
       foreach ($invoices as $invoice){
          $total_due = $invoice->total_due;
          $payments = $invoice->payments()->sum('paid');
          $totalRefund = $invoice->invoicesRefund()->sum('total_refund');
          if($payments == 0){
              $invoice->status = 0;
              $invoice->save();
          }
          if (($total_due - $totalRefund) > $payments && $payments != 0){
              $invoice->status = 2;
              $invoice->save();
          }
           if (($total_due - $totalRefund) == $payments){
               $invoice->status = 1;
               $invoice->save();
           }
           if (($total_due - $totalRefund) < $payments && $payments != 0){
               $invoice->status = 3;
               $invoice->save();
           }
           if($invoice->status == 0 || $invoice->status == 2){
               if($invoice->due_date != null){
                   if(date('Y-m-d') >= $invoice->due_date){
                       $invoice->status = 4;
                       $invoice->save();
                   }
               }
           }
           if($total_due == $totalRefund){
               $invoice->status = 5;
               $invoice->save();
           }


       }

    }
}
