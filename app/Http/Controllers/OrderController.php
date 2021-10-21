<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Validator;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Components\Helper\ImageProcessing;

class OrderController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function history() {
        $user = Auth::user();
        $orders = $user->orders;
        foreach ($orders as $index => $order) {
            $order['represent'] = $order->orderDetails->first();
            $order['represent']->product = $order['represent']->product;
            $order['represent']->product->product_image = ImageProcessing::getURL($order['represent']->product->product_image,'sm');
            $order['count'] = $order->orderDetails->count();
        }
        return view('customer.orders',[
            'orders' => $orders,
        ]);
    }

    public function show($id) {
        $user = Auth::user();
        $order = $user->orders()->findOrFail($id);
        $order_details = $order->orderDetails;
        foreach ($order_details as $index => $item) {
            $item['product'] = $item->product;
            $item['product']->product_image = ImageProcessing::getURL($item['product']->product_image,'sm');
        }
        return view('customer.order_details', [
            'order' => $order,
            'order_details' => $order_details,
            'expected_arrival' => Carbon::createFromFormat('Y-m-d H:i:s', $order->request_date)->addDays(7)->format('d/m/Y'),
        ]);
    }

    public function create(Request $request) {
    	if ($request->newAddress == "true") {
	        Validator::make($request->all(), [
	            'address' => 'required|string|max:255',
	            'ward' => 'required|string|max:255',
	            'district' => 'required|string|max:255',
	            'province' => 'required|string|max:255',
	            'country' => 'required|string|max:255',
                'phone' => 'digits:10',
	        ])->validate();

	        $address = $request->user()->addresses()->create([
	    		'address' => $request->address,
	    		'ward' => $request->ward,
	    		'district' => $request->district,
	    		'province' => $request->province,
	    		'country' => $request->country,
	    	]);
        }
    	
    	$address = $request->address.', '.$request->ward.', '.$request->district.', '.$request->province.', '.$request->country;
        $order = $request->user()->orders()->create([
        	'address' => $address,
        	'phone' => empty($request->phone) ? $request->user()->phone : $request->phone,
        	'payment' => $request->payment,
            'request_date' => Carbon::now(),
        ]);
        $cartItems = $request->user()->cartItems;
        foreach ($cartItems as $item) {
        	$order->orderDetails()->create([
        		'product_id' => $item->product_id,
        		'quantity' => $item->quantity,
        	]);
        }

        $request->user()->cartItems()->delete();

        return redirect()->route('customer.order.details', $order->id);
        
    }
}
