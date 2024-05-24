<?php

namespace Database\Factories;

use App\Models\Artist;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'title' => $this->faker->sentence(3),
            'date' => $this->faker->date(),
            'artist_id' => Artist::all()->random()->id,
            'genre_id' => Genre::all()->random()->id,
            'folder_id' => uniqid(more_entropy: true),
            'description' => $this->faker->text(10)
        ];
    }
}
