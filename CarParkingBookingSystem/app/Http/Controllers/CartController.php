<?php

namespace App\Http\Controllers;
use Auth;
use Illuminate\Http\Request;
use App\Models\parking;
use App\Models\Wishlist;
use App\Models\Cart;
use Illuminate\Support\Str;
use Helper;
class CartController extends Controller
{
    protected $parking=null;
    public function __construct(parking $parking){
        $this->parking=$parking;
    }

    public function addToCart(Request $request){
        // dd($request->all());
        if (empty($request->slug)) {
            request()->session()->flash('error','Invalid Parking');
            return back();
        }        
        $parking = parking::where('slug', $request->slug)->first();
        // return $parking;
        if (empty($parking)) {
            request()->session()->flash('error','Invalid Parking');
            return back();
        }

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $parking->id)->first();
        // return $already_cart;
        if($already_cart) {
            // dd($already_cart);
            $already_cart->quantity = $already_cart->quantity + 1;
            $already_cart->amount = $parking->price+ $already_cart->amount;
            // return $already_cart->quantity;
            if ($already_cart->parking->stock < $already_cart->quantity || $already_cart->parking->stock <= 0) return back()->with('error','SORRY! NO MORE HOUR LEFT FOR THIS PARKING LOT');
            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $parking->id;
            $cart->price = ($parking->price-($parking->price*$parking->discount)/100);
            $cart->quantity = 1;
            $cart->amount=$cart->price*$cart->quantity;
            if ($cart->parking->stock < $cart->quantity || $cart->parking->stock <= 0) return back()->with('error','SORRY! NO MORE HOUR LEFT FOR THIS PARKING LOT');
            $cart->save();
            $wishlist=Wishlist::where('user_id',auth()->user()->id)->where('cart_id',null)->update(['cart_id'=>$cart->id]);
        }
        request()->session()->flash('success','PARKING LOT Added! Go to SELECTED PARKINGS');
        return back();       
    }  

    public function singleAddToCart(Request $request){
        $request->validate([
            'slug'      =>  'required',
            'quant'      =>  'required',
        ]);
        // dd($request->quant[1]);


        $parking = parking::where('slug', $request->slug)->first();
        if($parking->stock <$request->quant[1]){
            return back()->with('error','SORRY! NO MORE HOUR LEFT FOR THIS PARKING LOT');
        }
        if ( ($request->quant[1] < 1) || empty($parking) ) {
            request()->session()->flash('error','Invalid parkings');
            return back();
        }    

        $already_cart = Cart::where('user_id', auth()->user()->id)->where('order_id',null)->where('product_id', $parking->id)->first();

        // return $already_cart;

        if($already_cart) {
            $already_cart->quantity = $already_cart->quantity + $request->quant[1];
            // $already_cart->price = ($parking->price * $request->quant[1]) + $already_cart->price ;
            $already_cart->amount = ($parking->price * $request->quant[1])+ $already_cart->amount;

            if ($already_cart->parking->stock < $already_cart->quantity || $already_cart->parking->stock <= 0) return back()->with('error','SORRY! NO MORE HOUR LEFT FOR THIS PARKING LOT');

            $already_cart->save();
            
        }else{
            
            $cart = new Cart;
            $cart->user_id = auth()->user()->id;
            $cart->product_id = $parking->id;
            $cart->price = ($parking->price-($parking->price*$parking->discount)/100);
            $cart->quantity = $request->quant[1];
            $cart->amount=($parking->price * $request->quant[1]);
            if ($cart->parking->stock < $cart->quantity || $cart->parking->stock <= 0) return back()->with('error','SORRY! NO MORE HOUR LEFT FOR THIS PARKING LOT');
            // return $cart;
            $cart->save();
        }
        request()->session()->flash('success','PARKING LOT Successfully Added! Please Go to SELECTED PARKINGS');
        return back();       
    } 
    
    public function cartDelete(Request $request){
        $cart = Cart::find($request->id);
        if ($cart) {
            $cart->delete();
            request()->session()->flash('success','Parking removed!');
            return back();  
        }
        request()->session()->flash('error','Error please try again');
        return back();       
    }     

    public function cartUpdate(Request $request){
        // dd($request->all());
        if($request->quant){
            $error = array();
            $success = '';
            // return $request->quant;
            foreach ($request->quant as $k=>$quant) {
                // return $k;
                $id = $request->qty_id[$k];
                // return $id;
                $cart = Cart::find($id);
                // return $cart;
                if($quant > 0 && $cart) {
                    // return $quant;

                    if($cart->parking->stock < $quant){
                        request()->session()->flash('error','SORRY! NO MORE HOUR LEFT FOR THIS PARKING LOT');
                        return back();
                    }
                    $cart->quantity = ($cart->parking->stock > $quant) ? $quant  : $cart->parking->stock;
                    // return $cart;
                    
                    if ($cart->parking->stock <=0) continue;
                    $after_price=($cart->parking->price-($cart->parking->price*$cart->parking->discount)/100);
                    $cart->amount = $after_price * $quant;
                    // return $cart->price;
                    $cart->save();
                    $success = 'Sucessfully updated!';
                }else{
                    $error[] = 'Invalid!';
                }
            }
            return back()->with($error)->with('success', $success);
        }else{
            return back()->with('Invalid!');
        }    
    }


    public function checkout(Request $request){
        return view('frontend.pages.checkout');
    }
}
