<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertisementRequest extends FormRequest {
    public function authorize (): bool {
        return true;
    }

    public function rules (): array {
        return [
            'provider_id' => 'required|exists:providers,id' ,
            'advertisement_type_id' => 'required|exists:advertisement_types,id' ,
            // Vehicle data
            'brand_id' => 'required|exists:brands,id' ,
            'vehicle_model_id' => 'required|exists:vehicle_models,id' ,
            'version_model' => 'nullable|string|max:255' ,
            // Characteristics
            'vehicle_body_id' => 'required|exists:vehicle_bodies,id' ,
            'color_id' => 'nullable|exists:vehicle_colors,id' ,
            'vehicle_category' => 'required|string|max:255' ,
            'mileage' => 'required|integer' ,
            'registration_month' => 'required|string|max:2' ,
            'registration_year' => 'required|string|max:4' ,
            'previous_owners' => 'nullable|integer' ,
            'next_review_year' => 'nullable|string|max:4' ,
            'next_review_month' => 'nullable|string|max:2' ,
            'last_service_month' => 'nullable|string|max:2' ,
            'last_service_year' => 'nullable|string|max:4' ,
            // Motor
            'motor_change' => 'nullable|string|max:50' ,
            'motor_power_kw' => 'required|integer' ,
            'motor_power_cv' => 'required|integer' ,
            'motor_marches' => 'nullable|integer' ,
            'motor_cylinders' => 'nullable|integer' ,
            'motor_displacement' => 'nullable|integer' ,
            'motor_empty_weight' => 'nullable|integer' ,
            // Environment
            'fuel_type_id' => 'required|string|max:50' ,
            'combined_fuel_consumption' => 'nullable|numeric' ,
            'co2_emissions' => 'nullable|integer' ,
            'emissions_class' => 'nullable|string|max:50' ,
            // Description
            'description' => 'nullable|string' ,
            // Price
            'final_price' => 'required|string|max:255' ,
            // Address
            'zip_code' => 'required|string|max:20' ,
            'city' => 'required|string|max:100' ,
            'international_prefix' => 'nullable|string|max:5' ,
            'prefix' => 'nullable|string|max:5' ,
            'telephone' => 'nullable|string|max:20' ,
        ];
    }
}
