@extends('layouts/contentLayoutMaster')

@section('title')
{{ __('locale.Ledger') }}
@endsection
@section('content')
    <div class="card">
        <div class="card-header d-flex  justify-content-between">
            <div class="">
                {{__('locale.Ledger').': '. $ledger->created_at->format('Y-m-d')}}
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
            <table class="table table-sm table-bordered my-2">
                <thead>
                    <tr>
                        <th>{{__('locale.Records')}}</th>
                        <th>{{__('locale.Start balance')}}</th>
                        <th>{{__('locale.End balance')}}</th>
                        <th>{{__('locale.Balance difference')}}</th>
                    </tr>
                </thead>
                <tbody class="table-hover">
                    <tr>
                        <th>{{$ledger->records->count()}}</th>
                        <th>{{ $ledger->start_balance }}</th>
                        <th>{{$ledger->end_balance}}</th>
                        <th>{{$ledger->end_balance - $ledger->start_balance}}</th>
                    </tr>
                </tbody>
            </table>
            {{-- <table class="table table-sm table-bordered sortable">
                <thead class="">
                    <tr id="sortable_by">
                        <th>NO</th>
                        <th>{{ __('locale.ID') }}</th>
                        <th>{{ __('locale.Type') }}</th>
                        <th>{{ __('locale.Account') }}</th>
                        <th class="skip_sort">{{ __('locale.Currency') }}</th>
                        <th>{{ __('locale.Quantity') }}</th>
                        <th class="skip_sort">{{ __('locale.Note') }}</th>
                        <th>{{ __('locale.Created at')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $stats = [];
                    @endphp
                    @forelse($ledger->records as $record)
                        @php
                            $currency = $record->currency->name;
                            $total = $record->quantity;
                            if(!isset($stats[$currency])){
                                $stats[$currency] = [
                                    'count' => 1,
                                    'total'=>$total,
                                ];
                            }else{
                                $stats[$currency]['count'] += 1;
                                $stats[$currency]['total'] += $total;
                            }
                        @endphp
                        <tr>
                            <th>{{$loop->index + 1}}</th>
                            <th>{{ $record->id }}</th>
                            <th>{{ $record->record_type }}</th>
                            <th>{{ $record->account_type }}</th>
                            <th>{{ $record->currency?->name }}</th>
                            <th>{{ $record->quantity }}</th>
                            <th>
                                {{ $record->note }}
                                @if(!$record->currency?->is_default)
                                    <small> - defaulted</small>
                                @endif
                            </th>
                            <th>{{ $record->created_at->diffForHumans() }}</th>
                        </tr>
                    @empty
                        <tr>
                            <th>{{__('locale.Nothing found')}}</th>
                        </tr>
                    @endforelse
                </tbody>
            </table> --}}
            <table class="table table-sm table-bordered sortable">
                <thead class="">
                    <tr id="sortable_by">
                        <th>NO</th>
                        <th>{{ __('locale.ID') }}</th>
                        <th>{{ __('locale.Type') }}</th>
                        <th>{{ __('locale.Account') }}</th>
                        <th>{{ __('locale.Currency') }}</th>
                        <th>{{ __('locale.Quantity') }}</th>
                        <th>{{ __('locale.Note') }}</th>
                        <th>{{ __('locale.Created at')}}</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $stats = [];
                    @endphp
                    @forelse($ledger->records as $record)
                        @php
                            $currency = $record->currency->name;
                            $total = $record->quantity;
                            if(!isset($stats[$currency])){
                                $stats[$currency] = [
                                    'count' => 1,
                                    'total'=>$total,
                                ];
                            }else{
                                $stats[$currency]['count'] += 1;
                                $stats[$currency]['total'] += $total;
                            }
                        @endphp
                        <tr>
                            <th>{{$loop->index + 1}}</th>
                            <th>{{ $record->id }}</th>
                            <th>{{ $record->record_type }}</th>
                            <th>
                                @php
                                    $class = class_basename($record->account_type);
                                    $route = strtolower($class);
                                @endphp
                                <a href="{{route($route.'.show',[$route=>$record->account_id])}}"
                                    target="__blanck"
                                    >
                                    {{$class}}
                                </a>
                            </th>
                            <th>{{ $record->currency?->name }}</th>
                            <th>{{ $record->quantity }}</th>
                            <th>{{ $record->note }}</th>
                            <th>{{ $record->created_at->diffForHumans() }}</th>
                        </tr>
                    @empty
                        <tr>
                            <th>{{__('locale.Nothing found')}}</th>
                        </tr>
                    @endforelse
                </tbody>
            </table>
            <table class="table table-sm table-bordered my-2">
                <thead>
                    <tr>
                        <th> {{ __('locale.Currency') }} </th>
                        <th> {{ __('locale.Rows count')}} </th>
                        <th> {{ __('locale.Total') }} </th>
                    </tr>
                </thead>
                <tbody class="table-hover">
                    @forelse ($stats as $key => $item)
                        <tr>
                            <th> {{ $key}} </th>
                            <th> {{ $item['count'] }} </th>
                            <th> {{ $item['total']}} </th>
                        </tr>
                    @empty
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
