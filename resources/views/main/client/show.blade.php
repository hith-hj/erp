@extends('layouts.contentLayoutMaster')

@section('title')
    {{ $client->full_name }}
@endsection

@section('content')
    <section id="card-content-types">
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
                                            'is_default'=>$sale->currency->is_default,
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
                                            'is_default'=>$record->currency->is_default,
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
                        <div class="d-flex justify-content-between">
                            <span>{{__('locale.Summary')}}</span>

                            <span class="text-success" type="button" data-bs-toggle="modal"
                            data-bs-target="#changeBalanceRates">
                                <i class="fa fa-refresh"></i>
                                {{__('locale.Rates') }}
                            </span>
                        </div>
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
                    <div class="modal fade" id="changeBalanceRates" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Enter changed rates</h4>
                                </div>
                                <div class="modal-body p-0">
                                    <table class="table table-lg table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{__('locale.Currency')}}</th>
                                                <th>{{__('locale.Rate')}}</th>
                                                <th>{{__('locale.Total')}}</th>
                                                <th>{{__('locale.Payed')}}</th>
                                                <th>{{__('locale.Remaining')}}</th>
                                                <th>{{__('locale.Options')}}</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-hover">
                                            @forelse ($stats as $key => $item)
                                                @if($item['is_default'] !== true)
                                                    <tr class="text-primary border-primary"
                                                    x-data="{
                                                        rate:null,
                                                        total:{{$item['total']}},
                                                        remaining:{{$item['remaining']}},
                                                        payed:{{$item['total'] - $item['remaining']}},
                                                        old_value:null,
                                                        calculate(value){
                                                            if(value == 0 || isNaN(value)){
                                                                return;
                                                            }
                                                            this.subOldValue();
                                                            this.total *= Number(value);
                                                            this.remaining *= Number(value);
                                                            this.old_value = Number(value);
                                                            this.updatePayed();
                                                        },
                                                        subOldValue(){
                                                            if(this.old_value !== null){
                                                                this.total /= this.old_value;
                                                                this.remaining /= this.old_value;
                                                            }
                                                        },
                                                        updatePayed(){
                                                            this.payed = this.total - this.remaining;
                                                        },
                                                        reset(){
                                                            this.calculate(1);
                                                        }
                                                    }">
                                                        <td> {{ $key}} </td>
                                                        <td>
                                                            <input class="form-control" type="numeric" x-model='rate'
                                                            x-init="$watch('rate',(value)=>calculate(value) )">
                                                        </td>
                                                        <td x-text="total"></td>
                                                        <td x-text="payed"></td>
                                                        <td x-text="remaining"></td>
                                                        <td @click="reset">
                                                            <i class="fa fa-recycle"></i>
                                                        </td>
                                                    </tr>
                                                @endif
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
                </div>
            </div>
        </div>
    </section>
@endsection


@section('page-script')
    <script src="{{asset('js/printout.js')}}"></script>
    <script src="{{asset('js/helpers.js')}}"></script>
@endsection
