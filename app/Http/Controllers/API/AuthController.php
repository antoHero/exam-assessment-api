<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\{LoginUserRequest, StoreUserRequest};
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\Auth\AuthService;
use Illuminate\Http\{JsonResponse, Request};
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

        $token = $user->createToken('userExamToken')->plainTextToken;
        return response()->json([
            'message' => 'Login successful',
            'token' => $token,
            'data' => new UserResource($user)
        ], Response::HTTP_OK);
    }

    public function store(StoreUserRequest $request)
    {
        $request = $request->only([
            'name',
            'email',
            'username',
            'password',
            'dob',
            'gender',
            'state',
            'phone'
        ]);
        $user = $this->authService->create_new_user($request);
        return response()->json([
            'message' => 'New user account successfully created',
            'data' => new UserResource($user)
        ], Response::HTTP_CREATED);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->tokens()->delete();

        return response()->json([
            'message' => 'Logout successful'
        ]);

    }
}