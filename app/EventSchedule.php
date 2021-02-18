<?php

namespace App;
use Laravel\Nova\Nova;
use Illuminate\Database\Eloquent\Model;
use App\Observers\EventScheduleObserver;

class EventSchedule extends Model
{

    protected static function boot()
    {
        parent::boot();
        Nova::serving(function () {
            EventSchedule::observe(EventScheduleObserver::class);
        });
     
    }
   
    protected $casts = [
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'byweekday' => 'array',
        'dtstart' => 'datetime',
        'until' => 'datetime',
    ];

    public function posts()
    {
        return $this->BelongsToMany('App\Post');
    }
 
}
