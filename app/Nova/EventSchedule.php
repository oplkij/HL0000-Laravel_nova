<?php

namespace App\Nova;

use Laravel\Nova\Fields\ID;
use Illuminate\Http\Request;
use Laravel\Nova\Fields\Text;
use Laravel\Nova\Fields\Textarea;
use Laravel\Nova\Fields\Number;
use Laravel\Nova\Fields\Date;
use Laravel\Nova\Fields\DateTime;
use Inspheric\NovaDefaultable\HasDefaultableFields;
use Fourstacks\NovaCheckboxes\Checkboxes;
use Laravel\Nova\Http\Requests\NovaRequest;
use Laravel\Nova\Fields\Select;
use Laraning\NovaTimeField\TimeField;
use Epartment\NovaDependencyContainer\HasDependencies;
use Epartment\NovaDependencyContainer\NovaDependencyContainer;
use Laravel\Nova\Fields\Boolean;
use OwenMelbz\RadioField\RadioButton;
use DebugBar\DebugBar;
use Symfony\Component\VarDumper\Cloner\Data;
use Laravel\Nova\Fields\BelongsToMany;

class EventSchedule extends Resource
{
    use HasDependencies;
    /**
     * The model the resource corresponds to.
     *
     * @var string
     */
    public static $model = 'App\EventSchedule';

    public static $group = 'Event';

    //public static function label() { return 'Library Items'; }

    /**
     * The single value that should be used to represent the resource when being displayed.
     *
     * @var string
     */
    public static $title = 'title';

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
        $url = \Session::get('key');

