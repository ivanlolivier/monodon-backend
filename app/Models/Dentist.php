<?php

namespace App\Models;

use App\Models\Auth\CanAuthenticate;
use App\Transformers\DentistTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;

class Dentist extends _Model
{
    use SoftDeletes, CanAuthenticate;

    protected $fillable = [
        'name',
        'surname',
        'affiliate_id',
        'email',
        'phones',
        'sex'
    ];

    
    /*************
     * RELATIONS *
     *************/

    public function clinics()
    {
        return $this->belongsToMany(Clinic::class);
    }

    public static function transformer()
    {
        return new DentistTransformer();
    }

    public function worksOn(Clinic $clinic)
    {
        return $this->clinics()->get()->contains('id', $clinic->id);
    }


    /************
     * MUTATORS *
     ************/

    public function setPhonesAttribute($value)
    {
        $this->attributes['phones'] = implode(';', $value);
    }
}
