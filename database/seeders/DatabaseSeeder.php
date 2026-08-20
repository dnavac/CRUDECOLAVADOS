<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Container;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        //Crear 10 clientes y 30 contenedores asociados a esos clientes
        $clients = Client::factory()->count(10)->create();

        Container::factory()
            ->count(30)
            ->state(fn () => ['client_id' => $clients->random()->id])
            ->create();
    }
}
