<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Country;

class PlaceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countryIds = Country::pluck('id')->toArray();

        if (empty($countryIds)) {
            $this->command->info('No countries found. Please run CountrySeeder first.');
            return;
        }

        DB::table('places')->insert([
            [
                'name' => 'Eiffel Tower',
                'description' => 'Iconic landmark in Paris.',
                'address' => 'Champ de Mars, 5 Avenue Anatole France, 75007 Paris, France',
                'phone' => '+33892701239',
                'website' => 'https://www.toureiffel.paris',
                'image' => 'eiffel_tower.jpg',
                'latitude' => 48.8584,
                'longitude' => 2.2945,
                'cuisine_type' => null,
                'rating' => 4.8,
                'price_range' => null,
                'opening_hours' => json_encode(array('Mon-Sun' => '9:00 AM - 10:45 PM')),
                'is_active' => true,
                'country_id' => $countryIds[array_rand($countryIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Louvre Museum',
                'description' => 'World\'s largest art museum, home to the Mona Lisa.',
                'address' => 'Rue de Rivoli, 75001 Paris, France',
                'phone' => '+33140205050',
                'website' => 'https://www.louvre.fr',
                'image' => 'louvre_museum.jpg',
                'latitude' => 48.8606,
                'longitude' => 2.3376,
                'cuisine_type' => null,
                'rating' => 4.7,
                'price_range' => null,
                'opening_hours' => json_encode(array('Mon,Wed-Sun' => '9:00 AM - 6:00 PM')),
                'is_active' => true,
                'country_id' => $countryIds[array_rand($countryIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Times Square',
                'description' => 'A major commercial intersection, tourist destination, entertainment center, and neighborhood in the Midtown Manhattan section of New York City.',
                'address' => 'Manhattan, New York City, NY 10036, USA',
                'phone' => null,
                'website' => null,
                'image' => 'times_square.jpg',
                'latitude' => 40.7580,
                'longitude' => -73.9855,
                'cuisine_type' => null,
                'rating' => 4.6,
                'price_range' => null,
                'opening_hours' => null,
                'is_active' => true,
                'country_id' => $countryIds[array_rand($countryIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
             [
                'name' => 'Central Park',
                'description' => 'An urban park in New York City, New York.',
                'address' => 'New York, NY, USA',
                'phone' => null,
                'website' => null,
                'image' => 'central_park.jpg',
                'latitude' => 40.7812,
                'longitude' => -73.9665,
                'cuisine_type' => null,
                'rating' => 4.7,
                'price_range' => null,
                'opening_hours' => null,
                'is_active' => true,
                'country_id' => $countryIds[array_rand($countryIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Tokyo Skytree',
                'description' => 'A broadcasting and observation tower in Sumida, Tokyo.',
                'address' => '1 Chome-1-2 Oshiage, Sumida City, Tokyo 131-0045, Japan',
                'phone' => '+81570550634',
                'website' => 'https://www.tokyo-skytree.jp',
                'image' => 'tokyo_skytree.jpg',
                'latitude' => 35.7100,
                'longitude' => 139.8107,
                'cuisine_type' => null,
                'rating' => 4.5,
                'price_range' => null,
                'opening_hours' => json_encode(array('Mon-Sun' => '10:00 AM - 9:00 PM')),
                'is_active' => true,
                'country_id' => $countryIds[array_rand($countryIds)],
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
