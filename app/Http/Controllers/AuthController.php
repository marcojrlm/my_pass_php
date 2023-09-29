<?php

namespace App\Http\Controllers;

use App\Exceptions\ConflictException;
use App\Exceptions\UnauthorizedException;
use App\Http\Requests\SignInRequest;
use App\Http\Requests\SignUpRequest;
use App\Services\AuthService;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;

class AuthController extends Controller
{
    protected AuthService $authService;

    public function __construct()
    {
        $this->authService = new AuthService();
    }

    /**
     * @throws ConflictException
     */
    public function signUp(SignUpRequest $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|Application|ResponseFactory
    {
        $body = $request->validated();

        $this->authService->ThrowConflictIfUserExist($body['email']);
        $body['password'] = $this->authService->EncryptPassword($body['password']);
        $this->authService->createUser($body);

        return response('Created', 201);
    }


    /**
     * @throws UnauthorizedException
     */
    public function signIn(SignInRequest $request): \Illuminate\Foundation\Application|\Illuminate\Http\Response|Application|ResponseFactory
    {
        $body = $request->validated();

        $user = $this->authService->ThrowUnauthorizedIfUserNotExist($body['email']);
        $this->authService->ThrowUnauthorizedIfInvalidPassword($body['password'], $user['password']);
        $token = $this->authService->generateJwtToken($user->id);
        return response($token, 200);
    }
}
