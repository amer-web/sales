<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Product extends Model
{
    use SearchableTrait;
    protected $guarded = [];
    protected $searchable = [
        'columns' => [
            'products.name' => 10,
        ],
    ];
    public function bellSales()
    {
        return $this->hasMany(BellSale::class);
    }

    public function bellPurchases()
    {
        return $this->hasMany(BellPurchase::class);
    }

    public function sellingPrice()
    {
        return $this->hasOne(SellingPrice::class);
    }
}
