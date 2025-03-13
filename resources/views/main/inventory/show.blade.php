@extends('layouts.tableLayout')

@section('title')
    {{ __('locale.Inventory') . ' - ' . $inventory->name }}
@endsection

@section('content')
    
    <section id="basic-datatable">
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
                    <div class="card-header p-1 d-flex">
                        <div class="div">
                            <h3>{{$inventory->name}}</h3>
                            {{__('locale.Materials') . ':' . $inventory->materials()->count()}}
                        </div>
                        <div class="div d-flex gap-1">
                            @if($inventory->is_default == true)
                                <span class="badge badge-light-info">
                                    {{__('locale.Default')}}
                                </span>
                            @else
                                <button class="btn btn-sm btn-outline-info" form="setDefaultInventroyForm">
                                    {{__('locale.Default')}}
                                </button>
                                <form action="{{route('inventory.setDefault',['id'=>$inventory->id])}}" 
                                    id="setDefaultInventroyForm" method="post">
                                    @csrf
                                </form>
                            @endif
                            <button class="btn btn-sm btn-outline-primary" type="button" data-bs-toggle="modal"
                                data-bs-target="#addTransfer{{ $inventory->id }}">
                                {{ __('locale.Add').' '.__('locale.Material') }}
                            </button>
                            <div class="modal fade" id="addTransfer{{ $inventory->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-sm modal-dialog-centered modal-edit-user">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h4>Material and quantity</h4>
                                        </div>
                                        <div class="modal-body ">
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
                                                                    <button type="button" class="btn btn-icon btn-outline-danger w-100 ">
                                                                        <i class="fa fa-trash"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-2 p-0" data-repeater-create>
                                                        <div class="mb-1">
                                                            <label class="form-label" for="rate">{{ __('locale.Add') }}</label>
                                                            <button type="button" class="btn btn-icon btn-outline-primary w-100">
                                                                <i class="fa fa-plus "></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="">
                                                    <button type="submit"
                                                        class="btn btn-outline-primary w-50">{{ __('locale.Store') }}
                                                    </button>
                                                    <button type="reset"
                                                        class="btn btn-outline-dark w-25">{{ __('locale.Reset') }}
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
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
                        $(this).slideUp(deleteElement);
                        // if (confirm(
                        //     "{{ __('Are you sure you want to delete this element?') }}"
                        // )) {
                        //     $(this).slideUp(deleteElement);
                        // }
                    },

                });
            });
        });
    </script>
@endpush
