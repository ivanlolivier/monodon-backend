<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\_Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;

class ResetPasswordController extends _Controller
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
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    protected function resetPassword($user, $password)
    {
        $user->password = $password;

        return $user->save();
    }

    protected function sendResetResponse($response)
    {
        return $this->responseAsJson(['status' => trans($response)], 200);
    }

    protected function sendResetFailedResponse(Request $request, $response)
    {
        return $this->responseAsJson(['message' => trans($response)], 400);
    }
}
