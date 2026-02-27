<?php

namespace Database\Seeders;

use App\Models\LegalPage;
use Illuminate\Database\Seeder;

class LegalPageSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'type' => 'terms',
                'title' => 'Terms & Conditions',
                'slug' => 'terms-and-conditions',
                'is_published' => true,
                'published_at' => now(),
                'content' => $this->termsContent(),
            ],
            [
                'type' => 'privacy',
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'is_published' => true,
                'published_at' => now(),
                'content' => $this->privacyContent(),
            ],
            [
                'type' => 'store_agreement',
                'title' => 'Supplier Agreement',
                'slug' => 'supplier-agreement',
                'is_published' => true,
                'published_at' => now(),
                'content' => $this->supplierAgreementContent(),
            ],
        ];

        foreach ($pages as $page) {
            LegalPage::updateOrCreate(['slug' => $page['slug']], $page);
        }
    }

    private function termsContent(): string
    {
        return <<<'HTML'
<h2>1. Acceptance of Terms</h2>
<p>By accessing or using NegosyoHub ("Platform"), you agree to be bound by these Terms &amp; Conditions. If you do not agree to these terms, please do not use the Platform.</p>

<h2>2. Platform Description</h2>
<p>NegosyoHub is a B2B marketplace that connects verified Filipino suppliers with buyers across various industry sectors including Food &amp; Beverage, Construction, Technology, Healthcare, Logistics, Real Estate, Agriculture, and Chemicals.</p>

<h2>3. Eligibility</h2>
<p>You must be at least 18 years old and a registered business entity in the Philippines to use NegosyoHub as a supplier. Buyer accounts are open to any individual or organization seeking to procure goods or services.</p>

<h2>4. Account Registration &amp; Security</h2>
<p>You are responsible for maintaining the confidentiality of your account credentials. All activity under your account is your responsibility. Notify us immediately at <a href="mailto:support@negosyohub.ph">support@negosyohub.ph</a> if you suspect unauthorized access.</p>

<h2>5. Supplier Verification</h2>
<p>All suppliers must complete KYC (Know Your Customer) verification before their store is approved. NegosyoHub reserves the right to reject or suspend any supplier that fails to meet our compliance standards. Approval typically takes 3–5 business days.</p>

<h2>6. Listings &amp; Transactions</h2>
<p>Suppliers are solely responsible for the accuracy of their product listings, pricing, and availability. NegosyoHub does not warrant the quality or legality of items listed. All transactions are between buyers and suppliers directly.</p>

<h2>7. Prohibited Conduct</h2>
<p>You may not use the Platform to list counterfeit goods, engage in fraudulent transactions, harass other users, or violate any applicable Philippine law including Republic Act No. 8792 (E-Commerce Act) and Republic Act No. 10173 (Data Privacy Act).</p>

<h2>8. Intellectual Property</h2>
<p>All content on the Platform — including logos, UI design, and software — is owned by NegosyoHub or its licensors. You may not reproduce or redistribute any Platform content without prior written consent.</p>

<h2>9. Limitation of Liability</h2>
<p>To the maximum extent permitted by law, NegosyoHub shall not be liable for any indirect, incidental, or consequential damages arising from your use of the Platform.</p>

<h2>10. Governing Law</h2>
<p>These Terms are governed by the laws of the Republic of the Philippines. Any disputes shall be resolved exclusively in the courts of Metro Manila.</p>

<h2>11. Changes to Terms</h2>
<p>We may update these Terms at any time. Continued use of the Platform after changes constitutes your acceptance of the revised Terms. Last reviewed: February 2026.</p>

<h2>12. Contact</h2>
<p>For questions about these Terms, contact us at <a href="mailto:legal@negosyohub.ph">legal@negosyohub.ph</a>.</p>
HTML;
    }

    private function privacyContent(): string
    {
        return <<<'HTML'
<h2>1. Introduction</h2>
<p>NegosyoHub ("we", "us", or "our") is committed to protecting your personal information in accordance with Republic Act No. 10173, the Data Privacy Act of 2012 of the Philippines, and its Implementing Rules and Regulations.</p>

<h2>2. Information We Collect</h2>
<p>We collect the following categories of personal information:</p>
<ul>
  <li><strong>Account Data:</strong> Name, email address, phone number, and password.</li>
  <li><strong>Business Data:</strong> Store name, business description, address, and industry sector.</li>
  <li><strong>KYC Data:</strong> Government-issued ID type and number, and compliance documents (e.g., business permits, DTI registration).</li>
  <li><strong>Transaction Data:</strong> Order history, payment records, and payout information.</li>
  <li><strong>Usage Data:</strong> Log data, IP addresses, browser type, and pages visited.</li>
</ul>

<h2>3. How We Use Your Information</h2>
<p>Your information is used to:</p>
<ul>
  <li>Verify your identity and business credentials during onboarding.</li>
  <li>Process and facilitate transactions between buyers and suppliers.</li>
  <li>Send transactional and administrative communications (e.g., approval emails, order updates).</li>
  <li>Improve platform features and user experience.</li>
  <li>Comply with legal and regulatory obligations.</li>
</ul>

<h2>4. Data Encryption &amp; Security</h2>
<p>Sensitive personal data, including government ID numbers and compliance documents, are encrypted using AES-256-CBC before storage. We employ industry-standard security measures including HTTPS, access controls, and regular security audits.</p>

<h2>5. Data Sharing</h2>
<p>We do not sell your personal data. We may share data with:</p>
<ul>
  <li>Platform administrators for verification and dispute resolution.</li>
  <li>Payment processors for transaction facilitation.</li>
  <li>Government authorities when required by law.</li>
</ul>

<h2>6. Data Retention</h2>
<p>We retain your personal data for as long as your account is active or as required by law. KYC documents are retained for a minimum of 5 years in compliance with anti-money laundering regulations. You may request deletion of your account by contacting us at <a href="mailto:privacy@negosyohub.ph">privacy@negosyohub.ph</a>.</p>

<h2>7. Your Rights</h2>
<p>Under the Data Privacy Act, you have the right to:</p>
<ul>
  <li>Access your personal data held by us.</li>
  <li>Correct inaccurate or incomplete data.</li>
  <li>Request erasure of your data (subject to legal retention requirements).</li>
  <li>Object to or restrict processing in certain circumstances.</li>
  <li>File a complaint with the National Privacy Commission (NPC).</li>
</ul>

<h2>8. Cookies</h2>
<p>We use cookies and similar technologies to maintain your session, remember preferences, and analyze platform usage. You can disable cookies in your browser settings, though this may affect Platform functionality.</p>

<h2>9. Changes to This Policy</h2>
<p>We may update this Privacy Policy periodically. Material changes will be communicated via email or a prominent notice on the Platform. Last reviewed: February 2026.</p>

<h2>10. Contact Our Data Protection Officer</h2>
<p>For privacy-related inquiries or to exercise your rights, contact our DPO at <a href="mailto:privacy@negosyohub.ph">privacy@negosyohub.ph</a>.</p>
HTML;
    }

    private function supplierAgreementContent(): string
    {
        return <<<'HTML'
<h2>1. Agreement Overview</h2>
<p>This Supplier Agreement ("Agreement") governs your participation as a verified supplier on the NegosyoHub marketplace. By completing supplier registration and receiving approval, you agree to these terms.</p>

<h2>2. Supplier Obligations</h2>
<p>As a supplier, you agree to:</p>
<ul>
  <li>Provide accurate and up-to-date product listings, pricing, and inventory information.</li>
  <li>Fulfill orders promptly and as described in your listings.</li>
  <li>Maintain valid business permits and licenses required by your industry sector.</li>
  <li>Respond to buyer inquiries within 2 business days.</li>
  <li>Issue proper receipts or invoices as required by BIR regulations.</li>
</ul>

<h2>3. Prohibited Products &amp; Services</h2>
<p>The following are strictly prohibited on the Platform: counterfeit or unlicensed goods, hazardous substances without proper permits, and any products or services that violate Philippine law.</p>

<h2>4. Commission &amp; Payouts</h2>
<p>NegosyoHub charges a platform commission on each completed transaction. Payout schedules and commission rates are detailed in your supplier dashboard. Rates may be updated with 30 days' notice.</p>

<h2>5. Compliance &amp; Audits</h2>
<p>NegosyoHub reserves the right to audit supplier listings and request updated compliance documents at any time. Failure to maintain compliance may result in store suspension.</p>

<h2>6. Store Suspension &amp; Termination</h2>
<p>We may suspend or terminate a supplier's store for: repeated policy violations, fraudulent activity, sustained negative buyer feedback, or failure to maintain required business documentation.</p>

<h2>7. Dispute Resolution</h2>
<p>In the event of a buyer-supplier dispute, NegosyoHub may mediate but is not obligated to resolve the dispute. Both parties agree to engage in good-faith resolution before escalating to legal proceedings.</p>

<h2>8. Amendment</h2>
<p>This Agreement may be updated with 30 days' written notice. Continued participation on the Platform constitutes acceptance of updated terms. Last reviewed: February 2026.</p>
HTML;
    }
}
