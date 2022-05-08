<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customer;
use App\CartItem;
use App\Product;
use App\Components\Helper\ImageProcessing;
class CartController extends Controller
{

    public function showCart(Request $request) {
        //$cartItems = $request->user()->cartItems;
        return view('customer.cart');
    }

    public function showCheckout(Request $request) {
        // $cartItems = $request->user()->cartItems;
        // if ($cartItems->count() == 0) {
        //     abort(404,"You need to have at least 1 product in your cart.");
        // }
        $addresses =  $request->user()->addresses;
        $temporaryAmount = $request->user()->cartItems->reduce(
            function($total,$item)
            {
                return $total + $item->product->product_price * $item->quantity;
            },
            0);
        return view('customer.checkout',[
            'temporaryAmount' => $temporaryAmount,
            'addresses' =>$addresses,
            //'cartItem' => $cartItems,
            'user' => $request->user(),
        ]);
    }
}
