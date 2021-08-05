<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ManagerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function dashboard(Request $request)
    {
        return view('staff.manager.one');
    }

    public function category()
    {
        return view('staff.manager.category');
    }

    public function customer()
    {
        return view('staff.manager.customer');
    }

    public function role()
    {
        return view('staff.manager.role');
    }

    public function product()
    {
        return view('staff.manager.product');
    }

    public function staff()
    {
        return view('staff.manager.staff');
    }

    public function getOrders()
    {
        return view('staff.manager.get_order');
    }

    public function shipOrders()
    {
        return view('staff.manager.ship_order');
    }

    public function completeOrders()
    {
        return view('staff.manager.complete_order');
    }
}
