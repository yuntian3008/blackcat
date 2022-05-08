<?php

namespace App\Http\Controllers\Api\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Customer;
use Carbon\Carbon;
use App\CartItem;
use App\Product;
use App\Components\Helper\ImageProcessing;

class CartsController extends Controller
{
    protected $user = null;

    function __construct() {
        $this->user = Auth::guard('web_api')->user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $cartItems = $this->user->cartItems;
        // dd($request->all());
        // foreach ($cartItems as $item) {
        //     $item["product"] = $item->product;
        //     $item["product"]->product_image = ImageProcessing::getURL($item["product"]->product_image,'sm');
        // }
        // return $cartItems;
        $cartItems = $request->all();

        foreach ($cartItems as $index => $item) {
            $item = json_decode($item);
            $item->product = Product::find($item->product_id);
            $cartItems[$index] = $item;
            //dd($item);
            // $item["product"] = $item->product;
            // $item["product"]->product_image = ImageProcessing::getURL($item["product"]->product_image,'sm');
        }
        //dd($cartItems);
        return $cartItems;

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
        Validator::make($request->all(), [
                'product_id' => ['required'],
                'quantity' => ['required'],
            ])->validate();
        $product = Product::where('product_visible',1)->where('id',$request->product_id)->firstOrFail();

        // VALIDATE
        if ($request->quantity <= 0)
            return response('Quantity isn\'t invalid', 412);

        // neu trung thi tang len 1
        $find = $this->user->cartItems()->where('product_id',$request->product_id);
        if ($find->count())
            $find->update(['quantity' => $request->quantity + $find->first()->quantity]);

        else $this->user->cartItems()->create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
        ]);
        return $this->user->cartItems;
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
        $cartItem = $this->user->cartItems()->where('id',$id)->firstOrFail();
        Validator::make($request->all(), [
                'quantity' => ['required'],
            ])->validate();
        $cartItem->quantity = $request->quantity;
        $cartItem->save();
        return $cartItem;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cartItem = $this->user->cartItems()->where('id',$id)->firstOrFail();
        $cartItem->delete();
        return "";
    }
}
