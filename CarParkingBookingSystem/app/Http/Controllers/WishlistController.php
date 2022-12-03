<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\parking;
use App\Models\Wishlist;
class WishlistController extends Controller
{
    protected $parking=null;
    public function __construct(parking $parking){
        $this->parking=$parking;
    }

    public function wishlist(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('error','Invalid parkings');
            return back();
        }        
        $parking = parking::where('slug', $request->slug)->first();
        // return $parking;
        if (empty($parking)) {
            request()->session()->flash('error','Invalid parkings');
            return back();
        }

        $already_wishlist = Wishlist::where('user_id', auth()->user()->id)->where('cart_id',null)->where('product_id', $parking->id)->first();
        // return $already_wishlist;
        if($already_wishlist) {
            request()->session()->flash('error','You already placed in wishlist');
            return back();
        }else{
            
            $wishlist = new Wishlist;
            $wishlist->user_id = auth()->user()->id;
            $wishlist->product_id = $parking->id;
            $wishlist->price = ($parking->price-($parking->price*$parking->discount)/100);
            $wishlist->quantity = 1;
            $wishlist->amount=$wishlist->price*$wishlist->quantity;
            if ($wishlist->parking->stock < $wishlist->quantity || $wishlist->parking->stock <= 0) return back()->with('error','SORRY! NO MORE HOUR LEFT FOR THIS PARKING LOT');
            $wishlist->save();
        }
        request()->session()->flash('success','PARKING LOT Added For Later Booking!');
        return back();       
    }  
    
    public function wishlistDelete(Request $request){
        $wishlist = Wishlist::find($request->id);
        if ($wishlist) {
            $wishlist->delete();
            request()->session()->flash('success','PARKING LOT Successfully removed');
            return back();  
        }
        request()->session()->flash('error','Error please try again');
        return back();       
    }     
}
