<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
            'access_token'=>$this->faker->password(),
            'refresh_token'=>$this->faker->password(),
            'expiry_time'=>$this->faker->unixTime(),
        ];
    }
}
