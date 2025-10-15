<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Add WhatsApp number setting
        Setting::set(
            'whatsapp_number',
            '00393517455691',
            'string',
            'WhatsApp support number for customer support'
        );

        // Add support email setting
        Setting::set(
            'support_email',
            'support@wizmoto.com',
            'string',
            'Support email address for customer inquiries'
        );

        // Add support enabled setting
        Setting::set(
            'support_enabled',
            'true',
            'boolean',
            'Enable or disable support chat functionality'
        );
    }
}