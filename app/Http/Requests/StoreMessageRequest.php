<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMessageRequest extends FormRequest
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
            //
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255'],
            'text' => ['required'],
            'name' => ['max:100'],
            'surname' => ['max:100'],
            'house_id' => ['required', 'exists:houses,id']
        ];
    }
}
