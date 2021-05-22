<?php

namespace App\Http\Controllers\Customer\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    use VerifiesEmails;

    /**
     * Where to redirect users after verification.
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
        $this->middleware('auth');
        $this->middleware('signed')->only('otp');
        $this->middleware('throttle:6,1')->only('otp', 'resend');
    }

    public function showOtpForm(Request $request)
    {
        return (! is_null($request->user()->firebase_uid))
                        ? redirect($this->redirectPath())
                        : view('customer.auth.verify_otp');  
    }

    public function verifyOtp(Request $request)
    {
        $token = $request->token;
        $uid = $request->uid;
        // $date = $data->creationTime;
        // $date = Carbon::parse($date)->format('Y-m-d H:i:s');
        $user = Auth::guard('web')->user();
        $user->firebase_uid = $uid;
        $user->save();
        return $uid;
    }
    /**
     * Show the email verification notice.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request)
    {
        return $request->user()->hasVerifiedEmail()
                        ? redirect($this->redirectPath())
                        : view('customer.auth.verify_email');  
    }
}
