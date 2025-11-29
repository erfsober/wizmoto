<?php

namespace App\Console\Commands;

use App\Models\VehicleColor;
use Illuminate\Console\Command;

class UpdateVehicleColorHexCodes extends Command
{
    protected $signature = 'colors:update-hex-codes';
    protected $description = 'Update hex codes for vehicle colors that are missing them';

    /**
     * Get hex code for a color name by matching common color patterns.
     */
    private function getHexCodeForColor(string $colorName): ?string
    {
        $colorName = mb_strtolower(trim($colorName));
        
        // Comprehensive color mapping (handles Italian, English, and variations)
        $colorMap = [
            // Black variations
            'black' => '#000000',
            'nero' => '#000000',
            'nere' => '#000000',
            'nera' => '#000000',
            
            // White variations
            'white' => '#FFFFFF',
            'bianco' => '#FFFFFF',
            'bianca' => '#FFFFFF',
            'bianche' => '#FFFFFF',
            
            // Red variations
            'red' => '#FF0000',
            'rosso' => '#FF0000',
            'rossa' => '#FF0000',
            'rosse' => '#FF0000',
            'crimson' => '#DC143C',
            'crimson red' => '#DC143C',
            'rosso scarlatto' => '#DC143C',
            'dark red' => '#8B0000',
            'rosso scuro' => '#8B0000',
            
            // Blue variations
            'blue' => '#0000FF',
            'blu' => '#0000FF',
            'azzurro' => '#007FFF',
            'azzurra' => '#007FFF',
            'navy blue' => '#000080',
            'blu navy' => '#000080',
            'blu marino' => '#000080',
            'dark blue' => '#00008B',
            'blu scuro' => '#00008B',
            'light blue' => '#ADD8E6',
            'azzurro chiaro' => '#ADD8E6',
            'blue marlin' => '#1E3A8A',
            'blu marlin' => '#1E3A8A',
            
            // Green variations
            'green' => '#008000',
            'verde' => '#008000',
            'verdi' => '#008000',
            'dark green' => '#006400',
            'verde scuro' => '#006400',
            'light green' => '#90EE90',
            'verde chiaro' => '#90EE90',
            'lime' => '#00FF00',
            'lime green' => '#00FF00',
            'verde lime' => '#00FF00',
            
            // Yellow/Gold variations
            'yellow' => '#FFFF00',
            'giallo' => '#FFFF00',
            'gialla' => '#FFFF00',
            'gialle' => '#FFFF00',
            'gold' => '#FFD700',
            'oro' => '#FFD700',
            'dorato' => '#FFD700',
            'dorata' => '#FFD700',
            
            // Orange variations
            'orange' => '#FFA500',
            'arancione' => '#FFA500',
            'arancioni' => '#FFA500',
            
            // Brown variations
            'brown' => '#A52A2A',
            'marrone' => '#A52A2A',
            'marroni' => '#A52A2A',
            'tan' => '#D2B48C',
            
            // Grey/Silver variations
            'grey' => '#808080',
            'gray' => '#808080',
            'grigio' => '#808080',
            'grigia' => '#808080',
            'grigie' => '#808080',
            'silver' => '#C0C0C0',
            'argento' => '#C0C0C0',
            'argenteo' => '#C0C0C0',
            'argentea' => '#C0C0C0',
            'metallic grey' => '#8C8C8C',
            'grigio metallico' => '#8C8C8C',
            'dark grey' => '#A9A9A9',
            'grigio scuro' => '#A9A9A9',
            'light grey' => '#D3D3D3',
            'grigio chiaro' => '#D3D3D3',
            
            // Purple variations
            'purple' => '#800080',
            'viola' => '#800080',
            'violet' => '#800080',
            'violetto' => '#800080',
            
            // Pink variations
            'pink' => '#FFC0CB',
            'rosa' => '#FFC0CB',
            'rose' => '#FFC0CB',
            
            // Beige/Cream variations
            'beige' => '#F5F5DC',
            'crema' => '#FFFDD0',
            'cream' => '#FFFDD0',
            
            // Bronze variations
            'bronze' => '#CD7F32',
            'bronzo' => '#CD7F32',
            
            // Metallic colors
            'metallic' => '#8C8C8C',
            'metallico' => '#8C8C8C',
            'metallic blue' => '#4C6A92',
            'blu metallico' => '#4C6A92',
            'metallic red' => '#8B0000',
            'rosso metallico' => '#8B0000',
            'metallic black' => '#1A1A1A',
            'nero metallico' => '#1A1A1A',
            'metallic silver' => '#BCC6CC',
            'argento metallico' => '#BCC6CC',
        ];
        
        // Direct match
        if (isset($colorMap[$colorName])) {
            return $colorMap[$colorName];
        }
        
        // Partial match (e.g., "BLUE MARLIN" contains "blue")
        foreach ($colorMap as $key => $hex) {
            if (str_contains($colorName, $key) || str_contains($key, $colorName)) {
                return $hex;
            }
        }
        
        // Try matching common patterns
        if (str_contains($colorName, 'black') || str_contains($colorName, 'nero')) {
            return '#000000';
        }
        if (str_contains($colorName, 'white') || str_contains($colorName, 'bianco')) {
            return '#FFFFFF';
        }
        if (str_contains($colorName, 'red') || str_contains($colorName, 'rosso')) {
            return '#FF0000';
        }
        if (str_contains($colorName, 'blue') || str_contains($colorName, 'blu') || str_contains($colorName, 'azzurro')) {
            return '#0000FF';
        }
        if (str_contains($colorName, 'green') || str_contains($colorName, 'verde')) {
            return '#008000';
        }
        if (str_contains($colorName, 'yellow') || str_contains($colorName, 'giallo')) {
            return '#FFFF00';
        }
        if (str_contains($colorName, 'silver') || str_contains($colorName, 'argento')) {
            return '#C0C0C0';
        }
        if (str_contains($colorName, 'grey') || str_contains($colorName, 'gray') || str_contains($colorName, 'grigio')) {
            return '#808080';
        }
        
        // Default to a neutral grey if no match found
        return '#808080';
    }

    public function handle()
    {
        $colors = VehicleColor::whereNull('hex_code')
            ->orWhere('hex_code', '')
            ->get();

        if ($colors->isEmpty()) {
            $this->info('No colors found without hex codes.');
            return 0;
        }

        $this->info("Found {$colors->count()} color(s) without hex codes. Updating...");

        $updated = 0;
        foreach ($colors as $color) {
            // Try to get hex code from name_it first, then name
            $colorName = $color->name_it ?? $color->name;
            
            if (!$colorName) {
                $this->warn("Color ID {$color->id} has no name, skipping.");
                continue;
            }

            $hexCode = $this->getHexCodeForColor($colorName);
            
            if ($hexCode) {
                $color->hex_code = $hexCode;
                $color->save();
                $this->line("Updated: {$colorName} → {$hexCode}");
                $updated++;
            } else {
                $this->warn("Could not determine hex code for: {$colorName}");
            }
        }

        $this->info("Successfully updated {$updated} color(s).");
        return 0;
    }
}

