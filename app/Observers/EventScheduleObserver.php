<?php

namespace App\Observers;

use App\EventSchedule;
use Illuminate\Support\Facades\Session;


class EventScheduleObserver
{
    /**
     * Handle the event schedule "created" event.
     *
     * @param  \App\EventSchedule  $eventSchedule
     * @return void
     */
    public function created(EventSchedule $eventSchedule)
    {
        //
    }

    public function updating(EventSchedule $eventSchedule)
    {
       
    }

    /**
     * Handle the event schedule "updated" event.
     *
     * @param  \App\EventSchedule  $eventSchedule
     * @return void
     */
    public function updated(EventSchedule $eventSchedule)
    {
        //
    }

    public function saving(EventSchedule $eventSchedule)
    {   
        $eventSchedule->dtstart = $eventSchedule->start_time;
        if($eventSchedule->repeat_option == 0){
            $eventSchedule->until = null;
            $eventSchedule->count = null;

            $start = $eventSchedule->start_time;
            $end = $eventSchedule->end_time;
            $timeStart = strtotime($start);
            $timeEnd = strtotime($end);
    
            $interval = abs($timeEnd - $timeStart);
            $hours = floor($interval / (60*60));
            $mins = ($interval % (60*60)) / 60;
    
            $eventSchedule->duration = sprintf("%02d", $hours) . ":" . sprintf("%02d", $mins);

        }else if($eventSchedule->repeat_option == 1){
            $eventSchedule->count = null;

            $start = $eventSchedule->start_time;
            $end = $eventSchedule->until;
            $timeStart = strtotime($start);
            $timeEnd = strtotime($end);
    
            $interval = abs($timeEnd - $timeStart);
            $hours = floor($interval / (60*60));
            $mins = ($interval % (60*60)) / 60;
    
            $eventSchedule->duration = sprintf("%02d", $hours) . ":" . sprintf("%02d", $mins);

        }else{
            $eventSchedule->until = null;

            $start = $eventSchedule->start_time;
            $end = $eventSchedule->end_time;
            $timeStart = strtotime($start);
            $timeEnd = strtotime($end);
    
            $interval = abs($timeEnd - $timeStart);
            $hours = floor($interval / (60*60));
            $mins = ($interval % (60*60)) / 60;
    
            $eventSchedule->duration = sprintf("%02d", $hours) . ":" . $mins;
        }
     
    }

    /**
     * Handle the event schedule "deleted" event.
     *
     * @param  \App\EventSchedule  $eventSchedule
     * @return void
     */
    public function deleted(EventSchedule $eventSchedule)
    {
        //
    }

    /**
     * Handle the event schedule "restored" event.
     *
     * @param  \App\EventSchedule  $eventSchedule
     * @return void
     */
    public function restored(EventSchedule $eventSchedule)
    {
        //
    }

    /**
     * Handle the event schedule "force deleted" event.
     *
     * @param  \App\EventSchedule  $eventSchedule
     * @return void
     */
    public function forceDeleted(EventSchedule $eventSchedule)
    {
        //
    }

    /**
     * Handle the event schedule "force deleted" event.
     *
     * @param  \App\EventSchedule  $eventSchedule
     * @return void
     */
    public function retrieved(EventSchedule $eventSchedule)
    {
        //
        \Session::put('key', url()->full());
    }
}
