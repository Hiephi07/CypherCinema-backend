<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Classify;
use App\Models\Director;
use App\Models\Format;
use App\Models\Language;
use App\Models\Movie;
use App\Models\Performer;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class MovieSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        Category::truncate();
        Classify::truncate();
        Director::truncate();
        Format::truncate();
        Language::truncate();
        Performer::truncate();
        Movie::truncate();

        Classify::factory(5)->create();
        Director::factory(10)->create();
        Performer::factory(20)->create();

        foreach (['Action', 'Animation', 'Fantasy', 'Healing', 'Crime'] as $key => $value) {
            Category::create([
                'name' => $value,
            ]);
        }

        foreach (['2D', '3D', '4D'] as $key => $value) {
            Format::create([
                'name' => $value,
            ]);
        }

        foreach (['Phụ Đề', 'Lồng Tiếng'] as $key => $value) {
            Language::create([
                'name' => $value,
            ]);
        }

        for ($i = 0; $i < 20; $i++) { 
            Movie::create([
                'name' => fake()->name(),
                'price' => fake()->numberBetween(100000, 1000000),
                'image' => 'https://bhdstar.vn/wp-content/uploads/2024/06/referenceSchemeHeadOfficeallowPlaceHoldertrueheight700ldapp-1.png',
                'content' => fake()->sentence(50),
                'trailer' => fake()->url(),
                'premiere' => Carbon::now()->subDays(random_int(0, 30))->addDays(random_int(0, 30))->format('Y-m-d'),
                'time' => fake()->numberBetween(30, 200),
                'category_id' => random_int(1, 5),  
                'classify_id' => random_int(1, 5),  
                'format_id' => random_int(1, 3),  
                'director_id' => random_int(1, 10),  
                'language_id' => random_int(1, 2),  
                'user_id' => random_int(1, 5),  

            ]);
        }

        for ($i = 1; $i <= 20 ; $i++) { 
            DB::table('performer_movie')->insert([
                [
                    'movie_id' => $i, 
                    'performer_id' => random_int(1, 10)
                ],
                [
                    'movie_id' => $i, 
                    'performer_id' => random_int(11, 20)
                ],
            ]);
        }


    }
}
