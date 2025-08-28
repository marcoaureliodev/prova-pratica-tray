@component('mail::message')
# Relatório de Vendas do Dia

Olá,

Este é o resumo de suas vendas de ontem:

- **Quantidade de Vendas:** {{ $salesCount }}
- **Valor Total das Vendas:** R$ {{ number_format($totalValue, 2, ',', '.') }}
- **Sua Comissão Total:** R$ {{ number_format($totalCommission, 2, ',', '.') }}

Obrigado,<br>
{{ config('app.name') }}
@endcomponent