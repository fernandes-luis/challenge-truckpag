<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
			"code" => $this->faker->numerify('#####'),
			"status" => "published",
			"imported_t" => $this->faker->date(),
			"url" => $this->faker->url(),
			"creator" => $this->faker->name(),
			"created_t" => $this->faker->date(),
			"last_modified_t" => $this->faker->date(),
			"product_name" => $this->faker->company(),
			"quantity" => $this->faker->randomNumber(),
			"brands" => $this->faker->company(),
			"categories" => $this->faker->word(),
			"labels" => $this->faker->randomNumber(),
			"cities" => $this->faker->city(),
			"purchase_places" => $this->faker->country(),
			"stores" => "Lidl",
			"ingredients_text" => $this->faker->text(),
			"traces" => $this->faker->text(),
			"serving_size" => $this->faker->words(),
			"serving_quantity" => $this->faker->randomNumber(),
			"nutriscore_score" => $this->faker->randomNumber(),
			"nutriscore_grade" => $this->faker->randomLetter(),
			"main_category" => $this->faker->word(),
			"image_url" => $this->faker->url()
        ];
    }
}
