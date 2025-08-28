<?php

namespace Tests\Feature;

use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SellerApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_list_all_sellers()
    {
        // Arrange: Criar 3 vendedores no banco de dados de teste
        Seller::factory(3)->create();

        // Act: Fazer a requisição para o endpoint
        $response = $this->getJson('/api/sellers');

        // Assert: Verificar a resposta
        $response->assertStatus(200);
        $response->assertJsonCount(3, 'data');
    }

    /** @test */
    public function it_can_create_a_new_seller()
    {
        // Arrange: Preparar os dados do novo vendedor
        $sellerData = [
            'name' => 'Marco Machado',
            'email' => 'marcomachado@tray.com.br',
        ];

        // Act: Enviar a requisição POST
        $response = $this->postJson('/api/sellers', $sellerData);

        // Assert: Verificar a resposta e o banco de dados
        $response->assertStatus(201)
                ->assertJsonFragment(['name' => 'Marco Machado']);

        $this->assertDatabaseHas('sellers', ['email' => 'marcomachado@tray.com.br']);
    }

    /** @test */
    public function it_validates_seller_creation_data()
    {
        // Act: Enviar uma requisição com dados inválidos (email faltando)
        $response = $this->postJson('/api/sellers', ['name' => 'Invalid Seller']);

        // Assert: Verificar se a validação falhou
        $response->assertStatus(422) // Unprocessable Entity
                ->assertJsonValidationErrors('email');
    }
}
