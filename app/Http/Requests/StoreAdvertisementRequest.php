<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdvertisementRequest extends FormRequest {
    public function authorize (): bool {
        return true;
    }

    /**
     * Prepare the data for validation.
     * Convert checkbox values to proper booleans.
     */
    protected function prepareForValidation()
    {
        $booleanFields = [
            'service_history_available',
            'warranty_available',
            'financing_available',
            'trade_in_possible',
            'available_immediately',
            'price_negotiable',
            'tax_deductible',
            'coupon_documentation',
            'damaged_vehicle',
            'is_metallic_paint',
            'show_phone',
            'first_owner',
        ];

        $data = [];
        foreach ($booleanFields as $field) {
            if ($this->has($field)) {
                // Convert to boolean: 'on', '1', 1, true → true; anything else → false
                $data[$field] = filter_var($this->input($field), FILTER_VALIDATE_BOOLEAN);
            } else {
                // If field is not present (unchecked checkbox), set to false
                $data[$field] = false;
            }
        }

        $this->merge($data);
    }

    public function rules (): array {
        // Check if this is an edit operation (has advertisement_id)
        $isEdit = $this->has('advertisement_id');
        
        return [
            // Basic required fields first (in form order)
            'provider_id' => 'required|exists:providers,id' ,
            'advertisement_type_id' => 'required|exists:advertisement_types,id' ,
            'brand_id' => 'required|exists:brands,id' ,
            'vehicle_model_id' => 'required|exists:vehicle_models,id' ,
            'vehicle_body_id' => 'required|exists:vehicle_bodies,id' ,
            'vehicle_category' => 'required|string|max:255' ,
            'mileage' => 'required|integer|min:0|max:999999' ,
            'registration_month' => 'required|string|max:2' ,
            'registration_year' => 'required|string|max:4' ,
            'motor_power_kw' => 'required|integer|min:1|max:2000' ,
            'motor_power_cv' => 'required|integer|min:1|max:3000' ,
            'fuel_type_id' => 'required|string|max:50' ,
            'final_price' => 'required|string|max:255' ,
            'zip_code' => 'required|string|max:20' ,
            'city' => 'required|string|max:100' ,
            
            // Seller Type
            'seller_type' => 'nullable|string|in:private,dealer' ,
            
            // Vehicle Condition
            'service_history_available' => 'nullable|boolean' ,
            'warranty_available' => 'nullable|boolean' ,
            
            // Technical Specs
            'drive_type' => 'nullable|string|in:Chain,Belt,Shaft' ,
            'tank_capacity_liters' => 'nullable|numeric|min:0|max:100' ,
            'seat_height_mm' => 'nullable|integer|min:0|max:2000' ,
            'top_speed_kmh' => 'nullable|integer|min:0|max:500' ,
            'torque_nm' => 'nullable|integer|min:0|max:10000' ,
            
            // Sales Features
            'financing_available' => 'nullable|boolean' ,
            'trade_in_possible' => 'nullable|boolean' ,
            'available_immediately' => 'nullable|boolean' ,
            'price_negotiable' => 'nullable|boolean' ,
            'tax_deductible' => 'nullable|boolean' ,
            
            // Vehicle Condition Booleans
            
           
            'is_metallic_paint' => 'nullable|boolean' ,
            'show_phone' => 'nullable|boolean' ,
            
            
            // Optional fields with proper limits
            'version_model' => 'nullable|string|max:255' ,
            'color_id' => 'nullable|exists:vehicle_colors,id' ,
            'previous_owners' => 'nullable|integer|min:0|max:20' ,
            'next_review_year' => 'nullable|string|max:4' ,
            'next_review_month' => 'nullable|string|max:2' ,
            'last_service_month' => 'nullable|string|max:2' ,
            'last_service_year' => 'nullable|string|max:4' ,
            'motor_change' => 'nullable|string|max:50' ,
            'motor_marches' => 'nullable|integer|min:1|max:20' ,
            'motor_cylinders' => 'nullable|integer|min:1|max:20' ,
            'motor_displacement' => 'nullable|integer|min:50|max:10000' ,
            'motor_empty_weight' => 'nullable|integer|min:50|max:50000' ,
            'combined_fuel_consumption' => 'nullable|numeric|min:0|max:50' ,
            'co2_emissions' => 'nullable|integer|min:0|max:1000' ,
            'emissions_class' => 'nullable|string|max:50' ,
            'description' => 'nullable|string' ,
            'international_prefix' => 'nullable|string|max:5' ,
            'telephone' => 'nullable|string|regex:/^[0-9]{8}$/',
            
            // Image validation - required for new ads, optional for edits
            'images' => $isEdit ? 'nullable|array' : 'required|array|min:1',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB max per image
        ];
    }

    /**
     * Get custom validation messages
     */
    public function messages(): array
    {
        return [
          
            'telephone.regex' => 'The telephone number must be exactly 8 digits.',
        ];
    }
}
