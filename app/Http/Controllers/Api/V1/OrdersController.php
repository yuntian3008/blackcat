<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Order;
use Carbon\Carbon;
class OrdersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $orders = Order::all();
        
        // chen permission vao day
        return $orders;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //USE VUEJS
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $user = User::create([
        //     'fname' => $request->fname,
        //     'lname' => $request->lname,
        //     'gender' => $request->gender,
        //     'email' => $request->email,
        //     'isAdmin' => $request->isAdmin,
        //     'password' => Hash::make(1),
        // ]);
        // if ($request->admin) $request->permissions->append(['id' => 1]);
        // //if ($request->permissions != null) 
        // $user->permissions()->sync($request->permissions);
        
        // return $user;
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
            case '1':
                $orders = Order::where('get_date',null)->where('ship_date',null)->where('completion_date',null)->get();
                // chen permission vao day
                return $orders;
                break;
            case '2':
                $orders = Order::whereNotNull('get_date')->where('ship_date',null)->where('completion_date',null)->get();
                # code...
                return $orders;
                break;
            case '3':
                $orders = Order::whereNotNull('get_date')->whereNotNull('ship_date')->where('completion_date',null)->get();
                # code...
                return $orders;
                break;
            
            default:
                # code...
                break;
        }
        
        // chen permission vao day
        return null;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //USE VUEJS
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
        if ($request->action) {
            $action = $request->action;
            switch ($action) {
                case '1':
                    $order->update(['get_date' => Carbon::now()]);
                    break;
                case '2':
                    $order->update(['ship_date' => Carbon::now()]);
                    break;
                case '3':
                    $order->update(['completion_date' => Carbon::now()]);
                    break;
                
                default:
                    break;
            }
            
            return $order;
        }
        return null;
        // $user = User::findOrFail($id);
        // $data = [
        //     'fname' => $request->fname,
        //     'lname' => $request->lname,
        //     'gender' => $request->gender,
        //     'email' => $request->email,
        //     'isAdmin' => $request->isAdmin,
        // ];
        // if($request->resetpassword) 
        //     array_push($data, ['password' => Hash::make(1)]);
        // $user->update($data);
        // //Update role
        // //if ($request->permissions != null)
        // $user->permissions()->sync($request->permissions);
        // return $user;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // $user = User::findOrFail($id);
        // $user->permissions()->detach();
        // $user->delete();
        // return '';
    }
}
