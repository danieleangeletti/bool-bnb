<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Helpers
use Illuminate\Support\Facades\Auth;

class StoreApartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:100',
            'type_of_accomodation' => 'required|string|max:100',
            'n_guests' => 'required|numeric|gte:0|max:255',
            'n_rooms' => 'required|numeric|gte:0|max:255',
            'n_beds' => 'required|numeric|gte:0|max:255',
            'n_baths' => 'required|numeric|gte:0|max:255',
            'price' => 'required|numeric|max:10000',
            // 'availability' => 'required|boolean',
            // 'latitude' => 'required|string|max:100',
            // 'longitude' => 'required|string|max:100',
            // 'slug' => 'required|string|max:100',
            'address' => 'required|string|max:100',
            'city' => 'required|string|max:64',
            'img_cover_path' => 'nullable|string|max:1000',
            // L'img_cover_path è nullable solo momentaneamente, poi dovrà essere required.
        ];
    }
}
