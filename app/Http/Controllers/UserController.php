<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;
use Image;
use Auth;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function changePassword(Request $request)
    {
        $currentPassword = $request->user()->password;
        if($request->newPassword != $request->confirmPassword)
            return response()->json(['message' => "Password doesn't match", 'error' => true]);
                ;
        if(!Hash::check($request->currentPassword,$currentPassword))
            return response()->json(['message' => "Password incorrect", 'error' => true]);
        $request->user()->password = Hash::make($request->newPassword);
        $request->user()->save();
        return response()->json(['message' => "Password changed successfully", 'error' => false]);
    }

    /**
     * Update the authenticated user's API token.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function resetToken(Request $request)
    {
        $token = Str::random(60);

        $request->user()->forceFill([
            'api_token' => $token,
        ])->save();

        return response()->json(['message' => "Refreshed your Token"],200);
    }


    public function changeAvt(Request $request)
    {
        if ($request->hasFile('uploadavatar')) {
            $file = $request->uploadavatar;
            $request->validate([
                'uploadavatar' => 'image|required'
            ]);
            $imagename = time().rand(0,1000).'.'.$file->getClientOriginalExtension();
            $avatar = Image::make($file)->fit(300, 300)->encode('jpg')->save(public_path('assets/user_avatar/'.$imagename));
            $request->user()->avatar = $imagename;
            $request->user()->save();
            return redirect()->back();
        } else abort(403, "Errors");
    }
}
