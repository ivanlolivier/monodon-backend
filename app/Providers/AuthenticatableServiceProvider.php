<?php

namespace App\Providers;

use App\Model\Authenticatable;
use App\Model\Dentist;
use App\Model\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\ServiceProvider;

class AuthenticatableServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @param Request $request
     */
    public function boot(Request $request)
    {
        config(['auth.providers.users.model' => Dentist::class]);
        if ($request->get('type') == 'employee'){
            config(['auth.providers.users.model' => Employee::class]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
