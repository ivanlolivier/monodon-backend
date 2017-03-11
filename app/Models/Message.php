<?php

namespace App\Models;

use App\Transformers\MessageTransformer;

class Message extends _Model
{
    protected $fillable = [
        'title',
        'message',
        'is_broadcast',
    ];

    protected $dates = [
        'sent_at'
    ];

    protected $casts = [
        'is_broadcast' => 'boolean'
    ];

    public function dentist()
    {
        return $this->belongsTo(Dentist::class);
    }

    public function clinic()
    {
        return $this->belongsTo(Clinic::class);
    }

    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function patients()
    {
        return $this->belongsToMany(Patient::class, 'message_patient');
    }

    public static function transformer()
    {
        return new MessageTransformer();
    }
}
