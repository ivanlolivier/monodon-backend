<?php

namespace App\Models;

use App\Transformers\ClinicTransformer;

class Clinic extends _Model
{
    protected $fillable = [
        'name',
        'address',
        'phones',
        'email',
        'logo',
        'latitude',
        'longitude'
    ];
    
    
    /*************
     * RELATIONS *
     *************/
    
    public function dentists()
    {
        return $this->belongsToMany(Dentist::class)->withTimestamps();
    }
    
    public function patients()
    {
        return $this->belongsToMany(Patient::class)->withTimestamps();
    }
    
    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
    
    public function appointments()
    {
        return $this->hasMany(Appointment::class);
    }
    
    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    
    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
    
    
    /************
     * MUTATORS *
     ************/
    
    public function setPhonesAttribute($value)
    {
        $this->attributes['phones'] = implode(';', $value);
    }
    
    
    /***************
     * TRANSFORMER *
     ***************/
    
    public static function transformer()
    {
        return new ClinicTransformer();
    }
}
