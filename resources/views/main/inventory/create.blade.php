@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.New Inventory') }}
@endsection

@section('content')
    <section id="multiple-column-form">
        <form id="inventory_form" method="POST" action="{{ route('inventory.store') }}" class="form form-vertical">
            @csrf
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
                        <div class="card-header">
                            <h4 class="card-title">{{ __('locale.New Inventory') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="fullname">{{ __('locale.Name') }}</label>
                                        <input type="text" id="name" name="name" required
                                            class="form-control @error('name') border-danger @enderror"
                                            placeholder="{{ __('locale.Name') }}" value="{{ old('name') }}" />
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label"> 
                                            {{__('locale.Set as default')}} 
                                        </label>
                                        <div class="d-flex align-items-center">
                                            <div class="form-check form-switch form-check-success">
                                                <input type="checkbox" class="form-check-input" id="defaultInventory"
                                                    style="width:10rem" name="is_default" value="true"
                                                    placeholder="{{ __('locale.Name') }}">
                                                <label class="form-check-label" for="defaultInventory">
                                                    <span class="switch-icon-left px-1">
                                                        {{__('locale.Is Default')}}
                                                    </span>
                                                    <span class="switch-icon-right px-1">
                                                        {{__('locale.Not default')}}
                                                    </span>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <h4>{{ __('locale.New Materials') }}</h4>
                                <div class="col-12 row inventory-materials-repeater">
                                    <div data-repeater-list="materials" class="col-10">
                                        <div data-repeater-item class="row">
                                            <div class="col-5">
                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="phone_number">{{ __('locale.Materials') }}</label>
                                                    <select id="material_list" name="material_id" class="form-select"
                                                        required>
                                                        <option value="">{{__('locale.Chose')}}</option>
                                                        @foreach ($materials as $material)
                                                            @if ($material->type == 1 || ($material->type == 2 && $material->manufactureModel->count() > 0))
                                                                <option value="{{ $material->id }}">
                                                                    {{ $material->name }}
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-5">
                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="phone_number">{{ __('locale.Quantity') }}</label>
                                                    <input type="number" name="quantity" id="material_quantity"
                                                        class="form-control @error('quantity') border-danger @enderror"
                                                        placeholder="{{ __('locale.Quantity') }}" required />
                                                </div>
                                            </div>
                                            <div class="col-2" data-repeater-delete>
                                                <div class="mb-1">
                                                    <label class="form-label"
                                                        for="rate">{{ __('locale.Delete') }}</label>
                                                    <button type="button" class="btn btn-icon btn-danger w-100">
                                                        <span>{{ __('locale.Delete') }}</span>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-2" data-repeater-create>
                                        <div class="mb-1">
                                            <label class="form-label" for="rate">{{ __('locale.Add') }}</label>
                                            <button type="button" class="btn btn-icon btn-primary w-100">
                                                <span>{{ __('locale.Add') }}</span>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <button type="submit"
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
@section('page-script')
    <!-- Page js files -->
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
@endsection
