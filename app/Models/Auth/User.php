<?php

namespace App\Models\Auth;

use App\Models\_Model;
use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\HasApiTokens;

class User extends _Model implements
    AuthenticatableContract,
    AuthorizableContract,
    CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword, HasApiTokens;

    protected $fillable = [
        'email', 'password',
    ];

    public function setPasswordAttribute($pass)
    {
        $this->attributes['password'] = Hash::make($pass);
    }

    public function findForPassport($email)
    {
        if (! $type = app(Request::class)->get('type', false)){
            return false;
        }

        $authenticatable = "\\App\\Models\\" . studly_case(strtolower($type));

        if (! class_exists($authenticatable)) {
            return false;
        }

        return $this
            ->where('email', $email)
            ->where('authenticatable_type', get_class(new $authenticatable))
            ->first();
    }

    public function authenticatable()
    {
        return $this->morphTo();
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
