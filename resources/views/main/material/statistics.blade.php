@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.Material statistics') }}
@endsection

@section('content')
<section id="card-content-types">
<div class="row">
    <div class="col-12">
        <h4 class=""> {{ __('locale.Select material') }} </h4>
        <div class="card">
            <div class="card-header">                
                <form id="deleteMaterialForm" method="Post"
                    action="{{ route('material.getStatistics') }}"
                    class="row g-2 align-items-end col-12"
                    x-data="{
                        material_id: '',
                        inventories: {},
                        materials: {{ $materials->keyBy('id')->toJson() }},
                        setInventories(id){
                            if(!id){
                                this.inventories = {};
                            } else {
                                this.materials[id] ? this.inventories = this.materials[id].inventories : this.inventories = {};
                            }
                        },
                    }">
                    @csrf 
                    
                    <!-- Material Input Group -->
                    <div class="col-12">
                        <label for="material" class="form-label font-weight-bold">
                            {{ __('locale.Material') }}
                        </label>
                        <input list="materials" 
                            x-model="material_id" 
                            name="material_id" 
                            id="material" 
                            class="form-control"
                            required
                            x-init="$watch('material_id', value => setInventories(value))"
                            placeholder="Select material">
                        
                        <datalist id="materials">
                            <option value="">{{ __('locale.Chose') }}</option>
                            @foreach($materials as $material)
                                <option value="{{$material->id}}">{{$material->name}}</option>
                            @endforeach
                        </datalist>
                    </div>

                    <!-- Inventory Dropdown Group -->
                    <div class="col-12">
                        <label for="inventories" class="form-label font-weight-bold">
                            {{ __('locale.Inventory') }}
                        </label>
                        <select id="inventories" name="inventories[]" class="form-select form-control" multiple
                        style="appearance: base-select;">
                            <template x-for="inventory in inventories" :key="inventory.id">
                                <option :value="inventory.id" 
                                        x-text="inventory.name"
                                        :selected="inventory.is_default == 1">
                                </option>
                            </template>
                        </select>
                    </div>

                    <div class="col-12">
                        <button class="btn btn-outline-success w-50" type="submit">
                            {{ __('locale.Search') }}
                        </button>
                        @if(isset($result))
                            <a href="{{ route('material.statistics') }}" class="">
                                <button class="btn btn-outline-info " type="button">
                                    {{ __('locale.Reset') }}
                                </button>
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </div>
    </div>
</div> 

@if(isset($result))
<div class="row">
    <div class="col-12">
        <div class="table-responsive">
            <h3>{{ __('locale.Stats') }}</h3>
            <div class="card">
                @if(count($result['collection']) == 0)
                    <div class="card-header">
                        <div class="card-text">
                            <h3 class="text-danger">
                                {{__('locale.Nothing found')}}
                            </h3>
                        </div>
                    </div>
                @else
                    <div class="card-body">
                        @if($result['withInventories'])
                            @forelse($result['collection'] as $inventory => $stats)
                                <h1 class="mt-2">{{ $inventory }}</h1>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>{{ __('locale.Date') }}</th>
                                            <th>{{ __('locale.Type') }}</th>
                                            <th>{{ __('locale.Quantity') }}</th>
                                            <th>{{ __('locale.Cost') }}</th>
                                            <th>{{ __('locale.Currency') }}</th>
                                            <th>{{ __('locale.Rate') }}</th>
                                            <th>{{ __('locale.Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                        @forelse ($stats as $stat)
                                            <tr>
                                                <td> {{ $loop->index + 1}} </td>
                                                <td> {{ $stat['date'] }} </td>
                                                <td>
                                                    <a href="{{route('bill.show',['id'=>$stat['bill_id']])}}" target="__blank">
                                                        {{ $stat['bill_type'] }}
                                                    </a>
                                                </td>
                                                <td> {{ $stat['quantity'] }} </td>
                                                <td> {{ $stat['price'] }} </td>
                                                <td> {{ $stat['currency'] }} </td>
                                                <td> {{ $stat['rate'] }} </td>
                                                <td> {{ $stat['total'] }} </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td>
                                                    {{__('locale.Not found')}}
                                                </td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                </table>
                            @empty
                                <h3 class="text-danger">
                                    {{__('locale.Nothing found')}}
                                </h3>
                            @endforelse
                        @else
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>{{ __('locale.Date') }}</th>
                                        <th>{{ __('locale.Type') }}</th>
                                        <th>{{ __('locale.Quantity') }}</th>
                                        <th>{{ __('locale.Cost') }}</th>
                                        <th>{{ __('locale.Currency') }}</th>
                                        <th>{{ __('locale.Rate') }}</th>
                                        <th>{{ __('locale.Total') }}</th>
                                    </tr>
                                </thead>
                                <tbody class="table-hover">
                                    @forelse ($result['collection'] as $stat)
                                        <tr>
                                            <td> {{ $loop->index + 1}} </td>
                                            <td> {{ $stat['date'] }} </td>
                                            <td>
                                                <a href="{{route('bill.show',['id'=>$stat['bill_id']])}}" target="__blank">
                                                    {{ $stat['bill_type'] }}
                                                </a>
                                            </td>
                                            <td> {{ $stat['quantity'] }} </td>
                                            <td> {{ $stat['price'] }} </td>
                                            <td> {{ $stat['currency'] }} </td>
                                            <td> {{ $stat['rate'] }} </td>
                                            <td> {{ $stat['total'] }} </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td>
                                                {{__('locale.Not found')}}
                                            </td>
                                        </tr>
                                    @endforelse

                                </tbody>
                            </table>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endif
</section>
@endsection