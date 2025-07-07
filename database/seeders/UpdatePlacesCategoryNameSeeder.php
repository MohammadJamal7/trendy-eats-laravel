<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Place;
use App\Models\Category;

class UpdatePlacesCategoryNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $places = Place::whereNotNull('category_id')->get();
        
        foreach ($places as $place) {
            $category = Category::find($place->category_id);
            if ($category) {
                $place->update(['category_name' => $category->name]);
            }
        }
        
        $this->command->info('Updated category names for ' . $places->count() . ' places.');
    }
}
