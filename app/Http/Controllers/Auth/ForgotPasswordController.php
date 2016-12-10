<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\_Controller;
use App\Models\Auth\User;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;

class ForgotPasswordController extends _Controller
{
    use SendsPasswordResetEmails;

    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, [
            "client_id"     => "required",
            "client_secret" => "required",
            "email"         => "required|email",
            "type"          => "required|in:dentist,employee,patient",
        ]);

        /** @var User $user */
        if (!$user = (new User)->findForPassport($request->get('email'), $request->get('type'))) {
            return $this->responseAsJson([
                'We can\'t find a ' . $request->get('type') . ' with that e-mail address.'
            ], 400);
        }

        $user->sendPasswordResetNotification(
            app('auth.password.broker')->createToken($user)
        );

        return $this->responseAsJson([], 200);
    }

}
