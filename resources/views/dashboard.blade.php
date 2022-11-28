<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">Dashboard</h2>
        </div>
    </x-slot>

    <div class="row" data-masonry='{"percentPosition": true }'>
        @isset($widgets['transactions'])
        <div class="col-sm-12 col-lg-6 mb-3">
            <x-widget.transactions :wallet="$wallet" :transactions="$widgets['transactions']" />
        </div>
        @endisset
        @isset($widgets['cash_flow'])
        <div class="col-sm-6 col-lg-4 mb-3">
            <x-widget.cash_flow :cashFlows="$widgets['cash_flow']" />
        </div>
        @endisset
        @isset($widgets['expense-category-donut'])
        <div class="col-sm-6 col-lg-4 mb-3">
            <x-widget.expense-category-donut :dataCategories="json_encode($widgets['expense-category-donut'])" />
        </div>
        @endisset
    </div>
</x-app-layout>