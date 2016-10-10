<?php

namespace App\Models\Auth;

trait CanAuthenticate
{
    public function auth()
    {
        return $this->morphMany(User::class, 'authenticatable');
    }
}