@extends('layouts/contentLayoutMaster')

@section('title')
{{ __('locale.Records') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex  justify-content-between">
            <div class="">
                {{$cashier->name.' '.__('locale.Cashier').' '.__('locale.Ledgers')}}
            </div>
            <div class="card-text d-flex flex-wrap gap-1">
                <span onclick="printTable('printable')" title="Print table">
                    <i class="text-primary fa fa-lg fa-print" ></i>
                </span>
                <span onclick="prepTableForSort()" title="prepare table for sort">
                    <i class="text-primary fa fa-lg fa-sort" ></i>
                </span>
                <div class='dropdown'>
                    <i data-bs-toggle='dropdown' class="fa fa-lg fa-filter text-primary"></i>
                    <div class='dropdown-menu dropdown-menu-end'>
                        <a class='dropdown-item' onclick="handelFilter()">
                            <i class="me-1 fa fa-refresh" ></i>
                            <span>{{__('locale.Reset')}}</span>
                        </a>
                        <a class='dropdown-item {{request('defaultCurrencyApplyed') == true ? 'active' : ''}}' onclick="handelFilter('defaultCurrencyApplyed','true')">
                            <i class="me-1 fa fa-circle-thin"></i>
                            <span>Apply Default</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body p-0 px-1" id="printable">
            <table class="table table-sm mb-1 sortable">
                <thead class="">
                    <tr id="sortable_by">
                        <th>NO</th>
                        <th>{{ __('locale.ID') }}</th>
                        <th class="skip_sort">{{ __('locale.User') }}</th>
                        <th>{{ __('locale.Start Balance') }}</th>
                        <th>{{ __('locale.End Balance') }}</th>
                        <th>{{ __('locale.Records') }}</th>
                        <th class="skip_sort">{{ __('locale.Created at') }}</th>
                        <th class="skip_sort">{{ __('locale.Options') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($cashier->ledgers as $ledger)
                        <tr>
                            <th>{{$loop->index + 1}}</th>
                            <th>{{ $ledger->id }}</th>
                            <th>{{ $ledger->admin?->full_name }}</th>
                            <th>{{ $ledger->start_balance }}</th>
                            <th>{{ $ledger->end_balance }}</th>
                            <th>{{ $ledger->records()->count() }}</th>
                            <th>{{ $ledger->created_at->diffForHumans() }}</th>
                            <th>
                                <a href="{{route('ledger.records',['ledger_id'=>$ledger->id])}}">
                                    {{__('locale.Records')}}
                                </a>
                            </th>
                        </tr>
                    @empty
                        not records found
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
@section('page-script')
<script src="{{asset('js/printout.js')}}"></script>
    <script src="{{asset('js/helpers.js')}}"></script>

@endsection
