<?php

namespace Database\Factories\Recipe;

use App\Models\Recipe\RecipeComment;
use Illuminate\Database\Eloquent\Factories\Factory;

class RecipeCommentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RecipeComment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'body' => $this->faker->text,
            'recipe_id' => 5,
            'user_id' => 1
        ];
    }
}
