@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.Expenses statistics') }}
@endsection

@section('content')
<section id="card-content-types">
<div class="row">
    <div class="col-12">
        <h4 class=""> {{ __('locale.Select expense') }} </h4>
        <div class="card">
            <div class="card-header">                
                <form id="deleteExpenseForm" method="get"
                    action="{{ route('expense.getStatistics') }}"
                    class="row g-2 align-items-end col-12">
                    @csrf 
                    
                    <!-- Expenses Dropdown Group -->
                    <div class="col-12">
                        <label for="expenses" class="form-label font-weight-bold">
                            {{ __('locale.Expenses') }}
                        </label>
                        <select id="expenses" name="expenses[]" class="form-select form-control" multiple
                        style="appearance: base-select;">
                            @foreach($expenses as $expense)
                                <option value="{{$expense->id}}">{{$expense->name}}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- expense Input Group -->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <label class="form-label font-weight-bold">
                                    {{ __('locale.From date') }}
                                </label>
                                <input 
                                    type="date" name="from"
                                    class="form-control" placeholder="Select from date">
                            </div>
                            <div class="col-6">
                                <label class="form-label font-weight-bold">
                                    {{ __('locale.To date') }}
                                </label>
                                <input 
                                    type="date" name="to"
                                    class="form-control" placeholder="Select to date">
                            </div>
                        </div>
                    </div>
                    <div class="col-12">
                        <button class="btn btn-outline-success w-50" type="submit">
                            {{ __('locale.Search') }}
                        </button>
                        @if(isset($result))
                            <a href="{{ route('expense.statistics') }}" class="">
                                <button class="btn btn-outline-info " type="button">
                                    {{ __('locale.Reset') }}
                                </button>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 

