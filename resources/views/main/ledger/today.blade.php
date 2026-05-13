@extends('layouts/contentLayoutMaster')

@section('title')
{{ __('locale.Ledger') }}
@endsection
@section('page-style')
<style type="text/css">
    td {
        padding: 0 !important;
        width: 20rem !important;
    }
</style>
@endsection
@section('content')
<div class="card mb-1">
<ul class="nav nav-tabs px-1 mb-0" role="tablist">
    <li class="nav-item">
        <a class="nav-link w-100 active"
            data-bs-toggle="tab" href="#new_items" aria-controls="new_items" role="tab">
            {{ __('locale.New') }}
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link w-100"
            data-bs-toggle="tab" href="#list_items" aria-controls="list_items" role="tab">
            {{ __('locale.List') }} <sup> ({{count($ledger->records)}}) </sup>
        </a>
    </li>
</ul>
<div class="tab-content">
    {{-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXX  First Section XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX --}}
    <div id="new_items" class="tab-pane active"
        x-data="{
            clients: {{ $clients->keyBy('id')->toJson() }},
            vendors: {{ $vendors->keyBy('id')->toJson() }},
            currencies: {{ $currencies->keyBy('id')->toJson() }},
            changed_balanced: {{ $ledger->end_balance }},
            balance_diff: 0,
            totals:{credits:0,debits:0},
        }">
        <form id="purchase_form" method="POST"
            action="{{ route('ledger.store') }}" class="form form-vertical"
            x-data="{
                main_currency:Object.keys(currencies)[0],
            }">
            @csrf
            <input type="hidden" name="ledger_id" value="{{$ledger->id}}">
            <div class="items-repeater" >
                <button type="button" data-repeater-create hidden class="btn-addRow"></button>
                <div class="card mb-1">
                    <div class="card-header p-1 d-flex justify-content-between">
                        <div class="w-75">
                            <div class="row">
                                <div class="col-6">
                                    <label class="form-label">{{ __('locale.Date') }}</label>
                                    <input type="text" name="date" class="form-control form-control-sm" readonly
                                        value="{{ $ledger->created_at->format('Y-m-d') }}" />
                                </div>
                                <div class="col-6">
                                    <label class="form-label" for="currency">
                                        {{ __('locale.Currency') }}
                                    </label>
                                    <select id="currency" name="main_currency"
                                        x-model="main_currency" class="form-select form-select-sm">
                                        <option value="">{{ __('locale.Chose') }} </option>
                                        @foreach ($currencies as $currency)
                                            <option value="{{ $currency->id }}">
                                                {{ $currency->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="w-25 d-flex justify-content-end">
                            <div class="col-6">
                                <label class="form-label">{{ __('locale.Rows count') }}</label>
                                <div class="d-flex">
                                    <input type="number" id="rowCount"
                                        min="1" value="1" max="30"
                                        class="form-control form-control-sm"
                                        onkeypress="
                                        if(event.which == 13) {
                                            event.preventDefault();
                                            addRowX($(this).val());
                                        }">
                                    <button type="button"
                                        class="btn btn-primary btn-sm mx-1"
                                        onclick="addRowX($('#rowCount').val())">
                                        <i data-feather="plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body p-0 px-1">
                        <table class="table table-sm mb-1">
                            <thead class="">
                                <tr>
                                    <th>{{ __('locale.Currency') }}</th>
                                    <th>{{ __('locale.Debit') }}</th>
                                    <th>{{ __('locale.Credit') }}</th>
                                    <th>{{ __('locale.Account') }}</th>
                                    <th>{{ __('locale.Note') }}</th>
                                    <th>{{ __('locale.Total') }}</th>
                                    <th>{{ __('locale.Options') }}</th>
                                </tr>
                            </thead>
                            <tbody data-repeater-list="records"
                                id="ledger_records"
                                onkeydown="
                                if(event.which == 13) {
                                    event.preventDefault();
                                }">
                                <tr class="mt-5" data-repeater-item
                                    x-data="{
                                        record_type: null,
                                        debit: null,
                                        credit: null,
                                        quantity: null,
                                        currency_id: main_currency,
                                        stored_quantity: 0,
                                        accounts_title: null,
                                        accounts: {},
                                        setAccounts(record_type) {
                                            if (this.record_type === 'debit') {
                                                this.accounts = this.vendors;
                                                this.accounts_title = 'Vendor';
                                            } else if (this.record_type === 'credit') {
                                                this.accounts = this.clients;
                                                this.accounts_title = 'Client';
                                            } else {
                                                this.accounts_title = null;
                                                {{-- alert('wrong record type'); --}}
                                            }
                                        },
                                        setCurrency(quantity){
                                            if(this.currency_id === null){
                                                return alert('Select Currency');
                                            }
                                            currency = this.currencies[this.currency_id];
                                            if(!currency.is_default){
                                                quantity = quantity * Number(currency.rate_to_default);
                                            }
                                            return Number(quantity);
                                        },
                                        updateBalance() {
                                            amount = this.setCurrency(this.quantity);
                                            amount = Number(amount);
                                            this.stored_quantity = Number(this.stored_quantity);
                                            if (this.record_type === 'debit') {
                                                this.changed_balanced += this.stored_quantity;
                                                this.changed_balanced -= amount
                                                this.totals.debits -= this.stored_quantity;
                                                this.totals.debits += amount
                                            } else if (this.record_type === 'credit') {
                                                this.changed_balanced -= this.stored_quantity;
                                                this.changed_balanced += amount
                                                this.totals.credits -= this.stored_quantity;
                                                this.totals.credits += amount
                                            } else {
                                                alert('set account type');
                                                return;
                                            }
                                            this.balance_diff = Number(this.changed_balanced) - Number({{ $ledger->end_balance }})
                                            this.stored_quantity = amount
                                        },
                                        setRecordType(value,type){
                                            value = Number(value);
                                            if(value <= 0){
                                                this.quantity = value;
                                                this.updateBalance();
                                                this.quantity = null;
                                                this.accounts = {};
                                                this.record_type = null;
                                            }else{
                                                this.record_type = type;
                                                this.quantity = value;
                                                this.setAccounts(this.record_type);
                                                this.updateBalance();
                                            }
                                        },
                                        updateCurrencies(value){
                                            this.currency_id=value;
                                        },
                                    }">
                                    <input type="hidden" x-init="$watch('main_currency',(value)=>updateCurrencies(value))">
                                    <td>
                                        <select name="currency_id" class="form-select" x-model="currency_id" required>
                                            <option value="">{{ __('locale.Chose') }} </option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}">
                                                    {{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </td>
                                    <td>
                                        <input type="hidden" name="record_type" x-model="record_type" >
                                        <input type="hidden" name="quantity" x-model="quantity" >
                                        <input type="number" class="form-control" min="1" x-model="debit"
                                            x-init="$watch('debit', (value) => setRecordType(value,'debit'))"
                                            :disabled="record_type == 'credit' " />
                                    </td>
                                    <td>
                                        <input type="number" class="form-control" min="1" x-model="credit"
                                            x-init="$watch('credit', (value) => setRecordType(value,'credit'))"
                                            :disabled="record_type == 'debit' "/>
                                    </td>
                                    <td>
                                        <input list="browsers" name="account_id" id="browser" class="form-control" required>
                                        <datalist id="browsers">
                                            <option value="">{{ __('locale.Chose') }} </option>
                                            @foreach($expences as $expence)
                                                <option value="{{'Expense_'.$expence->id}}">
                                                    {{$expence->name}}
                                                </option>
                                            @endforeach
                                            @foreach($clients as $client)
                                                <option value="{{'Client_'.$client->id}}">
                                                    {{$client->first_name .' '. $client->last_name}}
                                                </option>
                                            @endforeach
                                            @foreach($vendors as $vendor)
                                                <option value="{{'Vendor_'.$vendor->id}}">
                                                    {{$vendor->first_name .' '. $vendor->last_name}}
                                                </option>
                                            @endforeach
                                        </datalist>
                                    </td>
                                    <td>
                                        <input type="text" name="note" class="form-control" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" x-model="stored_quantity" />
                                    </td>
                                    <td>
                                        <button
                                            class="btn btn-default "
                                            type="button"
                                            data-repeater-delete>
                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                width="14"
                                                height="14"
                                                viewBox="0 0 24 24"
                                                fill="none"
                                                stroke="currentColor"
                                                stroke-width="2"
                                                stroke-linecap="round"
                                                stroke-linejoin="round"
                                                class="feather feather-trash text-danger">
                                                <polyline
                                                    points="3 6 5 6 21 6">
                                                </polyline>
                                                <path
                                                    d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                                </path>
                                            </svg>
                                        </button>
                                    </td>
                                </tr>
                            </tbody>
                        </table>

                        <table class="table table-sm mb-1 ">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.Debit')}}</th>
                                    <th>{{ __('locale.Credit')}}</th>
                                    <th>{{ __('locale.Base balance') }}</th>
                                    <th>{{ __('locale.Changed balance') }}</th>
                                    <th>{{ __('locale.Balance difference') }}</th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                <tr >
                                    <td x-text="totals.debits" ></td>
                                    <td x-text="totals.credits" ></td>
                                    <td >{{ $ledger->end_balance }}</td>
                                    <td x-text="changed_balanced" ></td>
                                    <td x-text="balance_diff" ></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="card-body p-1">
                <div class="row">
                    <div class="col-12">
                        <button typex="submit" class="btn btn-primary w-50">
                            {{ __('locale.Store') }}
                        </button>
                        <a class="btn btn-outline-dark"
                            data-bs-dismiss="modal" aria-label="Close">
                            {{ __('locale.Cancel') }}
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- XXXXXXXXXXXXXXXXXXXXXXXXXXXXX  Second Section XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX --}}
    <div id="list_items" class="tab-pane ">
        <div class="card mb-0 mt-1">
            <h4 class="m-0 px-1">
                {{ __('locale.Basic info') }}
            </h4>
            <div class="card-body p-0 px-1">
                <table class="table table-sm table-bordered mb-1">
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
                            <td>{{$ledger->records->count()}}</td>
                            <td>{{$ledger->start_balance }}</td>
                            <td>{{$ledger->end_balance }}</td>
                            <td>{{$ledger->end_balance - $ledger->start_balance}}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-0 px-1">
                <h4 class="m-0">
                    {{ __('locale.List') }}
                </h4>
                <table class="table table-sm table-bordered mb-1 max-height">
                    <thead class="">
                        <tr>
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
                                <th>{{ __('locale.'.ucfirst($record->record_type) ) }}</th>
                                <th>
                                    @php
                                        $class = class_basename($record->account_type);
                                        $route = strtolower($class);
                                    @endphp
                                    <a href="{{route($route.'.show',[$route=>$record->account_id])}}"
                                        target="__blanck"
                                        >
                                        {{$class.' - '.$record->account_id}}
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
                <h4 class="m-0">
                    {{ __('locale.Stats') }}
                </h4>
                <table class="table table-sm table-bordered mb-1">
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
                                <td> {{ $key}} </td>
                                <td> {{ $item['count'] }} </td>
                                <td> {{ $item['total']}} </td>
                            </tr>
                        @empty
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>

