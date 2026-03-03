<?php

namespace Database\Seeders;

use App\Models\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    public function run(): void
    {
        $sectors = [
            [
                'name' => 'E-Commerce',
                'slug' => 'ecommerce',
                'description' => 'Online retail stores, marketplaces, and digital product sellers.',
                'icon' => 'heroicon-o-shopping-cart',
                'color' => 'orange',
                'registration_button_text' => 'Register as Online Store',
                'is_active' => true,
                'sort_order' => 1,
                'documents' => [
                    ['key' => 'dti_sec_registration', 'label' => 'DTI / SEC Registration',           'description' => 'Certificate of business name registration (DTI) or SEC incorporation papers.',        'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 1],
                    ['key' => 'business_permit',       'label' => "Mayor's Permit / Business Permit", 'description' => 'Valid local business permit from your city or municipality.',                        'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 2],
                    ['key' => 'bir_registration',      'label' => 'BIR Certificate of Registration',  'description' => 'BIR Form 2303 — Certificate of Registration.',                                       'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 3],
                    ['key' => 'store_front_photo',     'label' => 'Store / Warehouse Photo',          'description' => 'Clear photo of your physical store, warehouse, or fulfilment centre.',               'is_required' => false, 'mimes' => 'jpg,jpeg,png',     'sort_order' => 4],
                ],
            ],
            [
                'name' => 'Real Estate & Property',
                'slug' => 'real_estate',
                'description' => 'Property listings, real estate services, and property management.',
                'icon' => 'heroicon-o-home-modern',
                'color' => 'emerald',
                'registration_button_text' => 'Join as Real Estate Agent',
                'is_active' => true,
                'sort_order' => 2,
                'documents' => [
                    ['key' => 'dti_sec_registration', 'label' => 'DTI / SEC Registration',           'description' => 'Certificate of business name registration (DTI) or SEC incorporation papers.',  'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 1],
                    ['key' => 'business_permit',       'label' => "Mayor's Permit / Business Permit", 'description' => 'Valid local business permit from your city or municipality.',                    'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 2],
                    ['key' => 'bir_registration',      'label' => 'BIR Certificate of Registration',  'description' => 'BIR Form 2303 — Certificate of Registration.',                                   'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 3],
                    ['key' => 'prc_broker_license',    'label' => 'PRC Real Estate Broker License',   'description' => 'Professional license from PRC for real estate brokerage.',                       'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 4],
                    ['key' => 'dhsud_license',         'label' => 'DHSUD License to Sell',            'description' => 'DHSUD license to sell for property developers.',                                 'is_required' => false, 'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 5],
                ],
            ],
        ];

        foreach ($sectors as $sectorData) {
            $documents = $sectorData['documents'];
            unset($sectorData['documents']);

            $sector = Sector::updateOrCreate(['slug' => $sectorData['slug']], $sectorData);

            foreach ($documents as $doc) {
                $sector->documents()->updateOrCreate(['key' => $doc['key']], $doc);
            }
        }
    }
}
