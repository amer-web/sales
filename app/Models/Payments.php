<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
   protected $guarded = [];


   public function invoice()
   {
       return $this->belongsTo(Invoice::class);
   }
   public function user()
   {
       return $this->belongsTo(User::class);
   }
    public function methodPayment()
    {
        return $this->belongsTo(MethodPayment::class);
    }
    public function setPaidAttribute($value)
    {
        $this->attributes['paid'] = ($value == null ? 0.00 : $value);
    }
}
