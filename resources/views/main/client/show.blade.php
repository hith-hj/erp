@extends('layouts.contentLayoutMaster')

@section('title')
    {{ $client->full_name }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="col-10">{{ __('locale.Client') .' : '."$client->full_name" }}</h4>
                            <div class="col-2">
                                <button class="btn btn-outline-danger btn-sm"
                                    onclick="
                                        if(confirm('{{ __('locale.Delete') }} ?')){
                                            document.getElementById('deleteClientForm').submit();
                                        }
                                    ">
                                    <i class="fa fa-trash me-1"></i>
                                    {{ __('locale.Delete') }}
                                </button>
                                <form id="deleteClientForm" method="Post" action="{{ route('client.delete', ['client' => $client->id]) }}">
                                    @csrf @method('delete')
                                </form>
                            </div>
                        </div>
                        <div class="card-text">
                            {{ __('locale.Email').': '.$client->email }}
                        </div>
                        <div class="card-text">
                            {{ __('locale.Phone').': '.$client->phone }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-header justify-content-between">
                        <div class="">
                            {{__('locale.Stats')}}
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
                                    @foreach ($sales->currencies as $currency)
                                        <a class='dropdown-item {{request('currency') == $currency ? 'active' : ''}}' onclick="handelFilter('currency','{{$currency}}')">
                                            <i class="me-1 fa fa-circle-thin"></i>
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
                        <div class="mt-1">
                            {{__('locale.Sales')}}
                        </div>
                        <table class="table table-sm table-bordered sortable">
                            <thead>
                                <tr id="sortable_by">
                                    <th>{{ __('locale.ID')}}</th>
                                    <th class="skip_sort">{{ __('locale.Bill') }}</th>
                                    <th>{{ __('locale.Currency') }}</th>
                                    <th>{{ __('locale.Total') }}</th>
                                    <th>{{ __('locale.Payed') }}</th>
                                    <th>{{ __('locale.Remaining') }}</th>
                                    <th>{{ __('locale.Created at') }}</th>

                                    <th class="skip_sort">{{ __('locale.Note') }}</th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                @forelse ($sales as $sale)
                                    @php
                                        $currency = $sale->currency->name;
                                        
                                        $total = $sale->total;
                                        $remaining = $sale->remaining;
                                        if(!isset($stats[$currency])){
                                            $stats[$currency] = [
                                                'count' => 1,
                                                'total'=>$total,
                                                'remaining'=>$remaining,
                                            ];
                                        }else{
                                            $stats[$currency]['count'] += 1;
                                            $stats[$currency]['total'] += $total;
                                            $stats[$currency]['remaining'] += $remaining;
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
                                                "No Bill"
                                            @endif
                                        </td>
                                        <td>{{ $sale->currency->name }}</td>
                                        <td>{{ $sale->total }}</td>
                                        <td>{{ $sale->total - $sale->remaining }}</td>
                                        <td>{{ $sale->remaining }}</td>
                                        <td>{{ $sale->created_at }}</td>
                                        <td>
                                            @if (
                                                $sale->hasTransaction 
                                                && !$sale->currency->is_default 
                                                && request()->filled('defaultCurrencyApplyed')
                                            )
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
                        <div class="mt-1">
                            {{__('locale.Transfers')}}
                        </div>
                        <table class="table table-sm table-bordered sortable">
                            <thead>
                                <tr id="sortable_by">
                                    <th>{{ __('locale.ID') }}</th>
                                    <th>{{ __('locale.Type') }}</th>
                                    <th>{{ __('locale.Amount') }}</th>
                                    <th>{{ __('locale.Currency') }}</th>
                                    <th>{{ __('locale.Created at') }}</th>
                                    <th class="skip_sort">{{ __('locale.Note') }}</th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                @forelse ($client->records as $record)
                                    @php
                                        $currency = $record->currency->name;
                                        $total = $record->quantity;
                                        $remaining = 0;
                                        if(!isset($stats[$currency])){
                                            $stats[$currency] = [
                                                'count' => 1,
                                                'total'=>$total,
                                                'remaining'=>$remaining,
                                            ];
                                        }else{
                                            $stats[$currency]['count'] += 1;
                                            $stats[$currency]['total'] += $total;
                                            $stats[$currency]['remaining'] += $remaining;
                                        }
                                    @endphp
                                    <tr>
                                        <td>{{ $record->id }}</td>
                                        <td>{{ $record->record_type }}</td>
                                        <td>{{ $record->quantity }}</td>
                                        <td>{{ $record->currency->name }}</td>
                                        <td>{{ $record->created_at }}</td>
                                        <td>{{ $record->note }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            <span class="badge badge-light-info me-1">
                                                {{__('locale.Not Found')}}
                                            </span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                        <div class="mt-1">
                            {{__('locale.Summary')}}
                        </div>
                        <table class="table table-sm table-bordered">
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
