<?php

namespace App\Http\Requests;

use App\Models\User;
use App\Rules\PasswordCheck;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ResetPasswordRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {

        $user = User::where('email', $this->email)->first();

        return [
            'token' => 'required',
            'email' => [
                'required',
                'email',
                'exists:users',
                ],
            'password' => [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                (new PasswordCheck($user)),
            ],
        ];
    }
}
