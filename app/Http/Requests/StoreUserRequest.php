<?php

namespace App\Http\Requests;

use App\Models\{Profile, User};
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules;

class StoreUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'phone' => ['required', 'string', 'unique:' . Profile::class],
            'username' => ['required', 'string', 'unique:' . User::class],
            'password' => ['required', 'string', Rules\Password::defaults()],
            'email' => ['required', 'string', 'email:rfc,dns', 'max:255', 'unique:' . User::class],
            'dob' => ['required', 'string'],
            'state' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'string', 'max:10'],
        ];
    }
}
