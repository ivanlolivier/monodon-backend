<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    abstract public static function transformer();

    public function transform()
    {
        return $this::transformer()->transform($this);
    }
}
