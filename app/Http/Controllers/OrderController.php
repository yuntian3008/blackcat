<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Order;
use Illuminate\Support\Facades\Validator;
use App\Customer;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Components\Helper\ImageProcessing;
use App\Rules\OrderNotProcessedYet;
class OrderController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function history(Request $request) {
        $user = Auth::user();
        $orders = $user->orders();

        Validator::make($request->all(), [
            'status' => 'string|in:processing,completed,cancelled|nullable',
        ])->validate();
        switch ($request->status) {
            case 'completed':
                $orders = $orders->whereNotNull('completion_date')->get();
                break;
            case 'processing':
                $orders = $orders->whereNull('completion_date')->whereNotNull('request_date')->get();
                break;
            case 'cancelled':
                $orders = $orders->whereNull('request_date')->get();
                break;
            default:
                $orders = $orders->get();
                break;
        };
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
        $order = $user->orders()->find($id) ?? abort(404,"The order could not be found");
        $order_details = $order->orderDetails;
        foreach ($order_details as $index => $item) {
            $item['product'] = $item->product;
            $item['product']->product_image = ImageProcessing::getURL($item['product']->product_image,'sm');
        }
        return view('customer.order_details', [
            'order' => $order,
            'order_details' => $order_details,
            'expected_arrival' => empty($order->request_date) ? "" : Carbon::createFromFormat('Y-m-d H:i:s', $order->request_date)->addDays(7)->format('d/m/Y'),
        ]);
    }

    public function create(Request $request) {

        Validator::make($request->all(), [
                'secret' => 'required',
                'phone' => 'digits:10|nullable',
            ])->validate();
        $customer = Customer::where('firebase_uid', $request->secret)->firstOrFail();

    	if ($request->newAddress == "true") {
	        Validator::make($request->all(), [
	            'address' => 'required|string|max:255',
	            'ward' => 'required|string|max:255',
	            'district' => 'required|string|max:255',
	            'province' => 'required|string|max:255',
	            'country' => 'required|string|max:255',
	        ])->validate();

	        $address = $customer->addresses()->create([
	    		'address' => $request->address,
	    		'ward' => $request->ward,
	    		'district' => $request->district,
	    		'province' => $request->province,
	    		'country' => $request->country,
	    	]);
        }
    	
    	$address = $request->address.', '.$request->ward.', '.$request->district.', '.$request->province.', '.$request->country;


        $order = $customer->orders()->create([
        	'address' => $address,
        	'phone' => empty($request->phone) ? $request->user()->phone : $request->phone,
        	'payment' => $request->payment,
            'request_date' => Carbon::now(),
        ]);
        $cartItems = $customer->cartItems;
        foreach ($cartItems as $item) {
        	$order->orderDetails()->create([
        		'product_id' => $item->product_id,
        		'quantity' => $item->quantity,
        	]);
        }

        $customer->cartItems()->delete();

        return response()
            ->json(['message' => 'Order has been created successfully.',
                    'next' => route('customer.order.details',['id'=> $order->id]) ]);
        
    }

    public function cancel(Request $request) {
        Validator::make($request->all(), [
            'id' => ['required', 'exists:orders', new OrderNotProcessedYet ],
        ])->validate();
        
        $order = Order::findOrFail($request->id);

        $order->update([
            'request_date' => null,
        ]);

        return redirect()->back();
        
    }
}
