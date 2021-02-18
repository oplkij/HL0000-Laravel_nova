<?php
/**
 * @license Apache 2.0
 */
namespace EventRepeat;
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
class EventRepeat
{
    /**
     * @OA\Property(
     *     format="integer",
     *     description="id",
     *     title="id",
     *     enum={1},
     * )
     *
     * @var int
     */
    private $id;
    /**
     * @OA\Property(
     *     default="['2019-07-22T08:00:00.000Z', '2019-07-23T08:00:00.000Z']",
     *     title="date",
     *     description="date",
     *     enum={"['2019-07-22T08:00:00.000Z', '2019-07-23T08:00:00.000Z']"},
     * )
     *
     * @var string
     */
    private $date;
}