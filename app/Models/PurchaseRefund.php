<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PurchaseRefund extends Model
{
    protected $guarded = [];
    use SoftDeletes;
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    public function invoiceRefund()
    {
        return $this->belongsTo(InvoiceRefund::class);
    }
}
