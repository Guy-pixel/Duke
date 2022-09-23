<?php

namespace Database\Seeders;

use App\Models\SpotifyUser;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SpotifyUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        SpotifyUser::factory(10)->create();
    }
}
