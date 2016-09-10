<?php

namespace App\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

class Dentist extends User
{
    use SoftDeletes;
}
