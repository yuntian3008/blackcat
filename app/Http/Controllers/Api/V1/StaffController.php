<?php

namespace App\Http\Controllers\Api\V1;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
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
        Validator::make($request->all(), [
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'username' => ['required','unique:staff','regex:/^[a-z0-9_-]{3,16}$/'],
            'roles' => ['present','array','min:1'],
            // 'gender' => ['required', 'digits_between:-1,1'],
            // 'email' => ['required', 'string', 'email', 'max:255', 'unique:staff'],
            // 'phone' => ['required', 'digits:10', 'unique:staff'],
            // 'dob' => ['required', 'date_format:Y-m-d','before:today'],
            // 'password' => ['required', 'string', 'min:8', 'confirmed'],
            // 'address' => ['required', 'string', 'max:255'],   
        ])->validate();
        $default_password = Str::random(30);
        $staff = Staff::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
            'password' => Hash::make($default_password),
        ]);
        $staff->generateToken();
        
        $staff->roles()->sync($request->roles);

        $staff["default_password"] = $default_password;
        return $staff;
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
