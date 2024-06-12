<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\DTOs\FlightDataDTO;

class StoreFlightRequest extends FormRequest
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
            'airline_id' => 'required|exists:airlines,id',
            'departure_city_id' => 'required|exists:cities,id',
            'arrival_city_id' => 'required|exists:cities,id|different:departure_city_id',
            'departure_datetime' => 'required|date|before:arrival_datetime',
            'arrival_datetime' => 'required|date|after:departure_datetime',
        ];
    }

    public function toDTO(): FlightDataDTO
    {
        return new FlightDataDTO(
            $this->input('airline_id'),
            $this->input('departure_city_id'),
            $this->input('arrival_city_id'),
            $this->input('departure_datetime'),
            $this->input('arrival_datetime'),
        );
    }
}
