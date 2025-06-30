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
<form id="purchase_form" method="POST" action="{{ route('ledger.store') }}"
    class="form form-vertical">
    @csrf
    <div>
        <div class="card mb-1">
            <div class="card-header d-flex p-1">
                <h4>
                    {{ __('locale.Basic info') }}
                </h4>
            </div>
            <div class="card-body p-0 px-1">
                <input type="hidden" name="ledger_id" value="{{$ledger->id}}">
                <div class="row">
                    <div class="col-3">
                        <div class="mb-1">
                            <label class="form-label" for="currency">
                                {{ __('locale.Currency') }}
                            </label>
                            <select id="currency" name="currency_id" x-model="currency_id"
                                class="form-select @error('currency_id') border-danger @enderror">
                                <option value="">{{ __('locale.Chose') }} </option>
                                @foreach ($currencies as $currency)
                                    <option value="{{ $currency->id }}">
                                        {{ $currency->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.Note') }}</label>
                            <input type="text" name="note"
                                class="form-control" value="{{ old('note') }}" />
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-1">
                            <label class="form-label">{{ __('locale.Date') }}</label>
                            <input type="text" name="date" class="form-control" readonly
                                value="{{ $ledger->created_at->format('Y-m-d H:i') }}" />
                        </div>
                    </div>
                </div>
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

        <div class="card mb-1">
            <ul class="nav nav-tabs px-1 mb-0" role="tablist">
                <li class="nav-item">
                    <a class="nav-link w-100 active"
                        data-bs-toggle="tab" href="#list_items" aria-controls="list_items" role="tab">
                        {{ __('locale.List') }}
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link w-100"
                        data-bs-toggle="tab" href="#new_items" aria-controls="new_items" role="tab">
                        {{ __('locale.New') }}
                    </a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="list_items" class="tab-pane active">
                    <div class="card">
                        <div class="card-header p-1 d-flex justify-content-between">
                            <h4 class="m-0">
                                {{ __('locale.List') }}
                            </h4>
                        </div>
                        <div class="card-body p-0 px-1">
                            <table class="table table-sm table-bordered mb-1">
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
                <div id="new_items" class="tab-pane "
                    x-data="{
                            clients: {{ $clients->keyBy('id')->toJson() }},
                            vendors: {{ $vendors->keyBy('id')->toJson() }},
                            currencies: {{ $currencies->keyBy('id')->toJson() }},
                            changed_balanced: {{ $ledger->end_balance }},
                            balance_diff: 0,
                            totals:{credits:0,debits:0},
                        }">
                    <div class="items-repeater">
                        <button type="button" data-repeater-create hidden class="btn-addRow"></button>
                        <div class="card mb-1">
                            <div class="card-header p-1 d-flex justify-content-between">
                                <div>
                                    <h4 class="m-0">
                                        {{ __('locale.New') }}
                                    </h4>
                                </div>
                                <div class="d-flex align-items-center justify-content-end">
                                    <h5 class="m-0">
                                        {{ __('locale.Rows count') }}
                                    </h5>
                                    <input type="number" id="rowCount"
                                        min="1" value="1"
                                        max="30"
                                        class="w-25 form-control form-control-sm mx-1"
                                        onkeypress="
                                        if(event.which == 13) {
                                            event.preventDefault();
                                            addRowX($(this).val());
                                        }">
                                    <button type="button"
                                        class="btn btn-primary btn-sm"
                                        onclick="addRowX($('#rowCount').val())">
                                        <i data-feather="plus"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="card-body p-0 px-1">
                                <table class="table table-sm mb-1">
                                    <thead class="">
                                        <tr>
                                            <th>{{ __('locale.Debit') }}</th>
                                            <th>{{ __('locale.Credit') }}</th>
                                            <th>{{ __('locale.Account') }}</th>
                                            <th>{{ __('locale.Currency') }}</th>
                                            <th>{{ __('locale.Note') }}</th>
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
                                                    debit:null,
                                                    credit:null,
                                                    quantity: null,
                                                    currency_id:null,
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
                                                            alert('wrong account record_type');
                                                        }
                                                    },
                                                    setCurrency(quantity){
                                                        if(this.currency_id === null){
                                                            return alert('Select Currency');
                                                        }
                                                        this.currency = this.currencies[this.currency_id];
                                                        if(!this.currency.is_default){
                                                            quantity = quantity * Number(this.currency.rate_to_default);
                                                        }
                                                        return quantity;
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
                                                        if(value > 0){
                                                            this.record_type = type;
                                                            this.setAccounts(this.record_type);
                                                            this.quantity = value;
                                                        }else{
                                                            this.record_type = null;
                                                            this.currency_id = null;
                                                            this.quantity = null;
                                                            this.accounts = {};
                                                        }
                                                    }
                                                }">
                                            <td>
                                                <input type="hidden" name="record_type" x-model="record_type" >
                                                <input type="hidden" name="quantity" x-model="quantity" >
                                                <input type="number"
                                                    class="form-control"
                                                    x-ref="debit"
                                                    x-model="debit"
                                                    x-init="$watch('debit', (value) => setRecordType(value,'debit'))"
                                                    :disabled="record_type == 'credit' " />
                                            </td>
                                            <td>
                                                <input type="number"
                                                    class="form-control"
                                                    x-ref="credit"
                                                    x-model="credit"
                                                    x-init="$watch('credit', (value) => setRecordType(value,'credit'))"
                                                    :disabled="record_type == 'debit' "/>
                                            </td>
                                            <td>
                                                <select name="account_id" class="form-select" required>
                                                    <option value="">{{ __('locale.Chose') }} </option>
                                                    <option readonly disabled x-text="'{{__('locale.Expenses')}}'" class="text-primary"></option>
                                                    @foreach($expences as $expence)
                                                        <option value="{{'Expense_'.$expence->id}}">
                                                            {{$expence->name}}
                                                        </option>
                                                    @endforeach
                                                    <option readonly disabled class="text-primary">
                                                        {{__('locale.Vendors')}}
                                                    </option>
                                                    <template
                                                        x-for="account in accounts"
                                                        :key="account.id">
                                                        <option
                                                            :value="accounts_title+'_'+account.id"
                                                            x-text="account.first_name+' '+account.last_name">
                                                        </option>
                                                    </template>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="currency_id" class="form-select" x-model="currency_id" required
                                                    x-init="$watch('currency_id',(value)=>updateBalance())">
                                                    <option value="">{{ __('locale.Chose') }} </option>
                                                    @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">
                                                        {{ $currency->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" name="note" class="form-control" />
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

                                    {{-- <tbody data-repeater-list="records"
                                        id="ledger_records"
                                        onkeydown="
                                            if(event.which == 13) {
                                                event.preventDefault();
                                            }">
                                        <tr class="mt-5" data-repeater-item
                                            x-data="{
                                                    record_type: null,
                                                    debit:null,
                                                    credit:null,
                                                    quantity: null,
                                                    currency_id:null,
                                                    stored_quantity: 0,
                                                    accounts_title: null,
                                                    accounts: {},
                                                    setAccounts(record_type) {
                                                        if (this.record_type === 'debit') {
                                                            this.accounts = this.vendors;
                                                            this.accounts_title = 'Vendors';
                                                        } else if (this.record_type === 'credit') {
                                                            this.accounts = this.clients;
                                                            this.accounts_title = 'Clients';
                                                        } else {
                                                            this.accounts_title = null;
                                                            alert('wrong account record_type');
                                                        }
                                                    },
                                                    setCurrency(quantity){
                                                        if(this.currency_id === null){
                                                            return alert('Select Currency');
                                                        }
                                                        this.currency = this.currencies[this.currency_id];
                                                        if(!this.currency.is_default){
                                                            quantity = quantity * Number(this.currency.rate_to_default);
                                                        }
                                                        return quantity;
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
                                                        if(value > 0){
                                                            this.record_type = type;
                                                            this.setAccounts(this.record_type);
                                                            this.quantity = value;
                                                        }else{
                                                            this.record_type = null;
                                                            this.currency_id = null;
                                                            this.quantity = null;
                                                            this.accounts = {};
                                                        }
                                                    }
                                                }">
                                            <td>
                                                <input type="hidden" name="record_type" x-model="record_type" >
                                                <input type="hidden" name="quantity" x-model="quantity" >
                                                <input type="number"
                                                    class="form-control"
                                                    x-ref="debit"
                                                    x-model="debit"
                                                    x-init="$watch('debit', (value) => setRecordType(value,'debit'))"
                                                    :disabled="record_type == 'credit' " />
                                            </td>
                                            <td>
                                                <input type="number"
                                                    class="form-control"
                                                    x-ref="credit"
                                                    x-model="credit"
                                                    x-init="$watch('credit', (value) => setRecordType(value,'credit'))"
                                                    :disabled="record_type == 'debit' "/>
                                            </td>
                                            <td>
                                                <select name="account_id" class="form-select" required>
                                                    <option value="">{{ __('locale.Chose') }} </option>
                                                    <option readonly disabled x-text="'{{__('locale.Expenses')}}'" class="text-primary"></option>
                                                    @foreach($expences as $expence)
                                                        <option value="{{$expence->id}}">
                                                            {{$expence->name}}
                                                        </option>
                                                    @endforeach
                                                    <option readonly disabled class="text-primary">
                                                        {{__('locale.'.@js())}}
                                                    </option>
                                                    <template
                                                        x-for="account in accounts"
                                                        :key="account.id">
                                                        <option
                                                            :value="account.id"
                                                            x-text="account.first_name+' '+account.last_name">
                                                        </option>
                                                    </template>
                                                </select>
                                            </td>
                                            <td>
                                                <select name="currency_id" class="form-select" x-model="currency_id"
                                                x-init="$watch('currency_id',(value)=>updateBalance())" required>
                                                    <option value="">{{ __('locale.Chose') }} </option>
                                                    @foreach ($currencies as $currency)
                                                    <option value="{{ $currency->id }}">
                                                        {{ $currency->name }}
                                                    </option>
                                                    @endforeach
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text"
                                                    name="note"
                                                    class="form-control" />
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
                                    </tbody> --}}
                                </table>

                                <table class="table table-sm mb-1 ">
                                    <thead>
                                        <tr>
                                            <th>{{ __('locale.Base balance') }}</th>
                                            <th>{{ __('locale.Debit')}}</th>
                                            <th>{{ __('locale.Credit')}}</th>
                                            <th>{{ __('locale.Changed balance') }}</th>
                                            <th>{{ __('locale.Balance difference') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                        <tr >
                                            <td >{{ $ledger->end_balance }}</td>
                                            <td x-text="totals.debits" ></td>
                                            <td x-text="totals.credits" ></td>
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
                </div>
            </div>
        </div>
    </div>
</form>
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