@if(isset($result))
<div class="my-1">
@foreach($result as $expense)
    <div class="card shadow-sm mb-2 border-0 rounded-2">
        
        <!-- Header section with Title and Count -->
        <div class="card-header text-white d-flex justify-content-between align-items-center py-1 rounded-top-3">
            <h4 class="mb-0 fw-bold">
                <span class="text-secondary-emphasisx">{{ __("locale.Expense") }}:</span> {{ $expense['expense_name'] }}
            </h4>
            <span class="badge bg-secondary px-2 py-1 fs-6 rounded-pill">
                {{ __('locale.Transactions') }}
                {{ $expense['summary']['transaction_count'] }} 
            </span>
        </div>

        <div class="card-body p-1">
            
            <!-- Financial Indicators Metrics Row -->
            <div class="row g-1">
                <!-- Total Credit Card Card -->
                <div class="col-md-4">
                    <div class="card border-0 bg-success bg-opacity-10 text-success rounded-2 p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-uppercase fw-semibold small text-muted">
                                {{ __('locale.Total Credit') }} (+)
                            </div>
                            <div class="fs-2 fw-bold">
                                {{ number_format($expense['summary']['total_credit'], 2) }}
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Total Debit Card Card -->
                <div class="col-md-4">
                    <div class="card border-0 bg-danger bg-opacity-10 text-danger rounded-2 p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-uppercase fw-semibold small text-muted">
                                {{ __('locale.Total Debit') }} (-)
                            </div>
                            <div class="fs-2 fw-bold">
                                {{ number_format($expense['summary']['total_debit'], 2) }}
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Net Balance Card (Dynamically Styled) -->
                <div class="col-md-4">
                    @php 
                        $balance = $expense['summary']['net_balance'];
                        $balanceClass = $balance >= 0 ? 'bg-info bg-opacity-10 text-info' : 'bg-warning bg-opacity-10 text-warning';
                    @endphp
                    <div class="card border-0 {{ $balanceClass }} rounded-2 p-1">
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-uppercase fw-semibold small text-muted">
                                {{ __('locale.Net Balance') }}
                            </div>
                            <div class="fs-2 fw-bold">
                                {{ number_format($balance, 2) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Detailed Account Ledger Presentation Table -->
            <div class="mt-1">
                <h5 class="fw-bold mb-1 text-secondary">
                    {{ __("locale.Ledgers") }}
                </h5>
                
                @if(empty($expense['ledger_entries']))
                    <div class="alert alert-light border border-dashed text-center py-2 rounded-2 text-muted">
                        {{ __('locale.Nothing found') }}
                    </div>
                @else
                    <div class="table-responsive rounded-2 border">
                        <table class="table table-hover table-striped mb-0 align-middle">
                            <thead class="table-light text-uppercase fs-7 text-muted border-bottom">
                                <tr>
                                    <th class="ps-3" style="width: 80px;">ID</th>
                                    <th style="width: 180px;">{{ __('locale.Date') }}</th>
                                    <th style="width: 120px;">{{ __('locale.Type') }}</th>
                                    <th class="text-end" style="width: 150px;">{{ __('locale.Amount') }}</th>
                                    <th class="text-end" style="width: 150px;">{{ __('locale.Currency') }}</th>
                                    <th class="ps-4">{{ __('locale.Note') }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($expense['ledger_entries'] as $entry)
                                    <tr>
                                        <td class="text-muted ps-3">#{{ $entry['id'] }}</td>
                                        <td>
                                            <small class="text-dark fw-medium">
                                                {{ \Carbon\Carbon::parse($entry['date'])->format('d M, Y') }}
                                            </small>
                                            <div class="text-muted small fs-7" style="font-size: 0.75rem;">
                                                {{ \Carbon\Carbon::parse($entry['date'])->format('g:i A') }}
                                            </div>
                                        </td>
                                        <td>
                                            @if($entry['type'] === 'credit')
                                                <span class="badge bg-success-subtle text-success border border-success-subtle px-2 rounded">
                                                    {{ __('locale.Credit') }}
                                                </span>
                                            @else
                                                <span class="badge bg-danger-subtle text-danger border border-danger-subtle px-2 rounded">
                                                    {{ __('locale.Debit') }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="text-end fw-bold {{ $entry['type'] === 'credit' ? 'text-success' : 'text-danger' }}">
                                            {{ $entry['type'] === 'credit' ? '+' : '-' }}{{ number_format($entry['amount'], 2) }}
                                        </td>
                                        <td class="text-muted ps-4">
                                            {{ $entry['currency'] ?: '—' }}
                                        </td>
                                        <td class="text-muted ps-4">
                                            {{ $entry['note'] ?: '—' }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            <!-- Associated System Accounts Component Section -->
            @if(!empty($expense['accounts']))
                <div class="mt-1">
                    <h6 class="fw-bold text-muted text-uppercase small">
                        {{ __('locale.Accounts') }}
                    </h6>
                    {{-- <div class="d-flex flex-wrap gap-2"> --}}
                    <div class="row gap-1 p-1">
                        @foreach($expense['accounts'] as $account)
                            <div class="col-4 p-1 fs-7 border border-primary rounded-2 fw-normal">
                                <div>
                                    {{ __('locale.Type') }}:
                                    <strong class="text-primary">{{ $account['type'] }}</strong> 
                                </div>                                
                                <div>
                                    @php 
                                        $routeName = strToLower(class_basename($account['accountable_type'])).'.show';
                                        $route = Route::has($routeName) ? 
                                            route($routeName,$account['accountable_id']) :
                                            '#';
                                    @endphp
                                    {{ __('locale.Source') }}:
                                    <a href="{{ $route }}" target="_blank" rel="noopener noreferrer">
                                        <code class="text-dark">
                                            {{ class_basename($account['accountable_type']) }} (ID: {{ $account['accountable_id'] }})
                                        </code>
                                    </a>
                                </div>
                                <div>
                                    {{ __('locale.Amount') }}:
                                    <code>{{ $account['amount'] }}</code>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

        </div>
    </div>
@endforeach
</div>
@endif

</section>
@endsection