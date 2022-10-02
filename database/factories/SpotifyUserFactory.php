<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SpotifyUser>
 */
class SpotifyUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'username'=>$this->faker->name(),
            'access_token'=>Str::random(10),
            'refresh_token'=>Str::random(10),
            'expiry_time'=>$this->faker->unixTime(),
        ];
    }
}
