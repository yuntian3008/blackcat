<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Order;
use App\Setting;
use Carbon\Carbon;

class ShippingController extends Controller
{
    function __construct() 
    {
        $this->middleware('api.role:shipper,ordermanager');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        
        // chen permission vao day
        
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        switch ($id) {
            case '0':
                $orders = Order::whereNotNull('request_date')
                ->whereNotNull('get_date')
                ->whereNull('ship_date')
                ->whereNull('completion_date')->get();
                $orders->map(function ($order)
                {
                    $order->late_level = $order->getLateLevel();
                });
                break;
            case '1':
                $orders = Order::whereNotNull('request_date')
                ->whereNotNull('get_date')
                ->whereNotNull('ship_date')
                ->whereNull('completion_date')->get();
                break;
            
            default:
                $orders = [];
                break;
        }
        return $orders;
        
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
        $order = Order::findOrFail($id);
        
        
        switch ($request->type) {
            case '0':
                $order->update(['ship_date' => Carbon::now()]);
                break;
            case '1':
                $order->update(['completion_date' => Carbon::now()]);
                break;
            
            default:
                $order = [];
                break;
        }
        return $order;
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
