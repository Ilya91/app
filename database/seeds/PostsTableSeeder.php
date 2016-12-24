<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        for($i = 0; $i < 50; $i++){
            DB::table('posts')->insert([
                'user_id' => $faker->numberBetween($min = 1, $max = 20),
                'category_id' => $faker->numberBetween($min = 1, $max = 20),
                'photo_id' => $faker->numberBetween($min = 1, $max = 20),
                'title' => $faker->sentence($nbWords = 6, $variableNbWords = true),
                'body' => $faker->text($maxNbChars = 300),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
