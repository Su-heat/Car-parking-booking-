<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable=['user_id','product_id','order_id','quantity','amount','price','status'];
    
    public static function getAllparkingFromCart(){
        return Cart::with('parking')->where('user_id',auth()->user()->id)->get();
    }

    public function parking()
    {
        return $this->belongsTo(parking::class, 'product_id');
    }
    public function order(){
        return $this->belongsTo(Order::class,'order_id');
    }
}
