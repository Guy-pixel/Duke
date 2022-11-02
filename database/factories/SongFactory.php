<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Song>
 */
class SongFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->word(3),
            'album'=>$this->faker->word(),
            'artist'=>$this->faker->name(),
            'requester'=>$this->faker->name(),
            'release_date'=>$this->faker->date(),
            'uri'=>$this->faker->url(),
            'votes'=>$this->faker->numberBetween(1, 50)

        ];
    }
}
