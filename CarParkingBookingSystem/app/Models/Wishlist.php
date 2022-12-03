<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable=['user_id','product_id','cart_id','price','amount','quantity'];

    public function parking(){
        return $this->belongsTo(parking::class,'product_id');
    }
}
