<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreHouseRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'rooms' => 'required|integer|min:1|max:30',
            'beds' => 'required|integer|min:1|max:90',
            'bathrooms' => 'required|integer|min:1|max:10',
            'square_mt' => 'required|integer',
            'address' => 'required|string|max:255',
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'thumb' => 'nullable|url',
            'price_per_night' => 'required|numeric|min:1|max:9999.99',
            'user_id' => 'exist:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'services' => 'exists:services,id'
        ];
    }
}
