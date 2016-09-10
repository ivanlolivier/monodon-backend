<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;

class Dentist extends User
{
    use SoftDeletes;
}
