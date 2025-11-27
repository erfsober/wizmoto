<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeocodingService
{
    /**
     * Geocode a location (city, zip code, country) to coordinates
     */
    public function geocode(string $city, ?string $zipCode = null, ?string $country = null): ?array
    {
        // Build the address string
        $address = $this->buildAddressString($city, $zipCode, $country);
        
        if (empty($address)) {
            return null;
        }

        // Try multiple geocoding services in order of preference
        $services = [
            'openstreetmap' => fn() => $this->geocodeWithOpenStreetMap($address),
            'fallback' => fn() => $this->geocodeWithFallback($city, $zipCode, $country),
        ];

        foreach ($services as $serviceName => $service) {
            try {
                $result = $service();
                if ($result) {
                    return $result;
                }
            } catch (\Exception $e) {
                continue;
            }
        }

        return null;
    }

    /**
     * Geocode using OpenStreetMap Nominatim (free service)
     */
    private function geocodeWithOpenStreetMap(string $address): ?array
    {
        $response = Http::timeout(10)->get('https://nominatim.openstreetmap.org/search', [
            'q' => $address,
            'format' => 'json',
            'limit' => 1,
            'addressdetails' => 1,
            'countrycodes' => $this->getCountryCode(),
        ]);

        if (!$response->successful()) {
            return null;
        }

        $data = $response->json();
        
        if (empty($data) || !isset($data[0]['lat']) || !isset($data[0]['lon'])) {
            return null;
        }

        return [
            'latitude' => (float) $data[0]['lat'],
            'longitude' => (float) $data[0]['lon'],
            'source' => 'openstreetmap',
            'formatted_address' => $data[0]['display_name'] ?? $address,
        ];
    }

    /**
     * Fallback geocoding using predefined locations
     */
    private function geocodeWithFallback(string $city, ?string $zipCode, ?string $country): ?array
    {
        $cityLower = strtolower(trim($city));
        
        $predefinedLocations = [
            // Major European cities
            'paris' => ['latitude' => 48.8566, 'longitude' => 2.3522, 'country' => 'FR'],
            'london' => ['latitude' => 51.5074, 'longitude' => -0.1278, 'country' => 'GB'],
            'berlin' => ['latitude' => 52.5200, 'longitude' => 13.4050, 'country' => 'DE'],
            'madrid' => ['latitude' => 40.4168, 'longitude' => -3.7038, 'country' => 'ES'],
            'rome' => ['latitude' => 41.9028, 'longitude' => 12.4964, 'country' => 'IT'],
            'amsterdam' => ['latitude' => 52.3676, 'longitude' => 4.9041, 'country' => 'NL'],
            'brussels' => ['latitude' => 50.8503, 'longitude' => 4.3517, 'country' => 'BE'],
            'vienna' => ['latitude' => 48.2082, 'longitude' => 16.3738, 'country' => 'AT'],
            'zurich' => ['latitude' => 47.3769, 'longitude' => 8.5417, 'country' => 'CH'],
            'munich' => ['latitude' => 48.1351, 'longitude' => 11.5820, 'country' => 'DE'],
            'hamburg' => ['latitude' => 53.5511, 'longitude' => 9.9937, 'country' => 'DE'],
            'cologne' => ['latitude' => 50.9375, 'longitude' => 6.9603, 'country' => 'DE'],
            'frankfurt' => ['latitude' => 50.1109, 'longitude' => 8.6821, 'country' => 'DE'],
            'stuttgart' => ['latitude' => 48.7758, 'longitude' => 9.1829, 'country' => 'DE'],
            'düsseldorf' => ['latitude' => 51.2277, 'longitude' => 6.7735, 'country' => 'DE'],
            'barcelona' => ['latitude' => 41.3851, 'longitude' => 2.1734, 'country' => 'ES'],
            'milan' => ['latitude' => 45.4642, 'longitude' => 9.1900, 'country' => 'IT'],
            'naples' => ['latitude' => 40.8518, 'longitude' => 14.2681, 'country' => 'IT'],
            'turin' => ['latitude' => 45.0703, 'longitude' => 7.6869, 'country' => 'IT'],
            'rotterdam' => ['latitude' => 51.9244, 'longitude' => 4.4777, 'country' => 'NL'],
            'the hague' => ['latitude' => 52.0705, 'longitude' => 4.3007, 'country' => 'NL'],
            'utrecht' => ['latitude' => 52.0907, 'longitude' => 5.1214, 'country' => 'NL'],
        ];

        // Try exact match first
        if (isset($predefinedLocations[$cityLower])) {
            $location = $predefinedLocations[$cityLower];
            return [
                'latitude' => $location['latitude'],
                'longitude' => $location['longitude'],
                'source' => 'fallback_exact',
                'formatted_address' => ucfirst($cityLower) . ', ' . $location['country'],
            ];
        }

        // Try partial match
        foreach ($predefinedLocations as $key => $location) {
            if (str_contains($cityLower, $key) || str_contains($key, $cityLower)) {
                return [
                    'latitude' => $location['latitude'],
                    'longitude' => $location['longitude'],
                    'source' => 'fallback_partial',
                    'formatted_address' => ucfirst($key) . ', ' . $location['country'],
                ];
            }
        }

        return null;
    }

    /**
     * Build address string for geocoding
     */
    private function buildAddressString(string $city, ?string $zipCode, ?string $country): string
    {
        $parts = array_filter([
            $zipCode,
            $city,
            $country ?: $this->getDefaultCountry(),
        ]);

        return implode(', ', $parts);
    }

    /**
     * Get country code for geocoding (you can make this configurable)
     */
    private function getCountryCode(): string
    {
        return 'DE,FR,ES,IT,NL,BE,AT,CH,GB'; // European countries
    }

    /**
     * Get default country if none specified
     */
    private function getDefaultCountry(): string
    {
        return 'Germany'; // You can make this configurable
    }

    /**
     * Reverse geocode coordinates to address
     */
    public function reverseGeocode(float $latitude, float $longitude): ?array
    {
        try {
            $response = Http::timeout(10)->get('https://nominatim.openstreetmap.org/reverse', [
                'lat' => $latitude,
                'lon' => $longitude,
                'format' => 'json',
                'addressdetails' => 1,
            ]);

            if (!$response->successful()) {
                return null;
            }

            $data = $response->json();
            
            if (empty($data)) {
                return null;
            }

            return [
                'formatted_address' => $data['display_name'] ?? null,
                'city' => $data['address']['city'] ?? $data['address']['town'] ?? $data['address']['village'] ?? null,
                'postal_code' => $data['address']['postcode'] ?? null,
                'country' => $data['address']['country'] ?? null,
                'country_code' => $data['address']['country_code'] ?? null,
            ];
        } catch (\Exception $e) {
            return null;
        }
    }
}
