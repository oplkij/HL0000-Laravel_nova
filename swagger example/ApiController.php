<?php

namespace App\Http\Controllers;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ApiController extends Controller
{
        /**
     * @OA\get(
     *     path="/getPost",
     *     tags={"Event Schedule"},
     *     summary="Add a new post to the store",
     *     operationId="getpost",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         )
     *     ),
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Tags to filter by",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     )
     * )
     */
    public function getPost(Request $request)
    {
        $results = DB::table('posts')->select('*')->where('id',$request->id)->get();
        return $results;
    }

            /**
     * @OA\get(
     *     path="/getAllEvent",
     *     tags={"Event Schedule"},
     *     summary="Add a new post to the store",
     *     operationId="getAllEvent",
     *     @OA\Response(
     *         response=200,
     *         description="successful operation",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/Post")
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     )
     * )
     */
    public function getAllEvent()
    {
        $results = DB::table('event_schedules')->select('id','name as title', 'start_time as start','end_time as end','rrule','duration')->get();
        return $results;
    }


    /**
     * @OA\Post(
     *     path="/addEvent",
     *     tags={"Event Schedule"},
     *     summary="Add a new post to the store",
     *     operationId="addPost",
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     requestBody={"$ref": "#/components/requestBodies/Post"}
     * )
     */
    public function addEvent(Request $request)
    {
        $query = DB::table('event_schedules')->insert(['name'=>$request->name,'start_time'=>$request->start_time,'end_time'=>$request->end_time]);
        // $results = DB::table('posts')->select('*')->orderBy('id', 'desc')->take(1)->get();
        return $request;
    }


    /**
     * @OA\Post(
     *     path="/updateEvent",
     *     tags={"Event Schedule"},
     *     summary="Add a new post to the store",
     *     operationId="updateEvent",
     *     @OA\Parameter(
     *         name="id",
     *         in="query",
     *         description="Tags to filter by",
     *         required=true,
     *         explode=true,
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response=405,
     *         description="Invalid input"
     *     ),
     *     requestBody={"$ref": "#/components/requestBodies/Post"}
     * )
     */
    public function updateEvent(Request $request)
    {
        $query = DB::table('event_schedules')->where('id',$request->id)->update(['name'=>$request->name,'start_time'=>$request->start_time,'end_time'=>$request->end_time]);
        // $results = DB::table('posts')->select('*')->orderBy('id', 'desc')->take(1)->get();
        if($query == 0){
            return "Update fail, no record found";
        }else{
            return "200 OK";
        }
    }



        /**
     * @OA\Delete(
     *     path="/deletePost/{postId}",
     *     tags={"Event Schedule"},
     *     summary="Deletes a post",
     *     operationId="deletePost",
     *     @OA\Parameter(
     *         name="postId",
     *         in="path",
     *         description="Post id to delete",
     *         required=true,
     *         @OA\Schema(
     *             type="integer",
     *             format="int64"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Invalid ID supplied",
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="post not found",
     *     )
     * )
     * @param int $id
     */
    public function deletePost($id)
    {
        $results = DB::table('posts')->where('id',$id)->delete();
        if($results == 0){
            return "No record found";
        }else{
            return "200 OK";
        }
    }

}
