@extends('layouts.tableLayout')

@section('title')
    {{ __('locale.Inventory') . ' - ' . $inventory->name }}
@endsection

@section('content')
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
        <div class="card-header pb-0 d-flex">
            <div class="div">
                <h3>{{$inventory->name}}</h3>
            </div>
            <div class="div">
                @if($inventory->is_default == true)
                    <span class="badge  badge-light-success">
                        {{__('locale.Default')}}
                    </span>
                @else
                    <button class="btn btn-outline-info" form="setDefaultInventroyForm">
                        {{__('locale.Default')}}
                    </button>
                    <form action="{{route('inventory.setDefault',['id'=>$inventory->id])}}" 
                        id="setDefaultInventroyForm" method="post">
                        @csrf
                    </form>
                @endif
            </div>
        </div>
        <div class="card-body">
            <h4>{{ __('locale.Add') }} {{ __('locale.Material') }}</h4>
            <div class="row">
                <form method="POST" action="{{ route('inventory.material.store', ['inventory_id' => $inventory->id]) }}">
                    @csrf
                    <div class="row px-1 inventory-materials-repeater">
                        <div data-repeater-list="materials" class="col-10 p-0">
                            <div data-repeater-item class="row">
                                <div class="col-5">
                                    <div class="mb-1">
                                        <label class="form-label" for="">
                                            {{ __('locale.Materials') }}
                                        </label>
                                        <select id="material_list" name="material_id" 
                                            class="form-select" required>
                                            <option value="">{{__('locale.Chose')}}</option>
                                            @foreach ($materials as $material)
                                                <option value="{{ $material->id }}">
                                                    {{ $material->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-5">
                                    <div class="mb-1">
                                        <label class="form-label" for="">
                                            {{ __('locale.Quantity') }}
                                        </label>
                                        <input type="number" min="1" name="quantity" id="material_quantity"
                                            class="form-control @error('quantity') border-danger @enderror"
                                            placeholder="{{ __('locale.Quantity') }}" required />
                                    </div>
                                </div>
                                <div class="col-2 p-0" data-repeater-delete>
                                    <div class="mb-1">
                                        <label class="form-label" for="rate">{{ __('locale.Delete') }}</label>
                                        <button type="button" class="btn btn-icon btn-danger w-100">
                                            <span>{{ __('locale.Delete') }}</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 p-0" data-repeater-create>
                            <div class="mb-1">
                                <label class="form-label" for="rate">{{ __('locale.Add') }}</label>
                                <button type="button" class="btn btn-icon btn-outline-primary w-100">
                                    <span>{{ __('locale.Add') }}</span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <button  type="submit"
                            class="btn btn-primary w-100">{{ __('locale.Store') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <script>
        $(document).ready(function() {
            $(function() {
                'use strict';
                // form repeater jquery
                $('.inventory-materials-repeater').repeater({
                    isFirstItemUndeletable: true,
                    initEmpty: false,
                    show: function() {
                        $(this).slideDown();
                    },
                    hide: function(deleteElement) {
                        if (confirm(
                                "{{ __('Are you sure you want to delete this element?') }}"
                            )) {
                            $(this).slideUp(deleteElement);
                        }
                    },

                });
            });
        });
    </script>
@endpush
