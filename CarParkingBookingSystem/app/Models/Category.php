<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable=['title','slug','summary','photo','status','is_parent','parent_id','added_by'];

    public function parent_info(){
        return $this->hasOne('App\Models\Category','id','parent_id');
    }
    public static function getAllCategory(){
        return  Category::orderBy('id','DESC')->with('parent_info')->paginate(10);
    }

    public static function shiftChild($cat_id){
        return Category::whereIn('id',$cat_id)->update(['is_parent'=>1]);
    }
    public static function getChildByParentID($id){
        return Category::where('parent_id',$id)->orderBy('id','ASC')->pluck('title','id');
    }

    public function child_cat(){
        return $this->hasMany('App\Models\Category','parent_id','id')->where('status','active');
    }
    public static function getAllParentWithChild(){
        return Category::with('child_cat')->where('is_parent',1)->where('status','active')->orderBy('title','ASC')->get();
    }
    public function parkings(){
        return $this->hasMany('App\Models\parking','cat_id','id')->where('status','active');
    }
    public function sub_parkings(){
        return $this->hasMany('App\Models\parking','child_cat_id','id')->where('status','active');
    }
    public static function getparkingByCat($slug){
        // dd($slug);
        return Category::with('parkings')->where('slug',$slug)->first();
        // return parking::where('cat_id',$id)->where('child_cat_id',null)->paginate(10);
    }
    public static function getparkingBySubCat($slug){
        // return $slug;
        return Category::with('sub_parkings')->where('slug',$slug)->first();
    }
    public static function countActiveCategory(){
        $data=Category::where('status','active')->count();
        if($data){
            return $data;
        }
        return 0;
    }
}
