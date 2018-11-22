<?php

namespace App\Http\Guards;

use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Encryption\Encrypter;
use Illuminate\Support\Facades\Auth;
use Laravel\Passport\ClientRepository;
use Laravel\Passport\Guards\TokenGuard;
use Laravel\Passport\TokenRepository;
use League\OAuth2\Server\ResourceServer;

class AuthenticatableGuard extends TokenGuard
{
    protected $realProvider;

    public function __construct(
        ResourceServer $server,
        UserProvider $provider,
        TokenRepository $tokens,
        ClientRepository $clients,
        Encrypter $encrypter
    ) {
        $this->realProvider = $provider;

        parent::__construct(
            $server, Auth::createUserProvider('users'), $tokens, $clients, $encrypter
        );
    }

    protected function authenticateViaBearerToken($request)
    {
        $user = parent::authenticateViaBearerToken($request);

        if (!$user) {
            return null;
        }

        if ($this->realProvider->getModel() != $user->authenticatable_type) {
            return null;
        }

        return $user->authenticatable;
    }
}
