<?php

namespace App;

enum IndustrySector: string
{
    case Construction = 'construction';
    case Technology = 'technology';
    case FoodAndBeverage = 'food_and_beverage';
    case Healthcare = 'healthcare';
    case Chemicals = 'chemicals';
    case Logistics = 'logistics';
    case RealEstate = 'real_estate';
    case Agriculture = 'agriculture';

    /**
     * Human-readable label for this sector.
     */
    public function label(): string
    {
        return match ($this) {
            self::Construction => 'Construction & Building',
            self::Technology => 'IT & Technology',
            self::FoodAndBeverage => 'Food & Beverage',
            self::Healthcare => 'Healthcare & Pharma',
            self::Chemicals => 'Chemicals & Raw Materials',
            self::Logistics => 'Logistics & Transport',
            self::RealEstate => 'Real Estate & Property',
            self::Agriculture => 'Agriculture & Farming',
        };
    }

    /**
     * Short description for sector selection cards.
     */
    public function description(): string
    {
        return match ($this) {
            self::Construction => 'Building materials, tools, equipment, and construction services.',
            self::Technology => 'Software, hardware, IT services, and tech solutions.',
            self::FoodAndBeverage => 'Restaurants, catering, food production, and beverage distribution.',
            self::Healthcare => 'Medical supplies, pharmaceuticals, and healthcare services.',
            self::Chemicals => 'Industrial chemicals, raw materials, and chemical products.',
            self::Logistics => 'Freight, shipping, warehousing, and transport services.',
            self::RealEstate => 'Property listings, real estate services, and property management.',
            self::Agriculture => 'Farm produce, agricultural supplies, and farming equipment.',
        };
    }

    /**
     * Heroicon name for UI display.
     */
    public function icon(): string
    {
        return match ($this) {
            self::Construction => 'heroicon-o-wrench-screwdriver',
            self::Technology => 'heroicon-o-cpu-chip',
            self::FoodAndBeverage => 'heroicon-o-cake',
            self::Healthcare => 'heroicon-o-heart',
            self::Chemicals => 'heroicon-o-beaker',
            self::Logistics => 'heroicon-o-truck',
            self::RealEstate => 'heroicon-o-home-modern',
            self::Agriculture => 'heroicon-o-sun',
        };
    }

    /**
     * Tailwind color class for badges and cards.
     */
    public function color(): string
    {
        return match ($this) {
            self::Construction => 'amber',
            self::Technology => 'blue',
            self::FoodAndBeverage => 'orange',
            self::Healthcare => 'red',
            self::Chemicals => 'purple',
            self::Logistics => 'indigo',
            self::RealEstate => 'emerald',
            self::Agriculture => 'green',
        };
    }

    /**
     * Required compliance documents for this sector.
     *
     * Each entry: ['key' => string, 'label' => string, 'description' => string, 'required' => bool, 'mimes' => string]
     *
     * @return array<int, array{key: string, label: string, description: string, required: bool, mimes: string}>
     */
    public function requiredDocuments(): array
    {
        $common = [
            ['key' => 'dti_sec_registration', 'label' => 'DTI / SEC Registration', 'description' => 'Certificate of business name registration (DTI) or SEC incorporation papers.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
            ['key' => 'business_permit', 'label' => "Mayor's Permit / Business Permit", 'description' => 'Valid local business permit from your city or municipality.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
            ['key' => 'bir_registration', 'label' => 'BIR Certificate of Registration', 'description' => 'BIR Form 2303 — Certificate of Registration.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
        ];

        $sectorSpecific = match ($this) {
            self::Construction => [
                ['key' => 'pcab_license', 'label' => 'PCAB License', 'description' => 'Philippine Contractors Accreditation Board license for contracting services.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'contractor_insurance', 'label' => "Contractor's All-Risk Insurance", 'description' => 'Proof of contractor insurance coverage.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
            ],
            self::Technology => [
                ['key' => 'peza_certification', 'label' => 'PEZA / BOI Registration', 'description' => 'PEZA or BOI certification if applicable to your IT business.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'data_privacy_compliance', 'label' => 'NPC Registration Certificate', 'description' => 'National Privacy Commission registration for data processing.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
            ],
            self::FoodAndBeverage => [
                ['key' => 'fda_lto', 'label' => 'FDA License to Operate (LTO)', 'description' => 'Food and Drug Administration license for food manufacturing or distribution.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'sanitary_permit', 'label' => 'Sanitary Permit', 'description' => 'Sanitary permit from the local health office.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'halal_certification', 'label' => 'Halal Certification', 'description' => 'Halal certification if applicable.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
            ],
            self::Healthcare => [
                ['key' => 'fda_lto', 'label' => 'FDA License to Operate (LTO)', 'description' => 'FDA license for pharmaceutical or medical device distribution.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'doh_license', 'label' => 'DOH License', 'description' => 'Department of Health license for healthcare facilities.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'professional_license', 'label' => 'PRC Professional License', 'description' => 'PRC license for pharmacists, doctors, or medical professionals.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
            ],
            self::Chemicals => [
                ['key' => 'denr_ecc', 'label' => 'DENR Environmental Compliance Certificate', 'description' => 'Environmental Compliance Certificate from DENR for chemical handling.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'pdea_license', 'label' => 'PDEA License', 'description' => 'PDEA license for controlled chemical substances if applicable.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'fda_lto', 'label' => 'FDA License to Operate', 'description' => 'FDA license if dealing with regulated chemical products.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
            ],
            self::Logistics => [
                ['key' => 'ltfrb_franchise', 'label' => 'LTFRB Certificate of Public Convenience', 'description' => 'LTFRB franchise certificate for public transport services.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'lto_registration', 'label' => 'LTO Vehicle Registration', 'description' => 'Land Transportation Office registration for fleet vehicles.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'freight_forwarder_accreditation', 'label' => 'Freight Forwarder Accreditation', 'description' => 'DTI accreditation as a freight forwarder if applicable.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
            ],
            self::RealEstate => [
                ['key' => 'prc_broker_license', 'label' => 'PRC Real Estate Broker License', 'description' => 'Professional license from PRC for real estate brokerage.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'dhsud_license', 'label' => 'DHSUD License to Sell', 'description' => 'Department of Human Settlements license to sell for developers.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
            ],
            self::Agriculture => [
                ['key' => 'da_certification', 'label' => 'DA / BAI Certification', 'description' => 'Department of Agriculture or Bureau of Animal Industry certification.', 'required' => true, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'organic_certification', 'label' => 'Organic Certification', 'description' => 'Organic certification if selling organic products.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
                ['key' => 'bfar_license', 'label' => 'BFAR License', 'description' => 'Bureau of Fisheries and Aquatic Resources license for fishery products.', 'required' => false, 'mimes' => 'pdf,jpg,jpeg,png'],
            ],
        };

        return array_merge($common, $sectorSpecific);
    }

    /**
     * Get just the required document keys for validation.
     *
     * @return list<string>
     */
    public function requiredDocumentKeys(): array
    {
        return array_values(array_map(
            fn (array $doc) => $doc['key'],
            array_filter($this->requiredDocuments(), fn (array $doc) => $doc['required']),
        ));
    }
}
