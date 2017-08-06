<?php

namespace App\Models;

use App\Transformers\BuccalZoneTransformer;

class BuccalZone extends _Model
{
    public static function transformer()
    {
        return new BuccalZoneTransformer();
    }
}
