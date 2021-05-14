<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','permission:admin']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        return view('user.admin.dashboard.index');
    }

    public function category()
    {
        return view('user.admin.categories.index');
    }

    public function user()
    {
        return view('user.admin.users.index');
    }

    public function permission()
    {
        return view('user.admin.permissions.index');
    }

    public function plant()
    {
        return view('user.admin.plants.index');
    }
}
