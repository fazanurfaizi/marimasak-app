<?php

namespace Database\Factories\Recipe;

use App\Models\Recipe\Recipe;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Recipe::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'description' => $this->faker->text,
            'materials' => $this->faker->text,
            'methods' => $this->faker->text,
            'user_id' => 1
        ];
    }
}
