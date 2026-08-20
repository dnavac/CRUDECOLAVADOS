<?php

namespace Tests\Feature;

use App\Models\Client;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ClientAndContainerTest extends TestCase
{
    use RefreshDatabase;

    private function createClient(array $overrides = []): Client
    {
        return Client::create(array_merge([
            'name' => 'Cliente de Prueba',
            'document' => '900123456-7',
            'phone' => '3001234567',
            'email' => 'cliente@example.com',
            'address' => 'Calle 1 # 2-3',
        ], $overrides));
    }

    public function test_client_can_be_created_and_shows_container_count(): void
    {
        $clientData = [
            'name' => 'Cliente de Prueba',
            'document' => '900123456-7',
            'phone' => '3001234567',
            'email' => 'cliente@example.com',
            'address' => 'Calle 1 # 2-3',
        ];

        $response = $this->post(route('clients.store'), $clientData);

        $response->assertRedirect(route('clients.index'));
        $this->assertDatabaseHas('clients', [
            'document' => '900123456-7',
            'email' => 'cliente@example.com',
        ]);

        $client = Client::where('document', '900123456-7')->firstOrFail();
        $this->get(route('clients.show', $client))
            ->assertOk()
            ->assertSee('Total de Contenedores Asociados')
            ->assertSee('0');
    }

    public function test_client_document_must_be_unique(): void
    {
        $this->createClient();

        $response = $this->post(route('clients.store'), [
            'name' => 'Otro Cliente',
            'document' => '900123456-7',
            'phone' => '3001234567',
            'email' => 'otro@example.com',
            'address' => 'Calle 4 # 5-6',
        ]);

        $response->assertSessionHasErrors('document');
    }

    public function test_dry_container_can_be_created_with_default_status(): void
    {
        $client = $this->createClient();

        $response = $this->post(route('containers.store'), [
            'code' => 'EXFU3902145',
            'type' => 'Seco',
            'capacity' => 30,
            'client_id' => $client->id,
        ]);

        $response->assertRedirect(route('containers.index'));
        $this->assertDatabaseHas('containers', [
            'code' => 'EXFU3902145',
            'type' => 'Seco',
            'status' => 'Almacenado',
            'client_id' => $client->id,
        ]);
    }

    public function test_dry_container_cannot_be_saved_as_in_washing(): void
    {
        $client = $this->createClient();

        $response = $this->post(route('containers.store'), [
            'code' => 'EXFU3902146',
            'type' => 'Seco',
            'capacity' => 30,
            'status' => 'En lavado',
            'client_id' => $client->id,
        ]);

        $response->assertSessionHasErrors('status');
        $this->assertDatabaseMissing('containers', [
            'code' => 'EXFU3902146',
        ]);
    }

    public function test_tank_container_can_be_saved_as_in_washing(): void
    {
        $client = $this->createClient();

        $response = $this->post(route('containers.store'), [
            'code' => 'EXFU3902147',
            'type' => 'Isotanque',
            'capacity' => 25.5,
            'status' => 'En lavado',
            'client_id' => $client->id,
        ]);

        $response->assertRedirect(route('containers.index'));
        $this->assertDatabaseHas('containers', [
            'code' => 'EXFU3902147',
            'type' => 'Isotanque',
            'status' => 'En lavado',
        ]);
    }
}