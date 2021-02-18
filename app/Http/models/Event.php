<?php
/**
 * @license Apache 2.0
 */
namespace Event;
/**
 * Class Pet
 *
 * @package Event
 *
 * @author  Ken Chan <ken.chan@yucolab.com>
 *
 * @OA\Schema(
 *     description="Posts",
 *     title="Posts",
 *     required={"title", "published_at"}
 * )
 */
class Event
{
    /**
     * @OA\Property(
     *     format="string",
     *     description="Title",
     *     title="Title",
     *     enum={"New Event"},
     * )
     *
     * @var string
     */
    private $title;
    /**
     * @OA\Property(
     *     default="New description",
     *     title="description",
     *     description="description",
     *     enum={"New description"},
     * )
     *
     * @var string
     */
    private $description;
    /**
     * @OA\Property(
     *     default="",
     *     title="color",
     *     description="color",
     *     enum={""},
     * )
     *
     * @var string
     */
    private $color;
    /**
     * @OA\Property(
     *     default="false",
     *     format="int64",
     *     title="is_Allday",
     *     description="is all day"
     * )
     *
     * @var boolean
     */
    private $is_Allday;
    /**
     * @OA\Property(
     *     format="date",
     *     description="start_time",
     *     title="start_time",
     * )
     *
     * @var string
     */
    private $start_time;
    /**
     * @OA\Property(
     *     format="date",
     *     description="end_time",
     *     title="end_time",
     * )
     *
     * @var string
     */
    private $end_time;
    /**
     * @OA\Property(
     *     default=true,
     *     format="int64",
     *     title="is_repeat",
     *     description="is repeat event",
     *     enum={false},
     * )
     *
     * @var boolean
     */
    private $is_repeat;
    /**
     * @OA\Property(
     *     default="weekly",
     *     title="frequency",
     *     description="frequency",
     *     enum={"daily","weekly","monthly","yearly"},
     * )
     *
     * @var string
     */
    private $freq;
    /**
     * @OA\Property(
     *     format="int64",
     *     title="interval",
     *     description="interval",
     *     default = -2,
     *     enum={0,-1},
     * )
     *
     * @var int
     */
    private $e_interval;
    /**
     * @OA\Property(
     *     format="int64",
     *     title="count",
     *     description="count",
     *     default = -1,
     *     enum={0,-1},
     * )
     *
     * @var int
     */
    private $count;
    /**
     * @OA\Property(
     *     format="array",
     *     title="byweekday",
     *     description="byweekday",
     *     @OA\Items(
     *         type = "string",
     *         default="mo",
     *         enum={"mo","tu","we","th","fr","sa","su"},
     *     )
     * )
     *
     * @var array
     */
    private $byweekday;
    /**
     * @OA\Property(
     *     default=false,
     *     format="int64",
     *     title="repeat_option",
     *     description="repeat option",
     *     enum={false},
     * )
     *
     * @var boolean
     */
    private $repeat_option;
        /**
     * @OA\Property(
     *     format="date",
     *     description="repeat event start date",
     *     title="dtstart",
     * )
     *
     * @var string
     */
    private $dtstart;
        /**
     * @OA\Property(
     *     format="date",
     *     description="repeat event end date",
     *     title="until",
     *     
     * )
     *
     * @var string
     */
    private $until;
    /**
     * @OA\Property(
     *     default="1:00",
     *     title="duration",
     *     description="duration",
     *     enum={"1:00"},
     * )
     *
     * @var string
     */
    private $duration;
}