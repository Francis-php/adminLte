<?php

namespace App\Http\Requests;


use App\Models\User;
use Exception;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class EditUserRequest extends FormRequest
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
     * @return array<string, ValidationRule|array|string>
     * @throws Exception
     */
    public function rules(): array
    {
        $user= $this->route('user');
        return [
            'first_name' => 'required',
            'last_name' => 'required',
            'email'=> [
                'required',
                'email',
                Rule::unique('users')->ignore($user->id),
                ],
            'gender' => 'required',
        ];
    }
}
