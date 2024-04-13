<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\{LoginUserRequest};
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService,
    ) {}

    public function login(LoginUserRequest $request): JsonResponse
    {
        $usernameOrEmail = $request->validated()['email'];
        $user = User::where('email', $usernameOrEmail)->orWhere('username', $usernameOrEmail)->firstOrFail();
        if (!$this->authService->login($request, $user)) {
            return response()->json([
                'message' => 'Invalid login credentials'
            ], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $user = User::where('email', $request->validated()['email'])->firstOrFail();

        $token = $user->createToken('userEventhubToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'data' => new UserResource($user)
        ], Response::HTTP_OK);
    }
}