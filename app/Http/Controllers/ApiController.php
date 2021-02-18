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
}