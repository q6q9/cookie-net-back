<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMessageRequest;
use App\Http\Requests\UpdateMessageRequest;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MessageController extends Controller
{
    public function index()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StoreMessageRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMessageRequest $request)
    {
        //
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

        /** @var Message[] $messages */
        $messages = Message::query()
            ->selectRaw("id, (author = {$author}) AS is_own, body, EXTRACT(epoch FROM created_at) AS created_at")
            ->where(["author" => [$author, $to]])
            ->orWhere(["to" => [$author, $to]])
            ->orderByDesc("created_at")
            ->getQuery()
            ->get();

        return $messages;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdateMessageRequest $request
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMessageRequest $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Message $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
