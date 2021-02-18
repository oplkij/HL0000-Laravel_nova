<?php

/**
 * @license Apache 2.0
 */

/**
 *
 * @OA\RequestBody(
 *     request="Event",
 *     description="Post object that needs to be added to the DB",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Event")
 * )
 * @OA\RequestBody(
 *     request="EventRepeat",
 *     description="Post object that needs to be added to the DB",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/EventRepeat")
 * )
 * @OA\RequestBody(
 *     request="SiteMap",
 *     description="SiteMap object that needs to be added to the DB",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/SiteMap")
 * )
 * @OA\RequestBody(
 *     request="Exhibit",
 *     description="Exhibit object that needs to be added to the DB",
 *     required=true,
 *     @OA\JsonContent(ref="#/components/schemas/Exhibit")
 * )
 */

