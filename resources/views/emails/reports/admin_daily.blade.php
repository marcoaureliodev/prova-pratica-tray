@component('mail::message')
# Relatório Geral do Dia

O valor total de todas as vendas efetuadas ontem foi de:

**R$ {{ number_format($grandTotalValue, 2, ',', '.') }}**

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent