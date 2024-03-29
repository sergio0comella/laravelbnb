<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     * @throws \Exception
     */
    public function run()
    {
        Bookable::all()->each(function (Bookable $bookable) {
            $reviews = Review::factory()->count(random_int(5, 30))->make();
            $bookable->reviews()->saveMany($reviews);
        });
    }
}
