<?php

namespace App\Http\Controllers;


use App\Http\Requests\auth\SignInAuthRequest;
use App\Http\Requests\auth\SignUpAuthRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     *     path="/auth/sign-in",
     *     tags={"auth"},
     *     summary="Sign in",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"email": "banana@paradise.net", "password": "123qweasd"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function signIn(SignInAuthRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials)) {
            /** @var User $user */
            $user = Auth::user();

            $token = $user->createToken('auth');

            return $token->plainTextToken;
        }

        abort(401);
    }

    /**
     * @OA\Post(
     *     path="/auth/sign-up",
     *     tags={"auth"},
     *     summary="Create a new user",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 example={"name": "Kiwi", "email": "banana@paradise.net", "password": "123qweasd"}
     *             )
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *         @OA\JsonContent()
     *     )
     * )
     */
    public function signUp(SignUpAuthRequest $request)
    {
        $credentials = $request->validated();

        $user = User::create($credentials);

        $token = $user->createToken('auth');

        return $token->plainTextToken;
    }
}
