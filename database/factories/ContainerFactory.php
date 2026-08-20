<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Container;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Container> */
class ContainerFactory extends Factory
{
    protected $model = Container::class;

    public function definition(): array
    {
        $type = fake()->randomElement(['Seco', 'Isotanque']);
        $statuses = $type === 'Seco'
            ? ['Almacenado', 'En reparación']
            : ['Almacenado', 'En lavado', 'En reparación'];

        return [
            'code' => fake()->unique()->bothify('EXFU#########'),
            'type' => $type,
            'capacity' => fake()->randomFloat(2, 10, 100),
            'status' => fake()->randomElement($statuses),
            'client_id' => Client::query()->inRandomOrder()->value('id'),
        ];
    }
}