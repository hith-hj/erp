<form method="POST" action="{{route('purchase.addMaterial',['id'=>$purchase->id])}}">    
    @csrf
    <div x-data="{
        currencies: {{ $currencies->keyBy('id')->toJson() }},
        materials: {{ $materials->keyBy('id')->toJson() }},
    }" class="items-repeater">
        <div class="row">
            <div class="col-12">
                <div class="card">
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
                        <h4 class="card-title">{{ __('locale.New Material') }}
                        </h4>
                    </div>
                    <div class="card-body pb-0">
                        <div data-repeater-list="purchases">
                            <div data-repeater-item
                                x-data='{
                                material_id:0,
                                currency_id:0,
                                cost:0,
                                total:0,
                                materialUnits:{},
                                setMaterialUnits(id){
                                    this.materialUnits = this.materials[id].units;
                                },
                                setTotal(id){
                                    this.total = 0;
                                    return this.total = (this.cost * this.currencies[id].rate_to_default).toFixed(2);
                                },
                            }' class="row">
                                <div class="col-2">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="material_list">{{ __('locale.Materials') }}</label>
                                        <select x-model="material_id"
                                            id="material_list"
                                            name="material_id" required
                                            class="form-select"
                                            @error('material_id') border-danger @enderror
                                            x-init="$watch('material_id', value => setMaterialUnits(value))">
                                            <option value="">
                                                {{ __('locale.Chose') }}
                                            </option>
                                            @foreach ($materials as $material)
                                                <option
                                                    value="{{ $material->id }}"
                                                    {{ old('material_id') == $material->id ? 'selected' : '' }}>
                                                    {{ $material->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="material_quantity">{{ __('locale.Quantity') }}</label>
                                        <input type="number"
                                            id="material_quantity"
                                            name="quantity"
                                            class="form-control @error('quantity') border-danger @enderror"
                                            placeholder="{{ __('locale.Quantity') }}"
                                            value="{{ old('quantity') }}"
                                            required />
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="units_list">{{ __('locale.Units') }}</label>
                                        <select id="units_list" name="unit_id"
                                            class="form-select @error('unit_id') border-danger @enderror ">
                                            <option value="">
                                                {{ __('locale.Chose') }}
                                            </option>
                                            <template
                                                x-for="unit in materialUnits"
                                                :key="unit.id">
                                                <option :value="unit.id"
                                                    x-text="
                                                unit.name+'-'+unit.pivot.rate_to_main_unit+'-'+
                                                unit.pivot.is_default "
                                                    :selected="unit.pivot.is_default ==
                                                        1">
                                                </option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="cost">{{ __('locale.Cost') }}</label>
                                        <input type="number" id="cost"
                                            name="cost"
                                            class="form-control @error('cost') border-danger @enderror"
                                            placeholder="{{ __('locale.Cost') }}"
                                            value="{{ old('cost') }}"
                                            required x-model="cost" />
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="currency">
                                            {{ __('locale.Currency') }}
                                        </label>
                                        <select id="currency"
                                            name="currency_id" required
                                            x-model="currency_id"
                                            x-init="$watch('currency_id', value => setTotal(value))"
                                            class="form-select 
                                            @error('currency_id') border-danger @enderror">
                                            <option value="">
                                                {{ __('locale.Chose') }}
                                            </option>
                                            @foreach ($currencies as $currency)
                                                <option
                                                    value="{{ $currency->id }}"
                                                    {{ old('currency_id') == $currency->id || $currency->is_default == true ? 'selected' : '' }}>
                                                    {{ $currency->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-2">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="total">{{ __('locale.Total') }}</label>
                                        <input type="number" id="total"
                                            name="total"
                                            class="form-control
                                            @error('total') border-danger @enderror"
                                            required readonly value=""
                                            x-model="total"
                                            value="{{ old('total') }}" />
                                    </div>
                                </div>
                                <div class="col-12 pb-1">
                                    <button type="button"
                                        class="btn btn-danger w-100"
                                        data-repeater-delete>
                                        {{ __('locale.Delete') }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-6">
                        <button type="button" class="btn btn-primary w-100"
                            data-repeater-create>
                            {{ __('locale.Add') }}
                        </button>
                    </div>
                    <div class="col-6">
                        <button typex="submit" class="btn btn-primary">
                            {{ __('locale.Store') }}
                        </button>
                        <button type="reset"
                            class="btn btn-outline-primary">
                            {{ __('locale.Reset') }}
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
</form>

