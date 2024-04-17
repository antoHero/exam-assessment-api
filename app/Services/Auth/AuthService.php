<?php

namespace App\Services\Auth;

use App\Enums\ProfileTypeEnum;
use App\Http\Requests\{LoginUserRequest, StoreUserRequest};
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\{Auth, DB, Hash};

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

    /**
     * create a new user account
     * @param App\Http\Requests\StoreUserRequest|array $request
     * @return App\Models\User
    */

    public function create_new_user(StoreUserRequest|array $request): User
    {
        return DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'username' => $request['username'],
                'password' => Hash::make($request['password'])
            ]);

            Profile::create([
                'user_id' => $user->id,
                'phone' => $request['phone'],
                'dob' => $request['dob'],
                'state' => $request['state'],
                'gender' => $request['gender'],
                'type' => ProfileTypeEnum::STUDENT->value
            ]);

            return $user;
        });
    }

}