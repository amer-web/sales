<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class InvoiceRefund extends Model
{
    use SoftDeletes;
    protected $guarded = [];


    public function salesRefund()
    {
        return $this->hasMany(SalesRefund::class);
    }
    public function purchaseRefund()
    {
        return $this->hasMany(PurchaseRefund::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function setDiscountAttribute($value)
    {
        $this->attributes['discount'] = ($value == null ? 0.00 : $value);
    }
    public function setVatAttribute($value)
    {
        $this->attributes['vat'] = ($value == null ? 0.00 : $value);
    }
}
