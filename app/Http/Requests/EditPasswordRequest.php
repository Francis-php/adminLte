<?php

namespace App\Http\Requests;


use App\Rules\PasswordCheck;
use Illuminate\Validation\Rules\Password;
use Illuminate\Foundation\Http\FormRequest;

class EditPasswordRequest extends FormRequest
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
        return ['oldPass' => 'current_password:',
            'password'=> [
                'required',
                'confirmed',
                Password::min(8)
                    ->letters()
                    ->mixedCase()
                    ->numbers()
                    ->symbols(),
                (new PasswordCheck($this->all())),
            ],
        ];
    }
}
