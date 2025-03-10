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
                            <span>    
                                <i class="text-primary" data-feather="printer" 
                                onclick="printTable('printable')"></i>
                            </span>
                            <div class='dropdown'>
                                <i data-feather="filter" data-bs-toggle='dropdown' class="text-primary"></i>
                                <div class='dropdown-menu dropdown-menu-end'>
                                    <a class='dropdown-item' onclick="handelFilter()">
                                        <i class="me-1" data-feather='refresh-cw'></i>
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
                    <div class="card-body">
                        <table class="table table-sm table-bordered sortable" id="printable">
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
                                @php
                                    $totalSales = 0;
                                    $total = 0;
                                    $remaining = 0;
                                @endphp
                                @forelse ($sales as $sale)
                                    @php
                                        $totalSales += 1;
                                        $total += $sale->total;
                                        $remaining += $sale->remaining;
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
                                            @if ($sale->defaultCurrencyApplyed && $sale->hasTransaction)
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
                                <tr class="text-primary border-primary">
                                    <th colspan="3"> {{ __('locale.Sales'). ' : ' .  $totalSales }} </th>
                                    <th> {{ __('locale.Total') . ' : ' .  $total}} </th>
                                    <th> {{ __('locale.Payed') . ' : ' .  $total - $remaining}} </th>
                                    <th> {{ __('locale.Remaining') . ' : ' .  $remaining}} </th>
                                    <td></td>
                                </tr>
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
