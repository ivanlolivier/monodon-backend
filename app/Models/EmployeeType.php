<?php

namespace App\Models;

use App\Models\Auth\CanAuthenticate;
use App\Transformers\EmployeeTransformer;
use App\Transformers\EmployeeTypeTransformer;

class EmployeeType extends _Model
{
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    
    public static function transformer()
    {
        return new EmployeeTypeTransformer();
    }
}
