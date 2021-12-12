<?php

namespace Database\Factories;

use App\Models\Stream;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class StreamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Stream::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'started_at' => now(),
            'user_id' => User::factory(),
            'ended_at' => null,
            'title' => $this->faker->sentences(1),
            'description' => $this->faker->sentences(3),
        ];
    }
}
