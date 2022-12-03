<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class parkingReview extends Model
{
    protected $fillable=['user_id','product_id','rate','review','status'];

    public function user_info(){
        return $this->hasOne('App\User','id','user_id');
    }

    public static function getAllReview(){
        return parkingReview::with('user_info')->paginate(10);
    }
    public static function getAllUserReview(){
        return parkingReview::where('user_id',auth()->user()->id)->with('user_info')->paginate(10);
    }

    public function parking(){
        return $this->hasOne(parking::class,'id','product_id');
    }

}
