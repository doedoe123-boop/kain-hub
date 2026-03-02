<?php

namespace Database\Seeders;

use App\ListingType;
use App\Models\Property;
use App\PropertyStatus;
use App\PropertyType;
use Illuminate\Database\Seeder;

/**
 * Seeds property listings for store_id = 10 (Real Estate & Property store).
 *
 * Uses PropertyFactory for the heavy lifting, then overrides `store_id` and
 * applies hand-crafted variety so the seed data reflects realistic listings.
 *
 * Depends on: StoreSeeder (or a store with id=10 already existing).
 */
class PropertyListingSeeder extends Seeder
{
    private const STORE_ID = 9;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Guard: only seed if this store has no listings yet.
        if (Property::where('store_id', self::STORE_ID)->exists()) {
            $this->command->getOutput()->writeln(
                '<comment>PropertyListingSeeder: store_id='.self::STORE_ID.' already has property listings — skipping.</comment>'
            );

            return;
        }

        // ── For-Sale listings ─────────────────────────────────────────────────
        Property::factory()->create($this->merge([
            'title' => 'Modern 3BR House & Lot in Alabang',
            'description' => 'Newly built three-bedroom home in a quiet gated village in Alabang, Muntinlupa. Features an open-plan living-dining area, covered garage for two vehicles, and a private garden. Close to international schools and Festival Supermall.',
            'property_type' => PropertyType::House,
            'listing_type' => ListingType::ForSale,
            'status' => PropertyStatus::Active,
            'price' => 15_500_000.00,
            'bedrooms' => 3,
            'bathrooms' => 2,
            'garage_spaces' => 2,
            'floor_area' => 185.00,
            'lot_area' => 240.00,
            'year_built' => 2023,
            'floors' => 2,
            'address_line' => '14 Sampaguita Street, BF Homes',
            'barangay' => 'Brgy. Almanza Uno',
            'city' => 'Muntinlupa',
            'province' => 'Metro Manila',
            'zip_code' => '1780',
            'is_featured' => true,
            'features' => ['Gated Community', 'Swimming Pool', 'CCTV', 'Parking', 'Garden', 'Near School'],
        ]));

        Property::factory()->create($this->merge([
            'title' => 'Luxury Penthouse in BGC Taguig',
            'description' => 'Stunning penthouse unit on the 38th floor of a premium BGC tower. Floor-to-ceiling windows with panoramic city views, private roof deck, and direct elevator access. Fully furnished with top-of-the-line appliances.',
            'property_type' => PropertyType::Condo,
            'listing_type' => ListingType::ForSale,
            'status' => PropertyStatus::Active,
            'price' => 58_000_000.00,
            'bedrooms' => 4,
            'bathrooms' => 4,
            'garage_spaces' => 2,
            'floor_area' => 320.00,
            'lot_area' => null,
            'year_built' => 2021,
            'floors' => 1,
            'address_line' => '8th Ave corner 35th St',
            'barangay' => 'Brgy. Fort Bonifacio',
            'city' => 'Taguig',
            'province' => 'Metro Manila',
            'zip_code' => '1635',
            'is_featured' => true,
            'features' => ['Roof Deck', 'Gym', 'Swimming Pool', 'Concierge', 'Elevator', 'CCTV', 'Parking'],
        ]));

        Property::factory()->create($this->merge([
            'title' => 'Prime Commercial Lot along SLEX Calamba',
            'description' => 'Rectangular 1,500 sqm commercial lot with direct SLEX frontage. Ideal for a service station, fast-food chain, or logistics hub. Clean title, level terrain, utilities in place.',
            'property_type' => PropertyType::Lot,
            'listing_type' => ListingType::ForSale,
            'status' => PropertyStatus::Active,
            'price' => 22_500_000.00,
            'bedrooms' => null,
            'bathrooms' => null,
            'garage_spaces' => null,
            'floor_area' => null,
            'lot_area' => 1500.00,
            'year_built' => null,
            'address_line' => 'National Highway, Brgy. Bucal',
            'barangay' => 'Brgy. Bucal',
            'city' => 'Calamba',
            'province' => 'Laguna',
            'zip_code' => '4027',
            'is_featured' => false,
            'features' => ['Corner Lot', 'Near Highway', 'Title Available'],
        ]));

