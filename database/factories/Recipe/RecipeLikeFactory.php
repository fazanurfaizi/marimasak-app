<?php

namespace Database\Factories\Recipe;

use App\Models\Recipe\RecipeLike;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class RecipeLikeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = RecipeLike::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $types = [
            RecipeLike::LIKE,
            RecipeLike::LOVE,
            RecipeLike::CARE,
            RecipeLike::HAHA,
            RecipeLike::WOW,
            RecipeLike::SAD,
            RecipeLike::ANGRY
        ];

        return [
            'type' => Arr::random($types),
            'recipe_id' => 5,
            'user_id' => 1
        ];
    }
}
