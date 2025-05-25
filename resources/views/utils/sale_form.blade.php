<form id="sale_form" method="POST" action="{{ route('sale.store') }}" class="form form-vertical">
    @csrf
    <div class="items-repeater" x-data="{
        currency_id: 0,
        currencies: {{ $currencies->keyBy('id')->toJson() }},
        inventories: {{ $inventories->keyBy('id')->toJson() }},
        inventory_id: 0,
        inventoryMaterials: {},
        setInventoryMaterials(id) {
            this.inventoryMaterials = {};
            return this.inventoryMaterials = this.inventories[id].materials;
        },
    }">
        <button type="button" data-repeater-create hidden class="btn-addRow"></button>
        <div class="card mb-1">
            <div class="card-header p-0 px-1 pt-1">
                <h4>Basic info</h4>
            </div>
            <div class="card-body p-0 px-1">
                <div class="row">
                    <div class="col-3">
                        <div class="mb-1">
                            <label class="form-label" for="inventory_list">{{ __('locale.Inventory') }}</label>
                            <select id="inventory_list" name="inventory_id" x-model="inventory_id"
                                class="form-select @error('inventory_id') border-danger @enderror "
                                x-init="$watch('inventory_id', value => setInventoryMaterials(value))">
                                <option value="">{{ __('locale.Chose') }}</option>
                                @forelse ($inventories as $inventory)
                                    <option value="{{ $inventory->id }}">{{ $inventory->name }}</option>
                                @empty
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="mb-1">
                            <label class="form-label" for="client">{{ __('locale.Client') }}</label>
                            <select id="client" name="client_id" required
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
                    <div class="col-3">
                        <div class="mb-1">
                            <label class="form-label" for="currency">
                                {{ __('locale.Currency') }}
                            </label>
                            <select id="currency" name="currency_id" required x-model="currency_id"
                                class="form-select @error('currency_id') border-danger @enderror">
                                <option value="">{{ __('locale.Chose') }}</option>
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
                            <label class="form-label" for="discount">{{ __('locale.Discount') }}</label>
                            <input type="number" id="discount" name="discount"
                                class="form-control @error('discount') border-danger @enderror"
                                placeholder="{{ __('locale.Discount') }}" value="{{ old('discount') }}" />
                        </div>
                    </div>
                    
                    <div class="col-3">
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
                    <div class="col-3">
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
                    <div class="col-6">
                        <div class="mb-1">
                            <label for="note" class="form-label">{{ __('locale.Note') }}</label>
                            <input name="note" id="note" placeholder="{{ __('locale.Note') }}"
                                class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card mb-1">
            @if ($errors->any())
                <div class="alert alert-danger m-1">
                    <ul class="m-0">
                        @foreach ($errors->all() as $error)
                            <li class="pb-1">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="card-header p-0 px-1 py-1">
                <h4 class="card-title">{{ __('locale.Materials') }}</h4>
                <div class="d-flex align-items-center justify-content-end">
                    <h5 class="m-0">{{ __('locale.Rows count') }}</h5>
                    <input type="number" id="rowCount" min="1" value="5" max="30"
                        class="w-25 form-control form-control-sm mx-1"
                        onkeypress ="
                        if(event.which == 13) {
                            event.preventDefault();
                            addRowX($(this).val());
                        }">
                    <button type="button" class="btn btn-primary btn-sm" onclick="addRowX($('#rowCount').val())">
                        <i data-feather="plus"></i>
                    </button>
                </div>
            </div>
            <div class="card-body p-0 px-1">
                <table class="table table-sm mb-1">
                    <thead class="">
                        <tr>
                            <th>{{ __('locale.Materials') }}</th>
                            <th>{{ __('locale.Unit') }}</th>
                            <th>{{ __('locale.Quantity') }}</th>
                            <th>{{ __('locale.Cost') }}</th>
                            <th>{{ __('locale.Total') }}</th>
                            <th class="text-center"> - </th>
                        </tr>
                    </thead>
                    <tbody data-repeater-list="sales" id="sales_items_list"
                        onkeydown="
                    if(event.which == 13) {
                        event.preventDefault();
                    }">
                        <tr data-repeater-item
                            x-data='{
                            material_id:0,
                            cost:0,
                            total:0,
                            limit:0,
                            quantity:0,
                            materialUnits:{},
                            setMaterialUnits(id){
                                this.materialUnits = 0;
                                this.limit = 0;
                                Object.keys(this.inventoryMaterials).forEach(key => {
                                    if(this.inventoryMaterials[key].id == id){
                                        this.materialUnits = this.inventoryMaterials[key].units; 
                                        this.limit = Number(this.inventoryMaterials[key].pivot.quantity);
                                    }
                                })
                            },
                            setTotal(){
                                this.total = 0;
                                return this.total = this.quantity * (this.cost * this.currencies[this.currency_id].rate_to_default).toFixed(2);
                            },
                        }'>
                            <td id="first">
                                <select x-model="material_id" id="material_list" name="material_id" required
                                    class="form-select" @error('material_id') border-danger @enderror
                                    x-init="$watch('material_id', value => setMaterialUnits(value))">
                                    <option value="">{{ __('locale.Chose') }}</option>
                                    <template x-for="material in inventoryMaterials" :key="material.id">
                                        <option :value="material.id"
                                            x-text="material.name+' | '+material.pivot.quantity">
                                        </option>
                                    </template>
                                </select>
                            </td>
                            <td>
                                <select id="units_list" name="unit_id"
                                    class="form-select @error('unit_id') border-danger @enderror ">
                                    <option value="">{{ __('locale.Chose') }}</option>
                                    <template x-for="unit in materialUnits" :key="unit.id">
                                        <option x-bind:value="unit.id"
                                            x-text="unit.name+' '+unit.pivot.is_default+' '+unit.pivot.rate_to_main_unit"
                                            :selected="unit.pivot.is_default == 1">
                                        </option>
                                    </template>
                                </select>
                            </td>
                            <td>
                                <input type="number" id="material_quantity" name="quantity"
                                    class="form-control @error('quantity') border-danger @enderror"
                                    placeholder="{{ __('locale.Quantity') }}" value="{{ old('quantity') }}" required
                                    x-model="quantity" :class="quantity > limit ? 'border-danger' : ''" />
                            </td>
                            <td>
                                <input type="number" id="cost" name="cost"
                                    class="form-control @error('cost') border-danger @enderror"
                                    placeholder="{{ __('locale.Cost') }}" value="{{ old('cost') }}" required
                                    x-model="cost" x-init="$watch('cost', value => setTotal())"/>
                            </td>
                            <td>
                                <input type="number" id="total" name="total"
                                    class="form-control @error('total') border-danger @enderror" required readonly
                                    x-model="total" value="{{ old('total') }}" />
                            </td>
                            <td class="text-center cursor-pointer" data-repeater-delete>
                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round"
                                    class="feather feather-trash text-danger">
                                    <polyline points="3 6 5 6 21 6"></polyline>
                                    <path
                                        d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2">
                                    </path>
                                </svg>
                            </td>
                        </tr>

                    </tbody>
                </table>
            </div>
        </div>
        <div class="card mb-1">
            <div class="card-body p-1">
                <div class="col-12">
                    <button typex="submit" class="btn btn-primary w-50">
                        {{ __('locale.Store') }}
                    </button>
                    {{-- <button type="reset" class="btn btn-outline-primary">
                        {{ __('locale.Reset') }}
                    </button> --}}
                    <a class="btn btn-outline-dark">
                        {{ __('locale.Cancel') }}
                    </a>
                </div>
            </div>
        </div>
    </div>
</form>
