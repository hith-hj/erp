@extends('layouts.contentLayoutMaster')

@section('title')
    {{ $client->first_name }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="card-head mb-1 row">
            <h4 class="col-10">{{ __('locale.Show') }}</h4>
            <div class="col-2">
                <button class="btn btn-sm btn-outline-danger w-100"
                    onclick="
                        if(confirm('{{ __('locale.Delete') }} ?')){
                            document.getElementById('deleteClientForm').submit();
                        }
                    ">
                    {{ __('locale.Delete') }}
                </button>
                <form id="deleteClientForm" method="Post" action="{{ route('client.delete', ['client' => $client->id]) }}">
                    @csrf @method('delete')
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h5>{{ __('locale.Details') }}</h5>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{ __('locale.Name') }} :
                            {{ "$client->first_name  $client->last_name" }}
                        </h4>
                        <div class="card-text d-flex flex-wrap gap-1">
                            <span>{{ __('locale.Email').':'.$client->email }}</span>
                            <span>{{ __('locale.Phone').':'.$client->phone }}</span>
                        </div>
                        <div class="card-text d-flex flex-wrap gap-1">
                            <span onclick="printTable('printable')" title="Print table">    
                                <i class="text-primary fa fa-print" ></i>
                            </span>
                            <span onclick="prepTableForSort()" title="prepare table for sort">
                                <i class="text-primary fa fa-sort" ></i>
                            </span>
                            <div class='dropdown'>
                                <i data-bs-toggle='dropdown' class="fa fa-filter text-primary"></i>
                                <div class='dropdown-menu dropdown-menu-end'>
                                    <a class='dropdown-item' onclick="handelFilter()">
                                        <i class="me-1 fa fa-refresh" ></i>
                                        <span>{{__('locale.Reset')}}</span>
                                    </a>
                                    <a class='dropdown-item {{request('defaultCurrencyApplyed') == true ? 'active' : ''}}' onclick="handelFilter('defaultCurrencyApplyed','true')">
                                        <i class="me-1" data-feather='circle'></i>
                                        <span>Apply Default</span>
                                    </a>
                                    @foreach ($sales->currencies as $currency)
                                        <a class='dropdown-item {{request('currency') == $currency ? 'active' : ''}}' onclick="handelFilter('currency','{{$currency}}')">
                                            <i class="me-1" data-feather='circle'></i>
                                            <span>{{__('locale.Currency')}} : {{$currency}}</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="printable">
                        @php
                            $stats = [];
                        @endphp
                        <table class="table table-sm table-bordered sortable">
                            <thead>
                                <tr id="sortable_by">
                                    <th>{{__('locale.ID')}}</th>
                                    <th class="skip_sort">{{ __('locale.Bill') }}</th>
                                    <th>{{ __('locale.Currency') }}</th>
                                    <th>{{ __('locale.Total') }}</th>
                                    <th>{{ __('locale.Payed') }}</th>
                                    <th>{{ __('locale.Remaining') }}</th>
                                    <th class="skip_sort">{{ __('locale.Note') }}</th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                @forelse ($sales as $sale)
                                    @php
                                        $currency = $sale->currency->name;
                                        if(!isset($stats[$currency])){
                                            $stats[$currency] = [
                                                'count' => 1,
                                                'total'=>$sale->total,
                                                'remaining'=>$sale->remaining,
                                            ];
                                        }else{
                                            $stats[$currency]['count'] += 1;
                                            $stats[$currency]['total'] += $sale->total;
                                            $stats[$currency]['remaining'] += $sale->remaining;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>
                                            @if(isset($sale->bill))
                                                <a href="{{ route('bill.show',$sale->bill?->id) }}">
                                                    {{ $sale->bill?->serial }}
                                                </a>
                                            @else
                                                No Bill
                                            @endif
                                        </td>
                                        <td>{{ $sale->currency->name }}</td>
                                        <td>{{ $sale->total }}</td>
                                        <td>{{ $sale->total - $sale->remaining }}</td>
                                        <td>{{ $sale->remaining }}</td>
                                        <td>
                                            @if ($sale->hasTransaction 
                                            && !$sale->currency->is_default 
                                            && request()->filled('defaultCurrencyApplyed'))
                                                "Default Currency Applyed"
                                            @endif
                                            @if (!$sale->hasTransaction)
                                                "No Transaction Found"
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            <span class="badge badge-light-info me-1">
                                                Not sales yet
                                            </span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <table class="table table-sm table-bordered mt-1">
                            <tbody class="table-hover">
                                @forelse ($stats as $key => $item)
                                    <tr class="text-primary border-primary">
                                        <th> {{ __('locale.Currency') . ' : ' . $key}} </th>
                                        <th colspan="9"> {{ __('locale.Rows count'). ' : ' .  $item['count'] }} </th>
                                        <th> {{ __('locale.Total') . ' : ' . $item['total']}} </th>
                                        <th> {{ __('locale.Payed') . ' : ' . $item['total'] - $item['remaining']}} </th>
                                        <th> {{ __('locale.Remaining') . ' : ' . $item['remaining']}} </th>
                                    </tr>
                                @empty
                                    <tr>
                                        <th> {{__('locale.Nothing found')}} </th>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection


@section('page-script')
    <script src="{{asset('js/printout.js')}}"></script>
    <script src="{{asset('js/helpers.js')}}"></script>
@endsection
