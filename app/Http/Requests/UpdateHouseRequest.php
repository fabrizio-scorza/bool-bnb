<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHouseRequest extends FormRequest
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
            'square_mt' => 'required|integer|min:30|max:1000',
            'address' => 'required|string|max:255',
            'thumb' => 'nullable|url',
            'available' => 'required|boolean',
            'price_per_night' => 'required|numeric|min:1|max:9999.99',
            'user_id' => 'exist:users,id',
            'category_id' => 'nullable|exists:categories,id',
            'services' => 'exists:services,id'
        ];
    }
    public function messages()
    {
        return [

            'title.required' => 'Il campo titolo è obbligatorio',
            'title.string' => 'Il campo titolo deve essere una stringa',
            'title.max' => 'il campo titolo non deve superare i 255 caratteri',
            'rooms.required' => 'Il campo numero di stanze è obbligatorio',
            'rooms.integer' => 'Il campo numero di stanze deve essere un numero intero',
            'rooms.min' => 'Il campo numero di stanze deve avere un valore minimo di 1',
            'rooms.max' => 'Il campo numero di stanze deve avere un valore massimo di 30',
            'beds.required' => 'Il campo posti letto è obbligatorio',
            'beds.integer' => 'Il campo posti letto deve essere un numero intero',
            'beds.min' => 'Il campo posti letto deve avere un valore minimo di 1',
            'beds.max' => 'Il campo posti letto deve avere un valore massimo di 90',
            'bathrooms.required' => 'Il campo numero di bagni è obbligatorio',
            'bathrooms.integer' => 'Il campo numero di bagni deve essere un numero intero',
            'bathrooms.min' => 'Il campo numero di bagni deve avere un valore minimo di 1',
            'bathrooms.max' => 'Il campo numero di bagni deve avere un valore massimo di 10',
            'square_mt.required' => 'Il campo metri quadrati è obbligatorio',
            'square_mt.integer' => 'Il campo metri quadrati deve essere un numero intero',
            'address.required' => 'Il campo indirizzo è obbligatorio',
            'address.string' => 'Il campo tindirizzo deve essere una stringa',
            'address.max' =>   'il campo indirizzo non deve superare i 255 caratteri',
            'price_per_night.required' => 'Il campo prezzo per notte è obbligatorio',
            'price_per_night.numeric' => 'Il campo prezzo per notte deve essere un numero',
            'price_per_night.min' => 'Il campo prezzo per notte deve avere un valore minimo di 1',
            'price_per_night.max' => 'Il campo prezzo per notte deve un valore massimo di 9999.99',
        ];
    }
}
