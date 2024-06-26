<?php

namespace App\Http\Requests;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;


class ApplyPostRequest extends FormRequest
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
        $post = $this->route('post');
        $availableTickets= $post->tickets - $post->users()->sum('tickets');

        return ['tickets.'.$post->id => ['required', 'integer', 'between:1,' . $availableTickets]];
    }
}
