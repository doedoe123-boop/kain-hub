<?php

namespace Database\Seeders;

use App\Models\Faq;
use Illuminate\Database\Seeder;

class FaqSeeder extends Seeder
{
    /**
     * Seed the FAQs table with starter questions.
     */
    public function run(): void
    {
        $faqs = [
            [
                'question' => 'What is NegosyoHub?',
                'answer' => '<p>NegosyoHub is a multi-sector B2B marketplace that connects verified suppliers with buyers across the Philippines. From food service to agriculture to construction, our platform streamlines procurement with built-in compliance and secure transactions.</p>',
                'sort_order' => 1,
            ],
            [
                'question' => 'How do I register as a store owner?',
                'answer' => '<p>Click <strong>"Start Selling"</strong> on the homepage and complete our 5-step registration process. You\'ll need to provide your business details, store information, address, a valid government ID, and any sector-specific compliance documents. Approval typically takes 1–3 business days.</p>',
                'sort_order' => 2,
            ],
            [
                'question' => 'What documents are required for registration?',
                'answer' => '<p>Requirements vary by industry sector. Common documents include:</p><ul><li>Valid government-issued ID</li><li>Business permit or DTI/SEC registration</li><li>Sector-specific licenses (e.g., FDA for food, PRC for professional services)</li></ul><p>The registration form will show you exactly which documents are needed for your chosen sector.</p>',
                'sort_order' => 3,
            ],
            [
                'question' => 'How long does store approval take?',
                'answer' => '<p>Most store applications are reviewed within <strong>1–3 business days</strong>. You\'ll receive an email notification once your store is approved. If additional documents are needed, our team will reach out to you directly.</p>',
                'sort_order' => 4,
            ],
            [
                'question' => 'Is my personal data secure?',
                'answer' => '<p>Absolutely. All sensitive information — including government IDs and compliance documents — is encrypted using <strong>AES-256-CBC</strong> encryption. Only authorized platform administrators can access your documents, and we follow strict data protection practices.</p>',
                'sort_order' => 5,
            ],
            [
                'question' => 'What industry sectors does NegosyoHub support?',
                'answer' => '<p>We currently support eight industry sectors:</p><ul><li>Food Service &amp; Restaurant Supply</li><li>Agriculture &amp; Farming</li><li>Construction &amp; Building Materials</li><li>Healthcare &amp; Medical Supply</li><li>Electronics &amp; Technology</li><li>Textile &amp; Fashion</li><li>Industrial &amp; Manufacturing</li><li>General Merchandise</li></ul>',
                'sort_order' => 6,
            ],
            [
                'question' => 'How does the commission and payout system work?',
                'answer' => '<p>NegosyoHub charges a small platform commission on each completed order. The remaining amount is credited to your store payout balance. Payouts are processed on a regular schedule through your preferred payment method.</p>',
                'sort_order' => 7,
            ],
            [
                'question' => 'Can customers order from multiple stores at once?',
                'answer' => '<p>Currently, each order is placed with a <strong>single store</strong> to ensure accurate fulfillment and delivery. You can place separate orders with different stores back-to-back.</p>',
                'sort_order' => 8,
            ],
        ];

        foreach ($faqs as $faq) {
            Faq::updateOrCreate(
                ['question' => $faq['question']],
                $faq,
            );
        }
    }
}
