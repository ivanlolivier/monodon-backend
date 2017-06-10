<?php

namespace App\Providers;

use App\Http\Guards\AuthenticatableGuard;
use App\Models\Appointment;
use App\Models\Clinic;
use App\Models\Dentist;
use App\Models\Message;
use App\Models\Patient;
use App\Models\Question;
use App\Policies\AppointmentPolicy;
use App\Policies\ClinicPolicy;
use App\Policies\DentistPolicy;
use App\Policies\MessagePolicy;
use App\Policies\PatientPolicy;
use App\Policies\QuestionPolicy;
use Illuminate\Auth\RequestGuard;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Guards\TokenGuard;
use Laravel\Passport\Passport;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Clinic::class      => ClinicPolicy::class,
        Appointment::class => AppointmentPolicy::class,
        Message::class     => MessagePolicy::class,
        Dentist::class     => DentistPolicy::class,
        Question::class    => QuestionPolicy::class,
        Patient::class     => PatientPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @param Request $request
     */
    public function boot(Request $request)
    {
        $this->registerPolicies();

        Passport::routes();

        Auth::extend('authenticatable', function ($app, $name, $config) use ($request) {
            return tap($this->makeGuard($config), function ($guard) {
                $this->app->refresh('request', $guard, 'setRequest');
            });
        });
    }

    /**
     * Make an instance of the token guard.
     *
     * @param  array $config
     * @return RequestGuard
     */
    protected function makeGuard(array $config)
    {
        return new RequestGuard(function ($request) use ($config) {
            return (new AuthenticatableGuard(
                $this->app->make(ResourceServer::class),
                Auth::createUserProvider($config['provider']),
                new TokenRepository,
                $this->app->make(ClientRepository::class),
                $this->app->make('encrypter')
            ))->user($request);
        }, $this->app['request']);
    }
}
