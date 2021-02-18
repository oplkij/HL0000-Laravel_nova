<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\DateTime;
use Laravel\Nova\Fields\BelongsTo;
use Fourstacks\NovaCheckboxes\Checkboxes;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Select;
use Laraning\NovaTimeField\TimeField;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;


class Rrule extends Resource
{
    public static $displayInNavigation = false;

    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\Rrule';

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'id';

    /**
     * The columns that should be searched.
     *
     * @var array
     */
    public static $search = [
        'id',
    ];

    /**
     * Get the fields displayed by the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function fields(Request $request)
    {
        return [
            ID::make()->sortable(),

            Select::make('Freq', 'freq')->options([
                'daily' => 'Daily',
                'weekly' => 'Weekly',
                'monthly' => 'Monthly',
                'yearly' => 'Yearly',
            ])->displayUsingLabels()->rules('required'),
            Number::make('Repeat_time'),
            Number::make('Count'),

            NovaDependencyContainer::make([
                Checkboxes::make('Byweekday', 'byweekday')->options([
                    'mo' => 'Mon',
                    'tu' => 'Tue',
                    'we' => 'Wed',
                    'th' => 'Thu',
                    'fr' => 'Fri',
                    'sa' => 'Sat',
                    'su' => 'Sun',
                ]),
            ])->dependsOn('freq', 'weekly'),

            NovaDependencyContainer::make([
                Checkboxes::make('Byweekday', 'byweekday')->options([
                    '1' => 'Januar',
                    '2' => 'February',
                    '3' => 'March',
                    '4' => 'April',
                    '5' => 'May',
                    '6' => 'June',
                    '7' => 'July',
                    '8' => 'August',
                    '9' => 'September',
                    '10' => 'October',
                    '11' => 'November',
                    '12' => 'December',
                ]),
            ])->dependsOn('freq', 'monthly'),

          
            TimeField::make('Duration'),
            DateTime::make('Start Day', 'dtstart')->format('MMM DD, YYYY, HH:MM:SS'),
            DateTime::make('End Day', 'until')->format('MMM DD, YYYY, HH:MM:SS'),

            BelongsTo::make('EventSchedule')
        ];
    }

    /**
     * Get the cards available for the request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function cards(Request $request)
    {
        return [];
    }

    /**
     * Get the filters available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function filters(Request $request)
    {
        return [];
    }

    /**
     * Get the lenses available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function lenses(Request $request)
    {
        return [];
    }

    /**
     * Get the actions available for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function actions(Request $request)
    {
        return [];
    }
}
