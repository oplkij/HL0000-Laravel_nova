<?php
/**
 * @license Apache 2.0
 */
namespace SiteMap;
/**
 * Class Pet
 *
 * @package siteMap
 *
 * @author  Ken Chan <ken.chan@yucolab.com>
 *
 * @OA\Schema(
 *     description="SiteMap",
 *     title="SiteMap",
 *     required={"title", "published_at"}
 * )
 */
class SiteMap
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
     *     default="toilet",
     *     title="type",
     *     description="type",
     *     enum={"toilet"},
     * )
     *
     * @var string
     */
    private $type;
    /**
     * @OA\Property(
     *     default="",
     *     title="opening_hour",
     *     description="opening hour",
     *     enum={""},
     * )
     *
     * @var string
     */
    private $open_hour;
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
     *     format="array",
     *     title="thumbnail",
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
     *     enum={"Active","Disabled","Maintenance","Deleted"},
     * )
     *
     * @var string
     */
    private $status;
}