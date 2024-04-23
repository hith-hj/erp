<!-- Edit User Modal -->
<div class="modal fade" id="addItem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content" x-data="{
            currencies: {{ $currencies->keyBy('id')->toJson() }},
        }">
            {{-- <div class="modal-header bg-transparent">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div> --}}
            <div class="modal-body">
                <form id="purchase_form" method="POST" action="{{ route('purchase.store') }}" class="form form-vertical">
                    @csrf
                    <input type="hidden" name="bill_id" value="{{ $bill->id }}">
                    <div x-data="{
                        currencies: {{ $currencies->keyBy('id')->toJson() }},
                        materials: {{ $materials->keyBy('id')->toJson() }}
                    }" class="purchases-repeater">
                        
                        <div data-repeater-list="purchases" class="row">
                            <div data-repeater-item class="col-12">
                                <div class="card"
                                    x-data='
                                    {
                                        material_id:0,
                                        currency_id:0,
                                        rate_to:0,
                                        cost:0,
                                        total:0,
                                        materialUnits:{},
                                        currencyRates:{},
                                        setMaterialUnits(id){
                                            this.materialUnits = this.materials[id].units;
                                        },
                                        setCurrencyRates(id){
                                            this.currencyRates = this.currencies[id].rates;
                                        },
                                        setTotal(id){
                                            this.total = 0;
                                            Object.keys(this.currencyRates).forEach(rate => {
                                                if(this.currencyRates[rate].id == id)
                                                {
                                                    return this.total = (this.cost * this.currencyRates[rate].pivot.rate).toFixed(4);
                                                }
                                            }) 
                                        },
                                    }'>
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
                                        <h4 class="card-title">{{ __('locale.New Sale') }}</h4>
                                    </div>
                                    <div class="card-body pb-0">
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="client">{{ __('locale.Client') }}</label>
                                                    <select id="client" name="client" required
                                                        class="form-select @error('client') border-danger @enderror">
                                                        <option value="">{{ __('locale.Chose') }}</option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->id }}">
                                                                {{ $client->full_name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="discount">{{ __('locale.Discount') }}</label>
                                                    <input type="number" id="discount" name="discount"
                                                        class="form-control @error('discount') border-danger @enderror"
                                                        placeholder="{{ __('locale.Discount') }}" value="{{ old('discount') }}" />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="inventory_list">{{ __('locale.Inventory') }}</label>
                                                    <select id="inventory_list" name="inventory_id" required class="form-select"
                                                        @error('inventory_id') border-danger @enderror>
                                                        <option value="">{{ __('locale.Chose') }}</option>
                                                        @foreach ($inventories as $inventory)
                                                            <option value="{{ $inventory->id }}"
                                                                @if (old('inventory_id') == $inventory->id) selected @endif>
                                                                {{ $inventory->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="material_list">{{ __('locale.Materials') }}</label>
                                                    <select x-model="material_id" id="material_list" name="material_id" required
                                                        class="form-select" @error('material_id') border-danger @enderror
                                                        x-init="$watch('material_id', value => setMaterialUnits(value))">
                                                        <option value="">{{ __('locale.Chose') }}</option>
                                                        @foreach ($materials as $material)
                                                            <option value="{{ $material->id }}"
                                                                @if (old('material_id') == $material->id) selected @endif>
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
                                                        placeholder="{{ __('locale.Quantity') }}" value="{{ old('quantity') }}"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="units_list">{{ __('locale.Units') }}</label>
                                                    <select id="units_list" name="unit_id" required
                                                        class="form-select @error('unit_id') border-danger @enderror ">
                                                        <option value="">{{ __('locale.Chose') }}</option>
                                                        <template x-for="unit in materialUnits" :key="unit.id">
                                                            <option x-bind:value="unit.id" x-text="unit.name"></option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="cost">{{ __('locale.Cost') }}</label>
                                                    <input type="number" id="cost" name="cost"
                                                        class="form-control @error('cost') border-danger @enderror"
                                                        placeholder="{{ __('locale.Cost') }}" value="{{ old('cost') }}" required
                                                        x-model="cost" />
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="currency">{{ __('locale.Currency') }}</label>
                                                    <select id="currency" name="currency_id" required x-model="currency_id"
                                                        x-init="$watch('currency_id', value => setCurrencyRates(value))"
                                                        class="form-select @error('currency_id') border-danger @enderror">
                                                        <option value="">{{ __('locale.Chose') }}</option>
                                                        @foreach ($currencies as $currency)
                                                            <option value="{{ $currency->id }}"
                                                                @if (old('currency_id') == $currency->id) selected @endif>
                                                                {{ $currency->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="rate_to">{{ __('locale.Rate') }}</label>
                                                    <select x-model="rate_to" name="rate_to"
                                                        class="form-select @error('rate_to') border-danger @enderror"
                                                        x-init="$watch('rate_to', value => setTotal(value))" required>
                                                        <option value="">{{ __('locale.Chose') }}</option>
                                                        <template x-for="(rate,index) in currencyRates" :key="rate.id">
                                                            <option x-bind:value="rate.id" x-text="rate.name">
                                                            </option>
                                                        </template>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="total">{{ __('locale.Total') }}</label>
                                                    <input type="number" id="total" name="total"
                                                        class="form-control @error('total') border-danger @enderror" required readonly
                                                        value="" x-model="total" value="{{ old('total') }}" />
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-1">
                                                    <label for="note" class="form-label">{{ __('locale.Note') }}</label>
                                                    <input name="note" id="note" placeholder="{{ __('locale.Note') }}"
                                                        class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-1">
                                                    <label for="mark" class="form-label">{{ __('locale.Mark') }}</label>
                                                    <select id="mark" name="mark" required
                                                        class="form-select @error('mark') border-danger @enderror">
                                                        <option value="">{{ __('locale.Chose') }}</option>
                                                        <option value="0" @if (old('mark') == 0) selected @endif>
                                                            {{ __('locale.None') }}
                                                        </option>
                                                        <option value="1" @if (old('mark') == 1) selected @endif>
                                                            {{ __('locale.Audited') }}
                                                        </option>
                                                        <option value="2" @if (old('mark') == 2) selected @endif>
                                                            {{ __('locale.Checked') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-1">
                                                    <label for="level" class="form-label">{{ __('locale.Level') }}</label>
                                                    <select id="level" name="level" required
                                                        class="form-select @error('level') border-danger @enderror">
                                                        <option value="">
                                                            {{ __('locale.Chose') }}
                                                        </option>
                                                        <option value="0" @if (old('level') == 0) selected @endif>
                                                            {{ __('locale.None') }}
                                                        </option>
                                                        <option value="1" @if (old('level') == 1) selected @endif>
                                                            {{ __('locale.Closed') }}
                                                        </option>
                                                        <option value="2" @if (old('level') == 2) selected @endif>
                                                            {{ __('locale.Secret') }}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 p-1">
                                        <button type="button" class="btn btn-danger w-100" data-repeater-delete>
                                            {{__('locale.Delete')}}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-primary w-100" data-repeater-create>
                                            {{__('locale.Add')}}
                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button typex="submit"
                                            class="btn btn-primary w-25">
                                            {{ __('locale.Store') }}
                                        </button>
                                        <button type="reset"
                                            class="btn btn-outline-primary">
                                            {{ __('locale.Reset') }}
                                        </button>
                                        <a href="{{ url('/') }}"class="btn btn-outline-dark">
                                            {{ __('locale.Cancel') }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
