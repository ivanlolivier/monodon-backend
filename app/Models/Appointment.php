<?php

namespace App\Models;

use App\Transformers\AppointmentTransformer;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Appointment extends _Model
{
    use SoftDeletes;

    public static function boot()
    {
        parent::boot();

        static::deleting(function ($appointment) {
            $canceller = Auth::user();

            $appointment->deleted_by_type = get_class($canceller);
            $appointment->deleted_by_id = $canceller->id;

            $appointment->save();
        });
    }

    protected $fillable = [
        'title',
        'description',
        'datetime',
    ];

    protected $dates = [
        'datetime',
        'created_at',
        'updated_at',
    ];

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class);
    }

    public function cancelled_by()
    {
        return $this->morphTo();
    }

    public static function transformer()
    {
        return new AppointmentTransformer();
    }
}
