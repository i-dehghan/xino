<?php

namespace Database\Factories;

use App\Models\Config;
use Illuminate\Database\Eloquent\Factories\Factory;

class ConfigFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Config::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'key' => $this->faker->randomKey,
            'value' => $this->faker->creditCardNumber,
            'type' => $this->faker->randomElement(['boolean', 'array', 'string', 'integer']),
            'updated_at' => $this->faker->dateTime,
            'created_at' => $this->faker->dateTime
        ];
    }

}
