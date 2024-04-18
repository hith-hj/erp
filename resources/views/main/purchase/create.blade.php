@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.New Purchase') }}
@endsection
@section('content')
    <section id="multiple-column-form" x-data="{
        currencies: {{ $currencies->keyBy('id')->toJson() }},
    }">
        <form id="inventory_form" method="POST" action="{{ route('purchase.store') }}" class="form form-vertical">
            @csrf
            <div class="row">
                <div class="col-12">
                    <div class="card"
                        x-data='
                    {
                        ml:0,
                        cost:0,
                        from:0,
                        to:0,
                        rate:0,
                        total:0,
                        setMl(id){return this.ml=id},
                        setFrom(id){return this.from = id},
                        setTotal(id){
                            this.total = 0;
                            this.to = id;
                            Object.keys(this.currencies[this.from].rates).forEach(rate => {
                                if(this.currencies[this.from].rates[rate].id == this.to)
                                {
                                    return this.rate = this.currencies[this.from].rates[rate].pivot.rate;
                                }
                            })                            
                            return this.total = this.cost * this.rate;
                        },
                    }
                    '>
                        @if ($errors->any())
                            <div class="alert alert-danger m-1">
                                <ul class="m-0">
                                    @foreach ($errors->all() as $error)
                                        <li class="pb-1">{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <div class="card-header">
                            <h4 class="card-title">{{ __('locale.New Purchase') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="account">{{ __('locale.Account') }}</label>
                                        <select id="account" name="account" required class="form-select" >
                                            <option value="">{{__('locale.Chose')}}</option>
                                            @foreach ($accounts as $account)
                                                
                                                <option value="{{ $account['id'] }}" 
                                                    @if(old('account') == $account['id']) selected @endif>
                                                    {{ $account['name'] }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="vendor">{{ __('locale.Vendor') }}</label>
                                        <select id="vendor" name="vendor" required 
                                            class="form-select @error('vendor') border-danger @enderror">
                                            <option value="">{{__('locale.Chose')}}</option>
                                            @foreach ($vendors as $vendor)
                                                <option value="{{ $vendor['id'] }}"
                                                    @if(old('vendor') == $vendor['id']) selected @endif>
                                                    {{ $vendor['name'] }}
                                                </option>
                                                {{-- <option value="{{ $vendor->id }}">
                                                {{ $vendor->name }}
                                            </option> --}}
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="inventory_list">{{ __('locale.Inventory') }}</label>
                                        <select id="inventory_list" name="inventory_id" required 
                                            class="form-select" @error('inventory_id') border-danger @enderror>
                                            <option value="">{{__('locale.Chose')}}</option>
                                            @foreach ($inventories as $inventory)
                                                <option value="{{ $inventory->id }}"
                                                    @if(old('inventory_id') == $inventory->id ) selected @endif>
                                                    {{ $inventory->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="material_list">{{ __('locale.Materials') }}</label>
                                        <select x-model="ml" id="material_list" name="material_id" required
                                            class="form-select" @error('material_id') border-danger @enderror>
                                            <option value="">{{__('locale.Chose')}}</option>
                                            @foreach ($materials as $material)
                                                <option value="{{ $material->id }}"
                                                    @if(old('material_id') == $material->id ) selected @endif>
                                                    {{ $material->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="material_quantity">{{ __('locale.Quantity') }}</label>
                                        <input type="number" id="material_quantity" name="quantity"
                                            class="form-control @error('quantity') border-danger @enderror"
                                            placeholder="{{ __('locale.Quantity') }}" value="{{old('quantity')}}" required />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="units_list">{{ __('locale.Units') }}</label>
                                        @foreach ($materials as $material)
                                            <template x-if="ml == {{ $material->id }}">
                                                <select id="units_list" name="unit_id" required 
                                                    class="form-select @error('unit_id') border-danger @enderror ">
                                                    <option value="">{{__('locale.Chose')}}</option>
                                                    @forelse ($material->units as $unit)
                                                        <option value="{{ $unit->id }}"
                                                            @if(old('unit_id') == $unit->id ) selected @endif>
                                                            {{ $unit->name }} | {{ $unit->pivot->is_default ? 'default' : '' }}
                                                        </option>
                                                    @empty
                                                        <option>No Units Available</option>
                                                    @endforelse
                                                </select>
                                            </template>
                                        @endforeach
                                        <template x-if="ml == 0">
                                            <select class="form-select ">
                                                <option value="">Chose Material First</option>
                                            </select>
                                        </template>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="cost">{{ __('locale.Cost') }}</label>
                                        <input type="number" id="cost" name="cost"
                                            class="form-control @error('cost') border-danger @enderror"
                                            placeholder="{{ __('locale.Cost') }}" value="{{old('cost')}}" required x-model="cost" />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="currency">{{ __('locale.Currency') }}</label>
                                        <select id="currency" x-model="from" x-init="$watch('from', value => setFrom(value))" name="currency_id"
                                            required class=" form-select @error('currency_id') border-danger @enderror">
                                            <option value="">{{__('locale.Chose')}}</option>
                                            @foreach ($currencies as $currency)
                                                <option value="{{ $currency->id }}"
                                                    @if(old('currency_id') == $currency->id ) selected @endif>
                                                    {{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="rate_to">{{ __('locale.Rate') }}</label>
                                        <select x-model="to" name="rate_to" 
                                            class="form-select @error('rate_to') border-danger @enderror"
                                            x-init="$watch('to', value => setTotal(value))" required> 
                                            <option value="">{{__('locale.Chose')}}</option>
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
                                        <label class="form-label" for="total">{{ __('locale.Total') }}</label>
                                        <input type="number" id="total" name="total"
                                            class="form-control @error('total') border-danger @enderror" required readonly
                                            value="" x-model="total" value="{{old('total')}}"/>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-1">
                                        <label for="note" class="form-label">{{ __('locale.Note') }}</label>
                                        <input name="note" id="note" placeholder="{{ __('locale.Note') }}" class="form-control">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-1">
                                        <label for="mark" class="form-label">{{ __('locale.Mark') }}</label>
                                        <select id="mark" name="mark" required 
                                            class="form-select @error('mark') border-danger @enderror">
                                            <option value="">{{__('locale.Chose')}}</option>
                                            <option value="0"  
                                            @if(old('mark') == 0 ) selected @endif>{{ __('locale.None') }}</option>
                                            <option value="1" 
                                            @if(old('mark') == 1 ) selected @endif>{{ __('locale.Audited') }}</option>
                                            <option value="2" 
                                            @if(old('mark') == 2 ) selected @endif>{{ __('locale.Checked') }}</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-1">
                                        <label for="level" class="form-label">{{ __('locale.Level') }}</label>
                                        <select id="level" name="level" required 
                                            class="form-select @error('level') border-danger @enderror">
                                            <option value="">{{__('locale.Chose')}}</option>
                                            <option value="0"
                                            @if(old('level') == 0 ) selected @endif>{{ __('locale.None') }}</option>
                                            <option value="1"
                                            @if(old('level') == 1 ) selected @endif>{{ __('locale.Closed') }}</option>
                                            <option value="2"
                                            @if(old('level') == 2 ) selected @endif>{{ __('locale.Secret') }}</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <button typex="submit"
                                    class="btn btn-primary btn-sm w-25">{{ __('locale.Store') }}</button>
                                <button type="reset"
                                    class="btn btn-outline-primary btn-sm">{{ __('locale.Reset') }}</button>
                                <a
                                    href="{{ url('/') }}"class="btn btn-outline-dark btn-sm">{{ __('locale.Cancel') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
@endsection
