<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Customer;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
     *
     * @var string
     */
    protected $redirectTo = '/user/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        if (! is_null($token) && DB::table('password_resets')->where('token', $token)->exists())
        {
            $uid = DB::table('password_resets')->where('token', $token)->value('uid');
            $customer = Customer::firstWhere("firebase_uid",$uid);
            if (is_null($customer)) {
                return "Chua xac thuc OTP";
            }
            $id = $customer->id;
            return view('customer.auth.passwords.reset')->with(
                ['uid'=> $uid, 'token' => $token, 'id' => $id]
            );
        }
        return null;

    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'uid' => 'required',
            'id' => 'required',
            'password' => ['required', 'string', 'min:8', 'confirmed','regex:/[a-z]/'],      // must contain at least one lowercase letter
            'regex:/[A-Z]/',      // must contain at least one uppercase letter
            'regex:/[0-9]/',      // must contain at least one digit
            'regex:/[@$!%*#?&]/', // must contain a special character],
        ], $this->validationErrorMessages());


        if (DB::table('password_resets')->where('token', $request->token)->exists()
            && DB::table('password_resets')->where('uid', $request->uid)->exists()
            && DB::table('customers')->where('id',$request->id)->where('firebase_uid',$request->uid)->exists()) {


            $customer = Customer::find($request->id);
            $customer->password = Hash::make($request->password);

            $customer->save();

            Auth::loginUsingId(1);

            return redirect()->route('customer.profile');
        }
        else abort(403, 'Unauthorized action.');
    }
}
