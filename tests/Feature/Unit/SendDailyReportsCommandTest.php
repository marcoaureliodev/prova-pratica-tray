<?php

namespace Tests\Unit;

use App\Mail\AdminDailyReport;
use App\Mail\SellerDailyReport;
use App\Models\Sale;
use App\Models\Seller;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class SendDailyReportsCommandTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function it_sends_daily_reports_to_sellers_with_sales_and_to_admin()
    {
        // Arrange: Configurar o cenário
        Mail::fake();

        $yesterday = now()->subDay()->toDateString();
        $adminEmail = 'admin@exemplo.com';
        config(['mail.admin_address' => $adminEmail]);

        // Vendedor 1: Com vendas ontem
        $seller1 = Seller::factory()->has(Sale::factory()->count(2)->state([
            'value' => 100, // 2 vendas de 100 = 200
            'sale_date' => $yesterday
        ]))->create();

        // Vendedor 2: Sem vendas ontem
        $seller2 = Seller::factory()->create();

        // Act: Executar o comando
        $this->artisan('reports:send-daily');

        // Assert: Verificar os e-mails
        // Verifica que um e-mail foi enfileirado para o vendedor 1
        Mail::assertQueued(SellerDailyReport::class, function ($mail) use ($seller1) {
            return $mail->hasTo($seller1->email) &&
                   $mail->salesCount === 2 &&
                   $mail->totalValue == 200;
        });

        // Verifica que NENHUM e-mail foi enviado para o vendedor 2
        Mail::assertNotQueued(SellerDailyReport::class, function ($mail) use ($seller2) {
            return $mail->hasTo($seller2->email);
        });

        // Verifica que o e-mail do admin foi enfileirado com o total correto
        Mail::assertQueued(AdminDailyReport::class, function ($mail) use ($adminEmail) {
            return $mail->hasTo($adminEmail) &&
                   $mail->grandTotalValue == 200;
        });
    }
}
