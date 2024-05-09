@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.New Material') }}
@endsection

@section('content')
@section('vendor-style')
    <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
@endsection

<section id="multiple-column-form">
    <form method="POST" action="{{ route('material.store') }}" class="form form-vertical">
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
                        <h4 class="card-title">{{ __('locale.New Material') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="fullname">{{ __('locale.Name') }}</label>
                                        <input type="text" id="name" name="name" required
                                            class="form-control @error('name') border-danger @enderror" 
                                            placeholder="{{ __('locale.Name') }}" value="{{ old('name') }}" 
                                         />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="type">{{ __('locale.Type') }}</label>
                                        <select name="type" id="type"required
                                            class="form-select @error('type') border-danger @enderror">
                                            <option value="1">{{ __('locale.Base') }}</option>
                                            <option value="2">{{ __('locale.Manufactured') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="main">
                                            {{ __('locale.Main material') }}
                                        </label>
                                        <select name="main_material" id="main"
                                            class="form-select @error('main') border-danger @enderror">
                                            <option value="">{{ __('locale.None') }}</option>
                                            @forelse ($materials as $material)
                                                <option value="{{ $material->id }}">{{ $material->name }}</option>
                                            @empty
                                                <option value="">{{ __('locale.None') }}</option>
                                            @endforelse
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="main_unit">
                                            {{ __('locale.Main unit') }}
                                        </label>
                                        <select name="main_unit" id="main_unit" required
                                            class="form-select @error('main_unit') border-danger @enderror">
                                            @foreach ($units as $unit)
                                                <option value="{{ $unit->id }}">
                                                    {{ $unit->code }} - {{ __('locale.' . $unit->name) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row units-rates-repeater">
                                <div data-repeater-list="units" class="col-10">
                                    <div data-repeater-item class="row">
                                        <div class="col-5">
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="phone_number">{{ __('locale.Units') }}</label>
                                                <select name="unit" required
                                                    class="form-select @error('units') border-danger @enderror">
                                                    @foreach ($units as $unit)
                                                        <option value="{{ $unit->id }}">
                                                            {{ $unit->code }} -
                                                            {{ $unit->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="rate">{{ __('locale.Rate') }}</label>
                                                <input type="number" id="rate" step="0.001" min="0.001" max="1000"
                                                    class="form-control @error('rate') border-danger @enderror"
                                                    name="rate" placeholder="{{ __('locale.Rate') }}"
                                                    value="{{ old('rate') }}" required />
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
                    </div>
                    <div class="p-1 pt-0">
                        <button type="submit" class="btn btn-primary btn-sm w-25">
                            {{ __('locale.Store') }}
                        </button>
                        <button type="reset" class="btn btn-outline-primary btn-sm">
                            {{ __('locale.Reset') }}
                        </button>
                        <a href="{{ url('/') }}"class="btn btn-outline-dark btn-sm">
                            {{ __('locale.Cancel') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection
@section('vendor-script')
<!-- vendor files -->
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
<!-- Page js files -->
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            'use strict';
            // form repeater jquery
            $('.units-rates-repeater').repeater({
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
