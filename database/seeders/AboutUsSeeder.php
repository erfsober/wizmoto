<?php

namespace Database\Seeders;

use App\Models\AboutUs;
use Illuminate\Database\Seeder;

class AboutUsSeeder extends Seeder
{
    public function run(): void
    {
        $aboutSections = [
            [
                'title' => 'Our Mission',
                'content' => 'At Wizmoto, our mission is to connect motorcycle, scooter, and bike enthusiasts with their perfect vehicle. We provide a trusted marketplace where buyers and sellers can connect safely and efficiently.',
                'section' => 'mission',
                'sort' => 1,
            ],
            [
                'title' => 'Our Story',
                'content' => 'Founded in 2024, Wizmoto emerged from a passion for two-wheeled vehicles and the need for a reliable, user-friendly marketplace. Our team of automotive enthusiasts understood the challenges faced by both buyers and sellers in the vehicle market.',
                'section' => 'story',
                'sort' => 2,
            ],
            [
                'title' => 'Why Choose Wizmoto',
                'content' => 'We offer verified listings, secure messaging, detailed vehicle information, and a network of trusted dealers. Our platform ensures transparency, safety, and convenience for all users.',
                'section' => 'why-choose',
                'sort' => 3,
            ],
            [
                'title' => 'Our Values',
                'content' => 'Transparency, Trust, Quality, and Customer satisfaction are at the core of everything we do. We believe in creating lasting relationships with our users and providing exceptional service.',
                'section' => 'values',
                'sort' => 4,
            ],
        ];

        foreach ($aboutSections as $section) {
            AboutUs::updateOrCreate(
                ['section' => $section['section']],
                $section
            );
        }
    }
}