        Property::factory()->create($this->merge([
            'title' => '4BR Townhouse in Pasig City',
            'description' => 'Spacious four-bedroom townhouse in a well-established compound in Pasig. Two-car garage, rooftop terrace, and a semi-finished den that can serve as a home office or 5th bedroom.',
            'property_type' => PropertyType::Townhouse,
            'listing_type' => ListingType::ForSale,
            'status' => PropertyStatus::Active,
            'price' => 12_800_000.00,
            'bedrooms' => 4,
            'bathrooms' => 3,
            'garage_spaces' => 2,
            'floor_area' => 210.00,
            'lot_area' => 108.00,
            'year_built' => 2019,
            'floors' => 3,
            'address_line' => '22 Garnet Road, Valle Verde',
            'barangay' => 'Brgy. Ugong',
            'city' => 'Pasig',
            'province' => 'Metro Manila',
            'zip_code' => '1604',
            'is_featured' => false,
            'features' => ['Rooftop Deck', 'Parking', 'Near Mall', 'Gated Community'],
        ]));

        // ── For-Rent listings ─────────────────────────────────────────────────
        Property::factory()->create($this->merge([
            'title' => 'Fully Furnished Studio Condo in Makati CBD',
            'description' => 'Ready-to-move-in studio unit in the heart of Makati. Includes all furniture, smart TV, and high-speed Wi-Fi. Building amenities: lap pool, gym, 24/7 security. Walking distance to Ayala MRT.',
            'property_type' => PropertyType::Condo,
            'listing_type' => ListingType::ForRent,
            'status' => PropertyStatus::Active,
            'price' => 28_000.00,
            'price_period' => 'per_month',
            'bedrooms' => 0,
            'bathrooms' => 1,
            'garage_spaces' => null,
            'floor_area' => 28.00,
            'lot_area' => null,
            'year_built' => 2018,
            'floors' => 1,
            'address_line' => 'Ayala Ave cor Paseo de Roxas',
            'barangay' => 'Brgy. Bel-Air',
            'city' => 'Makati',
            'province' => 'Metro Manila',
            'zip_code' => '1226',
            'is_featured' => true,
            'features' => ['Furnished', 'Swimming Pool', 'Gym', 'Elevator', 'Near MRT/LRT'],
        ]));

        Property::factory()->create($this->merge([
            'title' => '2BR Apartment for Rent in Quezon City',
            'description' => 'Bright two-bedroom apartment on the 4th floor of a low-rise building in Quezon City. Pet-friendly, with covered parking, laundry area, and a balcony overlooking the garden.',
            'property_type' => PropertyType::Apartment,
            'listing_type' => ListingType::ForRent,
            'status' => PropertyStatus::Active,
            'price' => 18_000.00,
            'price_period' => 'per_month',
            'bedrooms' => 2,
            'bathrooms' => 1,
            'garage_spaces' => 1,
            'floor_area' => 65.00,
            'lot_area' => null,
            'year_built' => 2015,
            'floors' => 1,
            'address_line' => '10 Batangas St, Project 3',
            'barangay' => 'Brgy. Paligsahan',
            'city' => 'Quezon City',
            'province' => 'Metro Manila',
            'zip_code' => '1103',
            'is_featured' => false,
            'features' => ['Pet Friendly', 'Balcony', 'Parking', 'Garden'],
        ]));

