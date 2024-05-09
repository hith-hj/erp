@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.New Manufacturing') }}
@endsection
@section('content')
    <section id="multiple-column-form">
        <form id="inventory_form" method="POST" action="{{ route('manufacturing.store') }}" class="form form-vertical">
            @csrf
            <div class="row" x-data="{
                materials:{{$materials->keyBy('id')->toJson()}},
                material_id:0,
                materialUnits:{},
                setMaterialUnits(id){
                    this.materialUnits = this.materials[id].units;
                    console.log(this.materials,this.materialUnits);
                },
            }">
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
                        <div class="card-header">
                            <h4 class="card-title">{{ __('locale.New Manufacturing') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-lable">
                                            {{__('locale.Inventory')}}
                                        </label>
                                        <select name="inventory_id" class="form-select">
                                            <option value="">{{__('locale.Chose')}}</option>
                                            @forelse ($inventories as $inventory)
                                                <option value="{{$inventory->id}}" 
                                                    @if(old('inventory_id') == $inventory->id) selected @endif>
                                                    {{$inventory->name}}
                                                </option>
                                            @empty
                                                
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-lable">
                                            {{__('locale.Material')}}
                                        </label>
                                        <select name="material_id" class="form-select"
                                            x-model="material_id" required
                                            x-init="$watch('material_id', value => setMaterialUnits(value))">
                                            <option value="">{{__('locale.Chose')}}</option>
                                            @forelse ($materials as $material)
                                                {{-- @if($material->hasManufactureModel()) --}}
                                                    <option value="{{$material->id}}"
                                                        @if(old('material_id') == $inventory->id) selected @endif>
                                                        {{$material->name}}
                                                    </option>
                                                {{-- @endif --}}
                                            @empty                                                
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-lable">
                                            {{__('locale.Quantity')}}
                                        </label>
                                        <input type="number" name="quantity" class="form-control" 
                                        value="{{old('quantity')}}">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-lable">
                                            {{__('locale.Unit')}}
                                        </label>
                                        <select name="unit_id" class="form-select">
                                            <option value="">{{__('locale.Chose')}}</option>
                                            <template x-for="unit in materialUnits" :key="unit.id">
                                                <option x-bind:value="unit.id" 
                                                x-text="unit.name+' '+unit.code"
                                                @if(old('unit_id') == $inventory->id) selected @endif></option>
                                            </template>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit" class="btn btn-primary btn-sm w-25">
                                    {{ __('locale.Store') }}
                                </button>
                                <button type="reset" class="btn btn-outline-primary btn-sm">
                                    {{ __('locale.Reset') }}
                                </button>
                                <a href="{{ url('/') }}" class="btn btn-outline-dark btn-sm">
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
@section('vendor-script')
    <script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
    <script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
@endsection
