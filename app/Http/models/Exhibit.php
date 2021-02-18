<?php
/**
 * @license Apache 2.0
 */
namespace Exhibit;
/**
 * Class Pet
 *
 * @package Exhibit
 *
 * @author  Ken Chan <ken.chan@yucolab.com>
 *
 * @OA\Schema(
 *     description="Exhibit",
 *     title="Exhibit",
 *     required={"title", "published_at"}
 * )
 */
class Exhibit
{
    /**
     * @OA\Property(
     *     format="string",
     *     description="Name",
     *     title="Name",
     *     enum={"New Facilities"},
     * )
     *
     * @var string
     */
    private $name;
    /**
     * @OA\Property(
     *     default="New title",
     *     title="title",
     *     description="title",
     *     enum={"New title"},
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
     *     default="1/F",
     *     title="localtion",
     *     description="localtion",
     *     enum={"1/F"},
     * )
     *
     * @var string
     */
    private $location;
    /**
     * @OA\Property(
     *     default="[]",
     *     title="thumnail",
     *     description="thumnail",
     *     enum={"[]"},
     * )
     *
     * @var string
     */
    private $thumbnail;
        /**
     * @OA\Property(
     *     format="array",
     *     title="coordinate",
     *     description="coordinate",
     *     @OA\Items(
     *         type = "string",
     *         default={"x":"0","y":"0"},
     *         enum={"x:0;y:0"},
     *     )
     * )
     *
     * @var array
     */
    private $coordinate;
    /**
     * @OA\Property(
     *     default="active",
     *     title="status",
     *     description="status",
     *     enum={"active","disabled","maintenance","deleted"},
     * )
     *
     * @var string
     */
    private $status;
}