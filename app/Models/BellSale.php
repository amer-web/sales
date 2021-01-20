<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BellSale extends Model
{
    use SoftDeletes;
    protected $guarded = [];

    public function invoices()
    {
        return $this->belongsToMany(Invoice::class, 'invoice_bell_sale');
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
