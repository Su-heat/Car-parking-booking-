<?php

namespace App\Models;
use App\Models\parking;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable=['title','slug','status'];

    // public static function getparkingByBrand($id){
    //     return parking::where('brand_id',$id)->paginate(10);
    // }
    public function parkings(){
        return $this->hasMany('App\Models\parking','brand_id','id')->where('status','active');
    }
    public static function getparkingByBrand($slug){
        // dd($slug);
        return Brand::with('parkings')->where('slug',$slug)->first();
        // return parking::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
}
