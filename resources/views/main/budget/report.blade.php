@extends('layouts/contentLayoutMaster')

@section('title'){{__('locale.Budget')}}@endsection
@section('page-style')
	<style>
        .progress-bar-credit { background-color: #198754; }
        .progress-bar-debit { background-color: #dc3545; }
    </style>
@endsection
@section('content')
<div class="row" >
<div class="container" x-data="{ 
    clients: {{ $reportData['credit']['clients'] }},
    materials: {{ $reportData['credit']['materials'] }},
    cashiers: {{ $reportData['credit']['cashiers'] }},
    vendors: {{ $reportData['debit']['vendors'] }},
    capital: {{ $reportData['debit']['capital'] }},
    get totalCredit() { return this.clients + this.materials + this.cashiers },
    get totalDebit() { return this.vendors + this.capital },
    get netBalance() { return this.totalCredit - this.totalDebit }
}">
    <!-- Header & Summary Status -->
    <div class="row align-items-center">
        <div class="col-md-5">
            <div class="d-flex justify-content-center align-items-center gap-2">
                <h1 class="h2 text-dark">{{ __('locale.Budget report') }}</h1>
                <p class="text-muted mb-0">
                    {{ __('locale.Created at') }}: {{ $reportData['summary']['generated_at'] }}
                </p>
            </div>
            <div class="d-flex gap-2">
                <p class="text-muted mb-0">
                    {{ __('locale.From') }}: {{ $reportData['summary']['start_date'] }}
                </p>
                <p class="text-muted mb-0">
                    {{ __('locale.To date') }}: {{ $reportData['summary']['until_date'] }}
                </p>
            </div>
        </div>
        <div class="col-md-5 text-md-end">
            <template x-if="netBalance >= 0">
                <span class="badge bg-success fs-4 p-1 shadow-sm rounded-lg">
                    {{ __('locale.Profit') }}: +<span x-text="netBalance.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                </span>
            </template>
            <template x-if="netBalance < 0">
                <span class="badge bg-danger fs-4 p-1 shadow-sm rounded-lg">
                    {{ __('locale.Loss') }}: <span x-text="netBalance.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></span>
                </span>
            </template>
        </div>
        <div class="col-md-2">
            <a href="{{ route('budget.deleteLast') }}">
                <button class="btn btn-outline-danger w-100">
                    {{ __('locale.Delete') }}
                </button>
            </a>
        </div>
    </div>

    <!-- Metric Cards Grid -->
    <div class="row g-2">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm ">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small font-weight-bold">
                        {{ __('locale.Total Credit') }}
                    </h6>
                    <h3 class="text-success mb-0 font-weight-bold" 
                    x-text="totalCredit.toLocaleString(undefined, {minimumFractionDigits: 2})"></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm ">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small font-weight-bold">
                        {{ __('locale.Total Debit') }}
                    </h6>
                    <h3 class="text-danger mb-0 font-weight-bold" x-text="totalDebit.toLocaleString(undefined, {minimumFractionDigits: 2})"></h3>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm ">
                <div class="card-body">
                    <h6 class="text-muted text-uppercase small font-weight-bold">
                        {{ __('locale.Net Balance') }}
                    </h6>
                    <h3 class="mb-0 font-weight-bold" :class="netBalance >= 0 ? 'text-success' : 'text-danger'" x-text="netBalance.toLocaleString(undefined, {minimumFractionDigits: 2})"></h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Comparative Columns -->
    <div class="row g-2">
        <!-- Credit Side Breakdown -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 py-1 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-success fw-bold">{{ __('locale.Credit') }}</h5>
                    <span  class="badge bg-success-subtle text-success 
                    border border-success-subtle rounded-lg px-3 fw-medium">
                        {{ __('locale.Inflows') }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('locale.Type') }}</th>
                                    <th class="text-end">{{ __('locale.Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ __('locale.Clients') }}</div>
                                        <div class="text-muted small">Sales & Ledgers</div>
                                    </td>
                                    <td class="text-end fw-bold text-secondary" x-text="clients.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ __('locale.Materials') }}</div>
                                        <div class="text-muted small">Inventory Stock Value</div>
                                    </td>
                                    <td class="text-end fw-bold text-secondary" x-text="materials.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ __('locale.Cashiers') }}</div>
                                        <div class="text-muted small">Register Totals</div>
                                    </td>
                                    <td class="text-end fw-bold text-secondary" x-text="cashiers.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></td>
                                </tr>
                                <tr class="table-group-divider fw-bold">
                                    <td class="text-success">{{ __('locale.Total') }}</td>
                                    <td class="text-end text-success fs-5" x-text="totalCredit.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Debit Side Breakdown -->
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header border-0 py-1 d-flex justify-content-between align-items-center">
                    <h5 class="mb-0 text-danger fw-bold">{{ __('locale.Debit') }}</h5>
                    <span class="badge bg-danger-subtle text-danger 
                        border border-danger-subtle rounded-lg px-3 fw-medium">
                        {{ __('locale.Outflows') }}
                    </span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>{{ __('locale.Type') }}</th>
                                    <th class="text-end">{{ __('locale.Amount') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ __('locale.Vendors') }}</div>
                                        <div class="text-muted small">Purchases & Ledgers Obligations</div>
                                    </td>
                                    <td class="text-end fw-bold text-secondary" x-text="vendors.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></td>
                                </tr>
                                <tr>
                                    <td>
                                        <div class="fw-semibold text-dark">{{ __('locale.Capital') }}</div>
                                        <div class="text-muted small">Assigned Base Capital</div>
                                    </td>
                                    <td class="text-end fw-bold text-secondary" x-text="capital.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></td>
                                </tr>
                                <!-- Visual structural balancing row (Matches height of 3 rows on Credit side) -->
                                <tr style="visibility: hidden;">
                                    <td><div style="height: 24px;"></div></td>
                                    <td></td>
                                </tr>
                                <tr class="table-group-divider fw-bold">
                                    <td class="text-danger">{{ __('locale.Total') }}</td>
                                    <td class="text-end text-danger fs-5" x-text="totalDebit.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})"></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection