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
        <div class="card-body">
            <div class="row">
                <h4>{{ __('locale.Add') }} {{ __('locale.Material') }}</h4>
                <form method="POST" action="{{ route('inventory.material.store', ['inventory_id' => $inventory->id]) }}">
                    @csrf
                    <div class="col-12 row inventory-materials-repeater">
                        <div data-repeater-list="materials" class="col-10">
                            <div data-repeater-item class="row">
                                <div class="col-5">
                                    <div class="mb-1">
                                        <label class="form-label" for="phone_number">{{ __('locale.Materials') }}</label>
                                        <select id="material_list" name="material_id" class="form-select" required>
                                            <option value="">Chose Material</option>
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
                                        <label class="form-label" for="phone_number">{{ __('locale.Quantity') }}</label>
                                        <input type="number" name="quantity" id="material_quantity"
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
                    <div class="card-header">
                        <h4>{{ __('locale.Materials') }}</h4>
                    </div>
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
