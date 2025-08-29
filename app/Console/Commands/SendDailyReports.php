<?php

namespace App\Console\Commands;

use App\Mail\AdminDailyReport;
use App\Mail\SellerDailyReport;
use App\Models\Sale;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendDailyReports extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reports:send-daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = now()->subDay();
        $this->info('Gerando relatórios para vendas do dia: '.$yesterday->toDateString());

        $sales = Sale::query()
            ->with('seller')
            ->whereDate('sale_date', $yesterday)
            ->get();

        if ($sales->isEmpty()) {
            $this->info('Nenhuma venda encontrada para o dia.');

            return 0;
        }

        // Agrupa as vendas por vendedor
        $salesBySeller = $sales->groupBy('seller_id');
        $grandTotal = 0;

        foreach ($salesBySeller as $sellerId => $sellerSales) {
            $seller = $sellerSales->first()->seller;
            $salesCount = $sellerSales->count();
            $totalValue = $sellerSales->sum('value');
            $totalCommission = $totalValue * 0.085;
            $grandTotal += $totalValue;

            // Enfileira o e-mail para o vendedor
            Mail::to($seller)->queue(new SellerDailyReport($salesCount, $totalValue, $totalCommission));
            $this->info("Relatório do vendedor {$seller->name} enfileirado.");
        }

        // Enfileira o e-mail para o admin
        $adminEmail = config('mail.admin_address', 'admin@exemplo.com'); // Use um e-mail configurável
        Mail::to($adminEmail)->queue(new AdminDailyReport($grandTotal));
        $this->info('Relatório do administrador enfileirado.');

        return 0;
    }
}