        if(strpos($url, "update") !== false){
            return $this->isEdit();
        }
        else{
            $rule = preg_match_all("/.*?(\d+)$/", $url, $matches);
            if($rule>0) {
                // View Detail
                if($this->is_repeat == 1){
                    return $this->isRepeat();
                }else{
                    return $this->notRepeat(); 
                }
            }else{
                // Home
                return $this->isEdit();
            }
        }
    }

    /**
     * Get the address fields for the resource.
     *
     * @return array
     */
    protected function isEdit()
    {
        $dependency = [
            Number::make('Interval','e_interval')->help(
                'The interval on the repeat'
            ),

            RadioButton::make('Ends', 'repeat_option')
            ->options([
                0 => 'Never',
                1 => 'OnDay',
                2 => 'Occurrences'
            ])
            ->default(0) // optional
            ->stack() // optional (required to show hints)
            ->marginBetween() // optional
            ->skipTransformation() // optional
            ->toggle([  // optional
                0 => ['until','count'],
                1 => ['count'],
                2 => ['until']
            ]),

            Number::make('Occurrences','count')->help(
                'How much time want to repeat'
            ),                 
            Date::make('End Day', 'until')->default(date('Y-m-d', strtotime("+1 day")))->format('MMM DD, YYYY')->help(
                'The end day on the repeat'
            )->rules('nullable', 'after_or_equal:start_time'),

        ];
        return [
            ID::make()->sortable(),
            Text::make('Title','title')->rules('required'),
            Textarea::make('Description','description')->withMeta(['extraAttributes' => [
                'placeholder' => 'Make it less than 50 characters']
            ])->rules('required', 'max:50'),
            
            //===============================All Day===================================================
            Boolean::make('All Day','is_Allday')->trueValue(1)
            ->falseValue(0),

            NovaDependencyContainer::make([
                DateTime::make('Start DateTime', 'start_time')->default(date('Y-m-d H:i:s'))->help(
                    'The event start date'
                ),
                DateTime::make('End DateTime', 'end_time')->default(date('Y-m-d H:i:s', strtotime("+1 hours")))->rules('after_or_equal:start_time')->help(
                    'The event end date'
                ),
            ])->dependsOn('is_Allday', false),

            NovaDependencyContainer::make([
                Date::make('Start Date', 'start_time')->default(date('Y-m-d'))->format('MMM DD, YYYY')->help(
                    'The event start date'
                ),
                Date::make('End Date', 'end_time')->default(date('Y-m-d', strtotime("+1 day")))->format('MMM DD, YYYY')->rules('after_or_equal:start_time')->help(
                    'The event end date'
                ),
            ])->dependsOn('is_Allday', true),
                          
            //================================Repeat=====================================================
            Boolean::make('Repeat','is_repeat')->trueValue(1)
            ->falseValue(0),

            NovaDependencyContainer::make([
                Select::make('Frequency', 'freq')->options([
                    'daily' => 'Daily',
                    'weekly' => 'Weekly',
                    'monthly' => 'Monthly',
                    'yearly' => 'Yearly',
                ])->displayUsingLabels(),

                //-----------------------daily-----------------------------------
                NovaDependencyContainer::make($dependency)->dependsOn('freq', 'daily'),

                //-----------------------weekly-----------------------------------
                NovaDependencyContainer::make($this->addArray($dependency,'weekly'))
                ->dependsOn('freq', 'weekly'),

                //-----------------------monthly-----------------------------------
                NovaDependencyContainer::make($this->addArray($dependency,'monthly'))
                ->dependsOn('freq', 'monthly'),
            
                //-----------------------yearly-----------------------------------
                NovaDependencyContainer::make($dependency)
                ->dependsOn('freq', 'yearly'),

            ])->dependsOnNotEmpty('is_repeat'),

            BelongsToMany::make('Posts')
        ];
    }

    // protected static function fillFields(NovaRequest $request, $model, $fields)
    // {
    //     return parent::fillFields($request, $model, $fields->filter(function($field) {
    //         return $field->attribute != 'is_repeat';
    //     }));
    // }

    protected function addArray($dependency,$type){

        if($type == 'weekly'){
            array_unshift($dependency,Checkboxes::make('By Weekday', 'byweekday')->options([
                'mo' => 'Monday',
                'tu' => 'Tuesday',
                'we' => 'Wednesday',
                'th' => 'Thursday',
                'fr' => 'Friday',
                'sa' => 'Saturday',
                'su' => 'Sunday',
            ]));
        }else{
            array_unshift($dependency,Checkboxes::make('By Month', 'byweekday')->options([
                '1' => 'January',
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
            ]));
        }
        return $dependency;
    }

        /**
     * Get the address fields for the resource.
     *
     * @return array
     */
    protected function isRepeat()
    {
        $options = [];
        $typeOfDay = "";
        if($this->freq == 'monthly'){
            $typeOfDay = "By Month";
            $options = [
                '1' => 'January',
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
            ];
        }else if ($this->freq == 'weekly'){
            $typeOfDay = "By Week Day";
            $options = [
                'mo' => 'Monday',
                'tu' => 'Tuesday',
                'we' => 'Wednesday',
                'th' => 'Thursday',
                'fr' => 'Friday',
                'sa' => 'Saturday',
                'su' => 'Sunday',
            ];
        }
        return [
            //ID::make()->sortable(),
            Text::make('Title','title')->rules('required'),
            Textarea::make('Description','description'),

            Boolean::make('All Day','is_Allday')->trueValue(1)
            ->falseValue(0),

            NovaDependencyContainer::make([
                DateTime::make('Start DateTime', 'start_time')->default(date('Y-m-d H:i:s')),
                DateTime::make('End DateTime', 'end_time')->default(date('Y-m-d H:i:s', strtotime("+1 hours"))),
            ])->dependsOn('is_Allday', false),

            NovaDependencyContainer::make([
                Date::make('Start Date', 'start_time')->default(date('Y-m-d')),
                Date::make('End Date', 'end_time')->default(date('Y-m-d', strtotime("+1 day"))),
            ])->dependsOn('is_Allday', true),


            Boolean::make('Repeat','is_repeat')->trueValue(1)
            ->falseValue(0),

            Select::make('Frequency', 'freq')->options([
                'daily' => 'Daily',
                'weekly' => 'Weekly',
                'monthly' => 'Monthly',
                'yearly' => 'Yearly',
            ])->displayUsingLabels(),

            Number::make('Interval','e_interval'),
                 
            Checkboxes::make($typeOfDay, 'byweekday')->options($options),
            Date::make('End Day', 'until'),
            Number::make('Occurrences','count'),
            BelongsToMany::make('Posts')
        ];
    }

    /**
     * Get the address fields for the resource.
     *
     * @return array
     */
    protected function notRepeat()
    {
        return [
            //ID::make()->sortable(),
            Text::make('Title','title')->rules('required'),
            Textarea::make('Description','description'),
            DateTime::make('Start', 'start_time')->default(date('Y-m-d H:i:s')),
            DateTime::make('End', 'end_time')->default(date('Y-m-d H:i:s', strtotime("+1 hours"))),
                          
            Boolean::make('Repeat','is_repeat')->trueValue(1)
            ->falseValue(0),

            BelongsToMany::make('Posts'),
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
