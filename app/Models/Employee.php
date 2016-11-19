<?php

namespace App\Models;

use App\Models\Auth\CanAuthenticate;
use App\Transformers\EmployeeTransformer;

class Employee extends _Model
{
    use CanAuthenticate;

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }
    
    public function type()
    {
        return $this->belongsTo(EmployeeType::class, 'employee_type_id');
    }

    public static function transformer()
    {
        return new EmployeeTransformer();
    }
}
