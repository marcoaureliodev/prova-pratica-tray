<?php

namespace Tests\Feature;

use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SaleApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_can_create_a_sale_for_a_seller()
    {
        // Arrange
        $seller = Seller::factory()->create();
        $saleData = [
            'seller_id' => $seller->id,
            'value' => 100.00,
            'sale_date' => '2025-08-25',
        ];

        // Act
        $response = $this->postJson('/api/sales', $saleData);

        // Assert
        $response->assertStatus(201)
            ->assertJson([
                'data' => [
                    'value' => '100.00',
                    'commission' => '8.50', // 8.5% de 100.00
                ],
            ]);

        $this->assertDatabaseHas('sales', ['value' => 100.00]);
    }

    /** @test */
    public function it_can_list_all_sales()
    {
        // Arrange: Crie 2 vendedores, cada um com 2 vendas
        Seller::factory(2)
            ->has(\App\Models\Sale::factory()->count(2))
            ->create();

        // Act: Faça a requisição para o endpoint de listagem de vendas
        $response = $this->getJson('/api/sales');

        // Assert: Verifique se a resposta está correta
        $response->assertStatus(200);
        $response->assertJsonCount(4, 'data'); // Total de 4 vendas
    }
}
