<?php

namespace App\Model;

class Exploratory extends Model
{
    protected $table = 'exploratory';

    protected $casts = [
        'mouth_photo' => 'json'
    ];

    public function visit()
    {
        return $this->hasOne(Visit::class);
    }

    public static function transformer()
    {
        // TODO: Implement transformer() method.
    }
}
