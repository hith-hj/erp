<form id="sale_form" method="POST" action="{{ route('sale.addMaterial',['id'=> $sale->id]) }}" class="form form-vertical">
    @csrf
    <div class="items-repeater" x-data="{
        currencies: {{ $currencies->keyBy('id')->toJson() }},
        materials: {{$sale->inventory->materials->keyBy('id')->toJson()}}
    }">
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
            <div class="card-header p-0 px-1 pt-1">
                <h4 class="card-title">{{ __('locale.Materials') }}</h4>
            </div>
            <div class="card-body p-0 px-1">
                <div data-repeater-list="sales">
                    <div data-repeater-item class="row" x-data='{
                        material_id:0,
                        currency_id:{{$sale->currency_id}},
                        cost:0,
                        total:0,
                        limit:0,
                        quantity:0,
                        materialUnits:{},
                        setMaterialUnits(id){
                            this.materialUnits = 0;
                            this.limit = 0;
                            Object.keys(this.materials).forEach(key => {
                                if(this.materials[key].id == id){
                                    this.materialUnits = this.materials[key].units; 
                                    this.limit = Number(this.materials[key].pivot.quantity);
                                }
                            })
                        },
                        setTotal(){
                            this.total = 0;
                            return this.total = this.quantity * (this.cost * this.currencies[this.currency_id].rate_to_default).toFixed(2);
                        },
                    }'>
                        <div class="col-2">
                            <div class="mb-1">
                                <label class="form-label"
                                    for="material_list">{{ __('locale.Material') }}</label>
                                <select x-model="material_id" id="material_list" name="material_id" required
                                    class="form-select" @error('material_id') border-danger @enderror
                                    x-init="$watch('material_id', value => setMaterialUnits(value))">
                                    <option value="">{{ __('locale.Chose') }}</option>
                                    @forelse($sale->inventory->materials as $material)
                                        <option value="{{$material->id}}">
                                            {{ $material->name.' | '.$material->pivot->quantity}}
                                        </option>
                                    @empty
                                    @endforelse
                                </select>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-1">
                                <label class="form-label" for="units_list">{{ __('locale.Units') }}</label>
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
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-1">
                                <label class="form-label" for="material_quantity"
                                    x-text="quantity > limit ?
                                    'Limit Excieded':'{{ __('locale.Quantity') }}' ">
                                </label>
                                <input type="number" id="material_quantity" name="quantity"
                                    class="form-control @error('quantity') border-danger @enderror"
                                    placeholder="{{ __('locale.Quantity') }}" value="{{ old('quantity') }}"
                                    required x-model="quantity"
                                    :class="quantity > limit ? 'border-danger' : ''" />
                            </div>
                        </div>
                        
                        <div class="col-2">
                            <div class="mb-1">
                                <label class="form-label" for="cost">{{ __('locale.Cost') }}</label>
                                <input type="number" id="cost" name="cost"
                                    class="form-control @error('cost') border-danger @enderror"
                                    placeholder="{{ __('locale.Cost') }}" value="{{ old('cost') }}"
                                    required x-model="cost" 
                                    x-init="$watch('cost', value => setTotal(value))"/>
                            </div>
                        </div>
                        <div class="col-2">
                            <div class="mb-1">
                                <label class="form-label" for="total">{{ __('locale.Total') }}</label>
                                <input type="number" id="total" name="total"
                                    class="form-control @error('total') border-danger @enderror" required
                                    readonly value="" x-model="total" value="{{ old('total') }}" />
                            </div>
                        </div>
                        <div class="col-2" data-repeater-delete>
                            <div class="mb-1">
                                <label for="" class="form-label">{{__('locale.Options')}}</label>
                                <button type="button" class="btn btn-danger w-100">
                                    {{ __('locale.Delete') }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 row">
                    <div class="col-6">
                        <button type="button" class="btn btn-outline-primary w-100" data-repeater-create>
                            {{ __('locale.Add') }}
                        </button>
                    </div>
                    <div class="col-6">
                        <button type="submit" class="btn btn-primary w-50">
                            {{__('locale.Store')}}
                        </button>
                    </div>
                </div>
            </div>            
            
        </div>
    </div>
</form>