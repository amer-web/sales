<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Client extends Model
{
    use SearchableTrait;
    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'clients.name' => 10,
        ],
    ];

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
