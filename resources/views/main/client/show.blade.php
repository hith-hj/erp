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
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td>
                                        @if(isset($sale->bill))
                                            <a href="{{ route('bill.show',$sale->bill?->id) }}">
                                                {{ $sale->bill?->serial }}
                                            </a>
                                        @else
                                            " ----- "
                                        @endif
                                    </td>
                                    <td>{{ $sale->currency->name }}</td>
                                    <td>{{ number_format($sale->total,2) }}</td>
                                    <td>{{ number_format($sale->total - $sale->remaining,2) }}</td>
                                    <td>{{ number_format($sale->remaining,2) }}</td>
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
                                            {{__('locale.Not found')}}
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
                                <tr>
                                    <td>{{ $record->id }}</td>
                                    <td>{{ __('locale.'.ucfirst($record->record_type)) }}</td>
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
                            @forelse ($stats as $currency => $stat)
                                <tr class="text-primary border-primary">
                                    <th>
                                        {{ $currency }}
                                        @if($stat['is_default'])
                                            <span class="badge bg-primary text-xs">{{ __('locale.Default') }}</span>
                                        @endif
                                    </th>
                                    <th>
                                        {{ __('locale.Total'). ' : ' .  $stat['total_count'] }}
                                        [ {{ __('locale.Sales'). ' : ' .  $stat['sales_count'] }} ]
                                        [ {{ __('locale.Records'). ' : ' .  $stat['records_count'] }} ]
                                    </th>
                                    <th> {{ __('locale.Credit') . ' : ' . $stat['total_credit'] }} </th>
                                    <th> {{ __('locale.Debit') . ' : ' . $stat['total_debit'] }} </th>
                                    <th> {{ __('locale.Balance difference') . ' : ' . $stat['net_balance']  }} </th>
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
                                    <h4>{{__('locale.Rates')}}</h4>
                                </div>
                                <div class="modal-body p-0">
                                    <table class="table table-lg table-bordered">
                                        <thead>
                                            <tr>
                                                <th>{{__('locale.Currency')}}</th>
                                                <th>{{__('locale.Amount')}}</th>
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
                                                        {{-- total:{{$item['total']}},
                                                        remaining:{{$item['remaining']}},
                                                        payed:{{$item['total'] - $item['remaining']}}, --}}
                                                        total:{{$item['total_credit']}},
                                                        remaining:{{$item['total_debit']}},
                                                        payed:{{$item['net_balance']}},
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
                                                        <td> {{ $item['total_credit'] ?? $item['total_debit']}} </td>
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
