<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * @OA\Post(
     *     path="/messages/",
     *     tags={"messages"},
     *     summary="Send message",
     *     security={{"sanctum":{}}},
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="to",
     *                     type="int"
     *                 ),
     *                 @OA\Property(
     *                     property="body",
     *                     type="string"
     *                 ),
     *                 example={"to": "1", "body": "Hi, ALexander. How are you?"},
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="OK",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function store(StoreMessageRequest $request)
    {
        return Message::create($request->validated());
    }


    /**
     * @OA\Get(
     *     path="/messages/{id}",
     *     tags={"messages"},
     *     summary="Get messages from me to ID's user",
     *     security={{"sanctum":{}}},
     *     @OA\Parameter(
     *         in="path",
     *         name="id",
     *         required=true,
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function show(int $to)
    {
        $author = Auth::id();

        return Message::query()
            ->selectRaw("id, (author = {$author}) AS is_own, body, EXTRACT(epoch FROM created_at) AS created_at")
            ->where(["author" => $author, "to" => $to])
            ->orWhere(["author" => $to])->where([ "to" => $author])
            ->orderBy("created_at")
            ->getQuery()
            ->get();
    }
}
