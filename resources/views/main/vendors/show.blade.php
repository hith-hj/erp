@extends('layouts/contentLayoutMaster')

@section('title')
    {{-- {{ __('locale.Show') }} {{ __('locale.Material') }} --}}
    {{ $vendor->first_name }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="card-head mb-1 row">
            <h4 class="col-10">{{ __('locale.Show') }}</h4>
            <div class="col-2">
                <button class="btn btn-sm btn-outline-danger w-100" 
                    onclick="
                        if(confirm('{{__('locale.Delete')}} ?')){
                            document.getElementById('deleteVendorForm').submit();
                        }
                    " >
                    {{ __('locale.Delete') }}
                </button>
                <form id="deleteVendorForm" 
                    method="Post" 
                    action="{{route('vendor.delete',['vendor'=>$vendor])}}">
                    @csrf @method('delete')
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h5>{{__('locale.Details')}}</h5>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('locale.First name')}} :
                            {{ $vendor->first_name }}
                        </h4>
                        <div class="card-text">
                            {{__('locale.Last name')}} : 
                            {{ $vendor->last_name }}
                        </div>
                        <div class="card-text">
                            {{__('locale.Email')}} : 
                            {{ $vendor->email }}
                        </div>
                        <div class="card-text">
                            {{__('locale.Phone')}} : 
                            {{ $vendor->phone }}
                        </div>
                        <p class="card-text">
                            {{__('locale.Created at')}}
                            {{ $vendor->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>{{__('locale.Name')}}</th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                    <tr>
                                        <td>
                                            <span class="badge rounded-pill badge-light-success me-1">
                                               something
                                            </span>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
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
                                    @foreach ($purchases->currencies as $currency)
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
                            {{__('locale.Purchases')}}
                        </div>
                        <table class="table table-sm table-bordered sortable">
                            <thead>
                                <tr id="sortable_by">
                                    <th>{{__('locale.ID')}}</th>
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
                                @forelse ($purchases as $purchase)
                                    <tr>
                                        <td>{{ $purchase->id }}</td>
                                        <td>
                                            @if(isset($purchase->bill))
                                                <a href="{{ route('bill.show',$purchase->bill?->id) }}">
                                                    {{ $purchase->bill?->serial }}
                                                </a>
                                            @else
                                                " ----- "
                                            @endif
                                        </td>
                                        <td>{{ $purchase->currency->name }}</td>
                                        <td>{{ $purchase->total }}</td>
                                        <td>{{ $purchase->total - $purchase->remaining }}</td>
                                        <td>{{ $purchase->remaining }}</td>
                                        <td>{{ $purchase->created_at }}</td>
                                        <td>
                                            @if (
                                                $purchase->hasTransaction
                                                && !$purchase->currency->is_default
                                                && request()->filled('defaultCurrencyApplyed')
                                            )
                                                "Default Currency Applyed"
                                            @endif
                                            @if (!$purchase->hasTransaction)
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
                                @forelse ($vendor->records as $record)
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
                                            [ {{ __('locale.Purchases'). ' : ' .  $stat['purchases_count'] }} ]
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
                                                @forelse ($stats as $currency => $item)
                                                    @if($item['is_default'] !== true)
                                                        <tr class="text-primary border-primary"
                                                        x-data="{
                                                            rate:null,
                                                            {{-- total:{{$item['total']}},
                                                            remaining:{{$item['remaining']}},
                                                            payed:{{$item['total'] - $item['remaining']}}, --}}
                                                            total:{{$item['total_debit']}},
                                                            remaining:{{$item['total_credit']}},
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
                                                            <td> {{ $currency}} </td>
                                                            <td>{{$item['total_credit'] ?? $item['total_debit'] }}</td>
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
        </div>

    </section>
@endsection


@section('page-script')
    <script src="{{asset('js/printout.js')}}"></script>
    <script src="{{asset('js/helpers.js')}}"></script>
@endsection
