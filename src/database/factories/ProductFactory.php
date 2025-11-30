<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Storage;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {

        $images = ['kiwi.png', 'strawberry.png', 'orange.png', 'watermelon.png', 'peach.png', 'muscat.png', 'pineapple.png', 'grapes.png', 'banana.png', 'melon.png'];

        return [
            'name' => $this->faker->realText(20),
            'price' => $this->faker->numberBetween(0, 10000),
            'description' => $this->faker->realText(120),
            'image_path' => 'images/' . $this->faker->randomElement($images),
        ];
    }
}
