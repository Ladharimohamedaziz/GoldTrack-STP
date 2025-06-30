<x-filament-panels::page>
    {{ \App\Helpers\CurrencyHelper::convert($expense->amount) }} {{ \App\Helpers\CurrencyHelper::symbol() }}
</x-filament-panels::page>