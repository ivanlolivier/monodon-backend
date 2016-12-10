<?php

namespace App\Models\Auth;

trait CanAuthenticate
{
    public function auth()
    {
        return $this->morphOne(User::class, 'authenticatable');
    }
}