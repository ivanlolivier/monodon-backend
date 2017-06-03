<?php

namespace App\Models\Auth;

trait CanAuthenticate
{
    public static function boot()
    {
        parent::boot();

        self::updating(function ($model) {
            if ($model->fresh()->email !== $model->email) {
                $model->auth->email = $model->email;
                $model->auth->save();
            }
        });
    }

    public function auth()
    {
        return $this->morphOne(User::class, 'authenticatable');
    }
}