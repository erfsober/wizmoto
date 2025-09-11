<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        $faqs = [
            // Buying Questions
            [
                'question' => 'How do I search for vehicles on Wizmoto?',
                'answer' => 'Use our advanced search filters to find vehicles by type, brand, model, price range, location, and more. You can also browse by categories or use the quick search bar.',
                'category' => 'buying',
                'sort' => 1,
            ],
            [
                'question' => 'How do I contact a seller?',
                'answer' => 'Click the "Send Message" button on any vehicle listing to contact the seller directly. You can ask questions, request more photos, or arrange a viewing.',
                'category' => 'buying',
                'sort' => 2,
            ],
            [
                'question' => 'Are the vehicles inspected?',
                'answer' => 'While we encourage detailed listings, vehicle inspections are the responsibility of buyers. We recommend viewing and testing any vehicle before purchase.',
                'category' => 'buying',
                'sort' => 3,
            ],
            [
                'question' => 'What payment methods are accepted?',
                'answer' => 'Payment methods vary by seller. Most accept cash, bank transfers, or financing options. Always verify payment terms with the seller before proceeding.',
                'category' => 'buying',
                'sort' => 4,
            ],

            // Selling Questions
            [
                'question' => 'How do I list my vehicle for sale?',
                'answer' => 'Create a dealer account, complete your profile, and use our "Create Advertisement" feature to list your vehicle with photos, description, and specifications.',
                'category' => 'selling',
                'sort' => 1,
            ],
            [
                'question' => 'How much does it cost to list a vehicle?',
                'answer' => 'Basic listings are free for registered dealers. Premium features and promoted listings may have additional costs. Check our pricing page for current rates.',
                'category' => 'selling',
                'sort' => 2,
            ],
            [
                'question' => 'How do I manage my listings?',
                'answer' => 'Access your dealer dashboard to view, edit, promote, or remove your listings. You can also track inquiries and manage your profile information.',
                'category' => 'selling',
                'sort' => 3,
            ],
            [
                'question' => 'Can I edit my listing after publishing?',
                'answer' => 'Yes, you can edit your listings anytime through your dealer dashboard. Update prices, descriptions, photos, or any other details as needed.',
                'category' => 'selling',
                'sort' => 4,
            ],

            // General Questions
            [
                'question' => 'Is Wizmoto free to use?',
                'answer' => 'Yes, browsing and basic features are completely free. Creating a dealer account and basic listings are also free. Premium features may have costs.',
                'category' => 'general',
                'sort' => 1,
            ],
            [
                'question' => 'How do I create an account?',
                'answer' => 'Click "Register" to create a dealer account. Fill in your business information, verify your email, and start listing your vehicles immediately.',
                'category' => 'general',
                'sort' => 2,
            ],
            [
                'question' => 'Is my personal information safe?',
                'answer' => 'Yes, we take privacy seriously. Your personal information is protected and never shared without your consent. Read our Privacy Policy for details.',
                'category' => 'general',
                'sort' => 3,
            ],
            [
                'question' => 'How do I report a problem?',
                'answer' => 'Contact our support team through the contact form, email us directly, or use the "Report" feature on listings. We respond to all inquiries promptly.',
                'category' => 'general',
                'sort' => 4,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                [
                    'question' => $faq['question'],
                    'category' => $faq['category']
                ],
                $faq
            );
        }
    }
}
