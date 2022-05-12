<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Movie;
use App\Models\User;
use App\Models\Rating;
use Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker\Factory::create();

        DB::table('users')->truncate();
        DB::table('movies')->truncate();
        DB::table('ratings')->truncate();

        $users = collect();

        $users_count = $faker->numberBetween(5, 10);

        for ($i = 1; $i <= $users_count; $i++) {
            $users->add(
                User::factory()->create([
                    'name' => 'user'.$i,
                    'email' => 'user'.$i.'@szerveroldali.hu',
                ])
            );
        }

        $movies = Movie::factory($faker->numberBetween(20, 30))->create();
        $ratings = Rating::factory($faker->numberBetween(20, 30))->create();

        $ratings->each(function ($rating) use (&$users, &$movies) {
            if ($users->isNotEmpty()) {
                $rating->user()->associate($users->random());
                $rating->movie()->associate($movies->random());
                $rating->save();
            }
        });

        $users->add(User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@szerveroldali.hu',
            'is_admin' => true
        ]));
    }
}
