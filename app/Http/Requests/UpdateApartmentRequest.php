<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

// Helpers
use Illuminate\Support\Facades\Auth;

class UpdateApartmentRequest extends FormRequest
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
            // 'user_id' => 'nullable|exists:users,id',
            'name' => 'required|string|max:100',
            'type_of_accomodation' => 'required|string|max:100',
            'n_guests' => 'required|numeric|gte:1|max:10',
            'n_rooms' => 'required|numeric|gte:1|max:6',
            'n_beds' => 'required|numeric|gte:1|max:9',
            'mq' => 'required|numeric|gte:20|max:150',
            'n_baths' => 'required|numeric|gte:1|max:3',
            'price' => 'required|numeric|gte:1,00|max:1000,00',   
            'address' => 'required|string|max:100',
            'services' => 'required|array|exists:services,id',
            'img_cover_path' => 'nullable|string|max:1000',
            
        ];
    }
}
