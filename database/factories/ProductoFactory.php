<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
        'codigo' => $this->faker->numberBetween('1000', '9999'),
        'nombre' =>  $this->faker->name,
        'descripcion' => $this->faker->text,
        'precio' => $this ->faker->randomNumber(2),
        'url_imagen' => $this->faker-> imageUrl(260, 350),
        'like' => rand(0, 10),
        'dislike' => rand(0, 10),
        ];
    }
}
