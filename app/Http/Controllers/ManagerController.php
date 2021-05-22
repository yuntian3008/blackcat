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
        return view('staff.manager.dashboard');
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
}