@endsection
@section('page-script')
<script
    src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js">
</script>
<script
    src="https://www.jqueryscript.net/demo/Navigate-Table-Arrow-Keys/dist/arrow-table.js">
</script>

<script>
    $(document).ready(function() {
        $(function() {
            'use strict';
            $('.items-repeater').repeater({
                isFirstItemUndeletable: true,
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
            });
            addRowX($('#rowCount').val());
            $('.table').arrowTable({
                focusTarget: 'input, textarea, select',
                listenTarget: 'input, select',
            });
        });
    });

    function addRowX(count = 1) {
        if (count > 30) {
            return alert('only 30 rows at once');
        }
        for (let i = 0; i < count && count <= 30; i++) {
            $('.btn-addRow').click();
        }
        focusElement();
    }

    function focusElement() {
        let list = $('#ledger_records');
        let valueChecker = list.children('tr:first-child')
            .children('td:first-child')
            .children(':first-child');
        let elementToBeFocused;
        // if (valueChecker.val().length === 0) {
        //     elementToBeFocused = list.children('tr:first-child');
        // } else {
        //     elementToBeFocused = list.children('tr:last-child');
        // }
        elementToBeFocused = list.children('tr:first-child');
        elementToBeFocused.children('td:first-child').children(":first-child")
            .focus();
    }
</script>
@endsection
