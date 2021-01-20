<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

class Invoice extends Model
{
    use SoftDeletes;

    protected $guarded = [];


    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function bellSales()
    {
        return $this->belongsToMany(BellSale::class, 'invoice_bell_sale');
    }

    public function bellPurchase()
    {
        return $this->hasMany(BellPurchase::class);
    }

    public function payments()
    {
        return $this->hasMany(Payments::class);
    }

    public function invoicesRefund()
    {
        return $this->hasMany(InvoiceRefund::class);
    }


    public function setStatus()
    {
        $status = $this->status;
        if ($status == 1) {
            return 'مدفوعة';
        } elseif ($status == 2) {
            return 'مدفوعة جزئياً';
        } elseif ($status == 3) {
            return 'مدفوعة بزيادة';
        } elseif ($status == 4) {
            return 'فاتورة متأخرة';
        } elseif ($status == 5) {
            return 'مرتجع كلى';
        } else {
            return 'غير مدفوعة';
        }
    }

    public function colorStatus()
    {
        $status = $this->status;
        if ($status == 1) {
            return 'success';
        } elseif ($status == 2) {
            return 'info';
        } elseif ($status == 3) {
            return 'warning';
        } elseif ($status == 4) {
            return 'danger';
        } elseif ($status == 5) {
            return 'gray-500';
        }
        else {
            return 'gray-300';
        }

    }

    public function invoiceDate()
    {
        $date = $this->invoice_date;
        $date = explode('-', $date);
        $date = Carbon::createFromDate($date[0], $date[1], $date[2]);
        if ($date->isToday()) {
            return 'اليوم';
        } elseif ($date->isYesterday()) {
            return 'أمس';
        } else {
            return $date->format('d-m-Y');
        }

    }

    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = ($value == null ? 0.00 : $value);
    }

    public function setVatAttribute($value)
    {
        $this->attributes['vat'] = ($value == null ? 0.00 : $value);
    }
//    public function setValueRateAttribute($value)
//    {
//        $this->attributes['value_rate'] = ($value == null ? 0.00 : $value);
//    }

}