        // ── Pre-Selling listings ──────────────────────────────────────────────
        Property::factory()->create($this->merge([
            'title' => 'Pre-Selling 1BR at Azure Urban Resort Residences',
            'description' => 'Invest early in this 1-bedroom unit at the Azure Urban lifestyle district in Parañaque. Resort-inspired amenities including a lagoon pool, beach club, and spa. Estimated turnover: Q4 2027. Flexible payment terms available.',
            'property_type' => PropertyType::Condo,
            'listing_type' => ListingType::PreSelling,
            'status' => PropertyStatus::Active,
            'price' => 6_200_000.00,
            'bedrooms' => 1,
            'bathrooms' => 1,
            'garage_spaces' => null,
            'floor_area' => 42.00,
            'lot_area' => null,
            'year_built' => null,
            'address_line' => 'Bicutan, Western Bicutan',
            'barangay' => 'Brgy. Western Bicutan',
            'city' => 'Parañaque',
            'province' => 'Metro Manila',
            'zip_code' => '1711',
            'is_featured' => true,
            'features' => ['Swimming Pool', 'Gym', 'Beach Club', 'Elevator', 'CCTV'],
        ]));

        Property::factory()->create($this->merge([
            'title' => 'Pre-Selling Farm House Lot in Tagaytay',
            'description' => 'One of 30 exclusive farm lots at the Verona Hills Eco-Estates in Tagaytay. 600 sqm, panoramic Taal Lake views, cool climate year-round. Ideal for a weekend home or AirBnB investment.',
            'property_type' => PropertyType::Farm,
            'listing_type' => ListingType::PreSelling,
            'status' => PropertyStatus::Active,
            'price' => 4_800_000.00,
            'bedrooms' => null,
            'bathrooms' => null,
            'garage_spaces' => null,
            'floor_area' => null,
            'lot_area' => 600.00,
            'year_built' => null,
            'address_line' => 'Kaybagal South',
            'barangay' => 'Brgy. Kaybagal South',
            'city' => 'Tagaytay',
            'province' => 'Cavite',
            'zip_code' => '4120',
            'is_featured' => false,
            'features' => ['Corner Lot', 'Mountain View', 'Gated Community', 'Near Highway'],
        ]));

        // ── For-Lease listings ────────────────────────────────────────────────
        Property::factory()->create($this->merge([
            'title' => 'Office Space for Lease in Ortigas CBD',
            'description' => '350 sqm bare shell office space on the 12th floor of a PEZA-accredited building in Ortigas Center. Ideal for BPO, tech, or professional services. 24/7 HVAC, 100% backup power, ample parking floors.',
            'property_type' => PropertyType::Commercial,
            'listing_type' => ListingType::ForLease,
            'status' => PropertyStatus::Active,
            'price' => 850.00,
            'price_period' => 'per_month',
            'bedrooms' => null,
            'bathrooms' => 2,
            'garage_spaces' => 3,
            'floor_area' => 350.00,
            'lot_area' => null,
            'year_built' => 2014,
            'floors' => 1,
            'address_line' => 'Emerald Ave cor Sapphire Rd',
            'barangay' => 'Brgy. San Antonio',
            'city' => 'Pasig',
            'province' => 'Metro Manila',
            'zip_code' => '1605',
            'is_featured' => false,
            'features' => ['24/7 Security', 'Generator', 'Elevator', 'Parking', 'CCTV'],
        ]));

        // ── Draft listings (not yet published) ───────────────────────────────
        Property::factory()->draft()->create($this->merge([
            'title' => 'Draft: 5BR Mansion in Dasmariñas Village Makati',
            'description' => 'Exclusive listing, details pending client approval. Ultra-premium address in Dasmariñas Village. Will be published once documentation is verified.',
            'property_type' => PropertyType::House,
            'listing_type' => ListingType::ForSale,
            'price' => 120_000_000.00,
            'bedrooms' => 5,
            'bathrooms' => 6,
            'garage_spaces' => 3,
            'floor_area' => 750.00,
            'lot_area' => 1200.00,
            'city' => 'Makati',
            'province' => 'Metro Manila',
            'features' => ['Private Pool', 'Home Theater', 'Staff Quarters', 'Garden', 'CCTV'],
        ]));
    }

    /**
     * Merge store_id into every factory override array.
     *
     * @param  array<string, mixed>  $overrides
     * @return array<string, mixed>
     */
    private function merge(array $overrides): array
    {
        return array_merge(['store_id' => self::STORE_ID], $overrides);
    }
}
