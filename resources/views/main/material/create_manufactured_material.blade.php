@extends('layouts/contentLayoutMaster')

@section('title')
    {{ $material->name }}
@endsection

@section('content')
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
@endsection

<section id="multiple-column-form">
    <form method="POST" action="{{ route('material.store_manufacture_model') }}" class="form form-vertical">
        @csrf
        <input type="hidden" name="material_id" value="{{$material->id}}">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    @if ($errors->any())
                        <div class="alert alert-danger m-1">
                            <ul class="m-0">
                                @foreach ($errors->all() as $error)
                                    <li class="p-1">{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <div class="card-header p-1 pb-0">
                        <h4 class="card-title">
                            {{ __('locale.Manufacture model') }} -
                            {{ $material->name }}
                        </h4>
                    </div>
                    <div class="card-body p-1 pt-0" x-data="{
                        currencies: {{ $currencies->keyBy('id')->toJson() }},
                        materials: {{ $materials->keyBy('id')->toJson() }}
                    }">
                        <div class="row my-1">
                            {{-- <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="type">{{ __('locale.Inventory') }} To store new
                                        material</label>
                                    <select name="inventory_to_store_id" id="type"required
                                        class="form-select @error('type') border-danger @enderror">
                                        <option value="">{{ __('locale.Chose') }}</option>
                                        @forelse ($inventories as $inventory)
                                            <option value="{{ $inventory->id }}">
                                                {{ $inventory->name }}
                                            </option>
                                        @empty
                                            <option value="">{{ __('locale.None') }}</option>
                                        @endforelse
                                    </select>
                                </div>
                            </div> --}}
                            <ul class="nav nav-tabs px-2 m-0" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="material-tab" data-bs-toggle="tab" href="#material"
                                        aria-controls="material" role="tab" aria-selected="true">
                                        {{ __('locale.Materials') }}
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="accounts-tab" data-bs-toggle="tab" href="#accounts"
                                        aria-controls="accounts" role="tab" aria-selected="false">
                                        {{ __('locale.Account') }}
                                    </a>
                                </li>
                            </ul>
                            <div class="tab-content">
                                <div class="tab-pane active" id="material" aria-labelledby="material-tab"
                                    role="tabpanel">
                                    <div class="col-12 my-1">
                                        <table class="table table-sm table-borderless materials-repeater">
                                            <thead>
                                                <tr class="">
                                                    <th class="py-1">{{ __('locale.Material') }}</th>
                                                    <th class="py-1">{{ __('locale.Inventory') }}</th>
                                                    <th class="py-1">{{ __('locale.Quantity') }}</th>
                                                    <th class="py-1">{{ __('locale.Unit') }}</th>
                                                    <th class="py-1">{{ __('locale.Cost') }}</th>
                                                    <th class="py-1">{{ __('locale.Currency') }}</th>
                                                    <th data-repeater-create>
                                                        <button type="button" class="btn btn-primary w-100">
                                                            {{ __('locale.Add') }}
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody data-repeater-list="materials">
                                                <tr data-repeater-item x-data="{
                                                    material_id: 0,
                                                    inventory_id: 0,
                                                    currency_id: 0,
                                                    quantity: 0,
                                                    limit: 0,
                                                    materialUnits: {},
                                                    materialInventories: {},
                                                    currencyRates: {},
                                                    setMaterialUnits(id) {
                                                        this.materialUnits = this.materials[id].units;
                                                        this.materialInventories = this.materials[id].inventories;
                                                    },
                                                    setInventoryLimit(id) {
                                                        Object.keys(this.materialInventories).forEach(inventory => {
                                                            if (this.materialInventories[inventory].id == id) {
                                                                return this.limit = Number(this.materialInventories[inventory].pivot.quantity);
                                                            }
                                                        })
                                                    },
                                                    setCurrencyRates(id) {
                                                        return this.currencyRates = this.currencies[id].rates;
                                                    },
                                                }">
                                                    <th class="px-0">
                                                        <select name="material_id" id="material" x-model="material_id" required
                                                            class="form-select @error('material') border-danger @enderror"
                                                            x-init="$watch('material_id', value => setMaterialUnits(value))">
                                                            <option value="">
                                                                {{ __('locale.Chose') }}
                                                            </option>
                                                            @forelse ($materials as $material)
                                                                <option value="{{ $material->id }}">
                                                                    {{ $material->name }}
                                                                </option>
                                                            @empty
                                                                <option value="">
                                                                    {{ __('locale.None') }}
                                                                </option>
                                                            @endforelse
                                                        </select>
                                                    </th>
                                                    <th class="p">
                                                        <select name="inventory_id" id="inventory" required
                                                            x-model="inventory_id"
                                                            class="form-select @error('inventory_id') border-danger @enderror"
                                                            x-init="$watch('inventory_id', value => setInventoryLimit(value))">
                                                            <option value="">
                                                                {{ __('locale.Chose') }}
                                                            </option>
                                                            <template x-for="inventory in materialInventories"
                                                                :key="inventory.id">
                                                                <option x-bind:value="inventory.id"
                                                                    x-text="inventory.name+
                                                                  ' | '+inventory.pivot.quantity">
                                                                </option>
                                                            </template>
                                                        </select>
                                                    </th>
                                                    <th class="p">
                                                        <input type="number" name="quantity" id="quantity"
                                                            class="form-control" required x-model="quantity"
                                                            :class="quantity > limit ? 'border-danger' : ''">
                                                    </th>
                                                    <th class="p">
                                                        <select name="unit_id" id="unit" required
                                                            class="form-select @error('unit_id') border-danger @enderror">
                                                            <option value="">
                                                                {{ __('locale.Chose') }}
                                                            </option>
                                                            <template x-for="unit in materialUnits"
                                                                :key="unit.id">
                                                                <option x-bind:value="unit.id"
                                                                    x-text="unit.name+' '+unit.pivot.is_default+' '+unit.pivot.rate_to_main_unit">
                                                                </option>
                                                            </template>
                                                        </select>
                                                    </th>
                                                    <th class="p">
                                                        <input type="number" name="cost" id="cost"
                                                            class="form-control" required>
                                                    </th>
                                                    <th class="p">
                                                        <select name="currency_id" id="currency" required
                                                            class="form-select @error('currency_id') border-danger @enderror">
                                                            <option value="">
                                                                {{ __('locale.Chose') }}
                                                            </option>
                                                            @forelse($currencies as $currency)
                                                                <option value="{{ $currency->id }}">
                                                                    {{ $currency->name }}
                                                                </option>
                                                            @empty
                                                            @endforelse
                                                        </select>
                                                    </th>
                                                    <th class="px-0" data-repeater-delete>
                                                        <button type="button" class="btn btn-danger w-100">
                                                            {{ __('locale.Delete') }}
                                                        </button>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="tab-pane" id="accounts" aria-labelledby="accounts-tab" role="tabpanel">
                                    <div class="col-12">
                                        <div class="mb-1">
                                            <label class="form-label" for="type">                                          
                                                {{__('locale.Account')}}
                                            </label>
                                            <select name="account_id" id="type" required
                                                class="form-select @error('type') border-danger @enderror">
                                                <option value="">{{ __('locale.Chose') }}</option>
                                                @foreach($accountTypes as $type)
                                                    <option value="{{$type->id}}">
                                                        {{$type->name}}
                                                    </option>
                                                @endforeach 
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-12 my-1">
                                        <table class="table table-sm table-borderless expenses-repeater">
                                            <thead>
                                                <tr class="">
                                                    <th class="py-1">{{ __('locale.Expense') }}</th>
                                                    <th class="py-1">{{ __('locale.Cost') }}</th>
                                                    <th class="py-1">{{ __('locale.Note') }}</th>
                                                    <th data-repeater-create>
                                                        <button type="button" class="btn btn-primary w-100">
                                                            {{ __('locale.Add') }}
                                                        </button>
                                                    </th>
                                                </tr>
                                            </thead>
                                            <tbody data-repeater-list="expenses">
                                                <tr data-repeater-item>
                                                    <th class="px-0">
                                                        <select name="expense_id" id="" class="form-select" required>
                                                            <option value="">{{ __('locale.Chose') }}</option>
                                                            @foreach($expenses as $expense)
                                                                <option value="{{$expense->id}}">
                                                                    {{$expense->name}}
                                                                </option>
                                                            @endforeach    
                                                        </select>
                                                    </th>
                                                    <th class="">
                                                        <input type="number" name="cost" id=""
                                                            class="form-control"  required
                                                            placeholder="{{__('locale.Cost')}}">
                                                    </th>
                                                    <th class="px-0">
                                                        <input type="text" name="note" class="form-control"
                                                            placeholder="{{__('locale.Note')}}">
                                                    </th>
                                                    <th class="" data-repeater-delete>
                                                        <button type="button" class="btn btn-danger w-100">
                                                            {{ __('locale.Delete') }}
                                                        </button>
                                                    </th>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-body row">
                        <div class="col-6">
                            <button type="submit" class="btn btn-primary btn-sm w-50">
                                {{ __('locale.Store') }}
                            </button>
                            <button type="reset" class="btn btn-outline-primary btn-sm">
                                {{ __('locale.Reset') }}
                            </button>
                            <a href="{{ url('/') }}"class="btn btn-outline-dark btn-sm">
                                {{ __('locale.Cancel') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            'use strict';
            // form repeater jquery
            $('.materials-repeater').repeater({
                isFirstItemUndeletable: true,
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                   $(this).slideUp(deleteElement);
                },

            });
        });

        $(function() {
            $('.expenses-repeater').repeater({
                isFirstItemUndeletable: true,
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                }
            });
        })
    });
</script>
@endsection
