<x-app-layout>
    <x-slot name="header">
        <div class="col">
            <h2 class="page-title">Dashboard</h2>
        </div>
    </x-slot>

    <div class="row row-cards">
        <div class="col-sm-5">
            <div class="card">
                <div class="card-body">
                    <div class="d-flex align-items-center mb-1">
                        <div class="subheader">Cash Flow</div>
                    </div>
                    <div class="mb-2">
                        <div class="row align-items-center">
                            <div class="col-auto">
                                @if($cashFlows['status'] == "+")
                                <span class="bg-green-lt avatar">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/arrow-up -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="12" y1="5" x2="12" y2="19"></line><line x1="18" y1="11" x2="12" y2="5"></line><line x1="6" y1="11" x2="12" y2="5"></line></svg>
                                </span>
                                @elseif ($cashFlows['status'] == "-")
                                <span class="bg-red-lt avatar">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/arrow-down -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><line x1="12" y1="5" x2="12" y2="19"></line><line x1="18" y1="13" x2="12" y2="19"></line><line x1="6" y1="13" x2="12" y2="19"></line></svg>
                                </span>
                                @else
                                <span class="bg-secondary-lt avatar">
                                    <!-- Download SVG icon from http://tabler-icons.io/i/equal -->
                                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-equal" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"></path><path d="M5 10h14"></path><path d="M5 14h14"></path></svg>
                                </span>
                                @endif
                            </div>
                            <div class="col">
                                <div class="font-weight-medium">
                                    {{ Helper::numberFormatNoZeroes(abs($cashFlows['inout']['in'] - $cashFlows['inout']['out'])) }}
                                    <span class="float-right font-weight-medium text-{{ $cashFlows['status'] == "+" ? "success" : ($cashFlows['status'] == "-" ? "danger" : "secondary") }}">
                                        @if ($cashFlows['status'])
                                        {{ $cashFlows['status'] }}{{ max($cashFlows['inout']) != 0 ? Helper::numberFormatNoZeroes((max($cashFlows['inout'])-min($cashFlows['inout']))/max($cashFlows['inout'])*100) : 100 }}%
                                        @endif
                                    </span>
                                </div>
                                <div class="text-muted">Cash flow current month</div>
                            </div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex mb-2">
                            <div>Income</div>
                            <div class="ms-auto">
                                <span class="text-green d-inline-flex align-items-center lh-1">
                                    + {{ Helper::numberFormatNoZeroes($cashFlows['inout']['in']) }}
                                </span>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-success" style="width: {{ $cashFlows['inout']['in'] > 0 ? $cashFlows['inout']['in']/max($cashFlows['inout'])*100 : 0 }}%" role="progressbar" aria-valuenow="{{ $cashFlows['inout']['in'] }}" aria-valuemin="0" aria-valuemax="{{ max($cashFlows['inout']) }}">
                            </div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex mb-2">
                            <div>Expense</div>
                            <div class="ms-auto">
                                <span class="text-danger d-inline-flex align-items-center lh-1">
                                    - {{ Helper::numberFormatNoZeroes($cashFlows['inout']['out']) }}
                                </span>
                            </div>
                        </div>
                        <div class="progress progress-sm">
                            <div class="progress-bar bg-danger" style="width: {{ $cashFlows['inout']['out'] > 0 ? $cashFlows['inout']['out']/max($cashFlows['inout'])*100 : 0 }}%" role="progressbar" aria-valuenow="{{ $cashFlows['inout']['out'] }}" aria-valuemin="0" aria-valuemax="{{ max($cashFlows['inout']) }}">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-7">
            <div class="card">
                <div class="card-header border-0">
                    @if($wallet)
                    <div class="card-title">
                        <a href="{{ route('wallets.detail', $wallet->id) }}" class="text-reset">{{ $wallet->name }}</a>
                        <h3 class="mb-0">{{ $wallet->balance_format }}</h3>
                    </div>
                    <div class="card-actions">
                        <a href="{{ route('transactions.create', $wallet->id) }}" class="btn btn-primary">
                            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="icon me-0" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><line x1="12" y1="5" x2="12" y2="19" /><line x1="5" y1="12" x2="19" y2="12" /></svg>
                        </a>
                    </div>
                    @else
                    <div class="card-title">
                        <div>No Main Wallet</div>
                        <a href="{{ route('wallets.create') }}">Create new wallet</a>
                    </div>
                    @endif
                </div>
                @if($wallet)
                <div class="card-body pt-0">
                    <x-list-transactions :wallet="$wallet" :transactions="$transactions" />
                    @if (count($transactions) == 15)
                    <a href="{{ route('wallets.detail', $wallet->id) }}" class="d-block text-center">View More</a>
                    @endif
                </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>