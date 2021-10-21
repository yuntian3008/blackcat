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
        $cartItems = $request->user()->cartItems;
        return view('customer.cart',['data' => $cartItems]);
    }

    public function showCheckout(Request $request) {
        return view('customer.checkout',[
            'shipping' => $request->shipping,
            'temporaryAmount' => $request->temporaryAmount,
            'totalAmount' => $request->totalAmount,
            'addresses' => $request->user()->addresses,
            'cartItem' => $request->user()->cartItems,
            'user' => $request->user(),
        ]);
    }

    public function index(Request $request)
    {
        $customer = Customer::where('firebase_uid', $request->secret)->firstOrFail();
        $cartItems = $customer->cartItems;
        foreach ($cartItems as $item) {
            $item["product"] = $item->product;
            $item["product"]->product_image = ImageProcessing::getURL($item["product"]->product_image,'sm');
        }
        return $cartItems;
    }

    public function changeQty(Request $request) {
        $customer = Customer::where('firebase_uid', $request->secret)->firstOrFail();
        $cartItem = $customer->cartItems()->where('product_id',$request->product_id)->firstOrFail();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        return $cartItem;
    }

    public function removeItem(Request $request) {
        $customer = Customer::where('firebase_uid', $request->secret)->firstOrFail();
        $cartItem = $customer->cartItems()->where('product_id',$request->product_id)->firstOrFail();
        $cartItem->delete();
        return "SUCCESS";
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // CHECK REQUEST
        $customer = Customer::where('firebase_uid', $request->secret)->firstOrFail();
        $product = Product::where('product_visible',1)->where('id',$request->product_id)->firstOrFail();

        // VALIDATE
        if ($request->quantity <= 0) 
            return response('Quantity isn\'t invalid', 400);

        // neu trung thi tang len 1
        $find = $customer->cartItems()->where('product_id',$request->product_id);
        if ($find->count())
            $find->update(['quantity' => $request->quantity + $find->first()->quantity]);

        else $customer->cartItems()->create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);
        return $customer->cartItems;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
