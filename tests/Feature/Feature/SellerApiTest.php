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
}
