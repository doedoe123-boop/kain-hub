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
                'name'        => 'Food & Beverage',
                'slug'        => 'food_and_beverage',
                'description' => 'Restaurants, catering, food production, grocery, and beverage distribution.',
                'icon'        => 'heroicon-o-cake',
                'color'       => 'orange',
                'is_active'   => true,
                'sort_order'  => 1,
                'documents'   => [
                    ['key' => 'dti_sec_registration', 'label' => 'DTI / SEC Registration',           'description' => 'Certificate of business name registration (DTI) or SEC incorporation papers.',        'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 1],
                    ['key' => 'business_permit',       'label' => "Mayor's Permit / Business Permit", 'description' => 'Valid local business permit from your city or municipality.',                        'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 2],
                    ['key' => 'bir_registration',      'label' => 'BIR Certificate of Registration',  'description' => 'BIR Form 2303 — Certificate of Registration.',                                       'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 3],
                    ['key' => 'fda_lto',               'label' => 'FDA License to Operate (LTO)',     'description' => 'Food and Drug Administration license for food manufacturing or distribution.',       'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 4],
                    ['key' => 'sanitary_permit',       'label' => 'Sanitary Permit',                  'description' => 'Sanitary permit from the local health office.',                                      'is_required' => true,  'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 5],
                    ['key' => 'halal_certification',   'label' => 'Halal Certification',              'description' => 'Halal certification if applicable to your products.',                                'is_required' => false, 'mimes' => 'pdf,jpg,jpeg,png', 'sort_order' => 6],
                ],
            ],
            [
                'name'        => 'Real Estate & Property',
                'slug'        => 'real_estate',
                'description' => 'Property listings, real estate services, and property management.',
                'icon'        => 'heroicon-o-home-modern',
                'color'       => 'emerald',
                'is_active'   => true,
                'sort_order'  => 2,
                'documents'   => [
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
