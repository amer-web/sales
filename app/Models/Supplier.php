<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Supplier extends Model
{
    use SearchableTrait;
    protected $searchable = [
        'columns' => [
            'suppliers.name' => 10,
        ],
    ];
   protected $guarded = [];

   public function invoices()
   {
       return $this->hasMany(Invoice::class);
   }
    public function payments()
    {
        return $this->hasManyThrough(Payments::class, Invoice::class);
    }
    public function invoicesRefund()
    {
        return $this->hasManyThrough(InvoiceRefund::class,Invoice::class);
    }
}
