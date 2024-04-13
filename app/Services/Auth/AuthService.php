<?php

namespace App\Services\Auth;

use App\Http\Requests\LoginUserRequest;
use App\Models\User;
use Illuminate\Support\Facades\{Auth, DB};

class AuthService
{
    /**
     * login registered user
     * @param App\Http\Requests\LoginUserRequest|array $loginDetails
     * @param App\Models\User $user
     * @return bool
     */

    public function login(LoginUserRequest|array $loginDetails, User $user)
    {
        return DB::transaction(function () use ($loginDetails, $user) {
            return Auth::attempt(['email' => $user->email, 'password' => $loginDetails['password']])
            || Auth::attempt(['username' => $user->username, 'password' => $loginDetails['password']]);
        });
    }

}