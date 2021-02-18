<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rrule extends Model
{
    protected $casts = [
        'dtstart' => 'datetime',
        'until' => 'datetime',
        'byweekday' => 'array',
    ];

    public function eventSchedule(){
        return $this->belongsTo('App\EventSchedule');
    }
    
}
