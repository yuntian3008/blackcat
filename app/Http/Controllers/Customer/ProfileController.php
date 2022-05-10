<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Components\Helper\ImageProcessing;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    protected $imgProcess;

    function __construct()
    {
        $this->imgProcess = new ImageProcessing();
    }

    public function show()
    {
        return view('customer.profile');
    }

    public function update(Request $request)
    {
        $messages = [
            'gender.between' => 'Gender is invalid',
        ];
        $input = $request->all();
        $input['gender'] = (int)$request->gender;
        Validator::make($input, [
            'firstname' => 'required|string|max:191',
            'lastname' => 'required|string|max:191',
            'dob' => 'required|date_format:Y-m-d',
            'gender' => 'required|numeric|between:-1,1',
        ],$messages)->validate();
        $request->user()->update($input);
        $request->session()->flash('success',  'Your information is updated');
        return redirect()->back();
    }

    public function changeAvatar(Request $request)
    {
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $request->validate([
                'avatar' => 'image|required'
            ]);
            if($request->user()->avatar)
                Storage::disk('public')->deleteDirectory($request->user()->avatar);
            $avatar = $this->imgProcess->runForArray([$file], 'avatars');
            $request->user()->update([
                'avatar' => $avatar,
            ]);
            $request->session()->flash('success',  'Your avatar is changed');
            return redirect()->back();
        } else abort(403, "Errors");
    }
}
