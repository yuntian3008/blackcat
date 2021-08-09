<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Staff;

class StaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = Staff::all();
        foreach ($users as $value) {
            $value["roles"] = $value->roles;
        }
        // chen permission vao day
        return $users;
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
        // $user = User::findOrFail($id);
        // $permissions = $user->permissions->pluck('id')->toArray();
        // $user = $user->toArray();
        // $user['permissions'] = $permissions;
        // return $user;
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
        $staff = Staff::findOrFail($id);
        if ($request->only_edit_block) {
            if($staff->hasRole('superadmin'))
            return response('Sorry! You can\'t block Superadmin!',405);
            $staff->update(['block' => $request->block]);
            return $staff;
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
