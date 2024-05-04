@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.New Currency') }}
@endsection

@section('content')

<section id="multiple-column-form">
    <form id="inventory_form" method="POST" action="{{ route('currency.store') }}" class="form form-vertical">
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
                        <h4 class="card-title">{{ __('locale.New Currency') }}</h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="fullname">{{ __('locale.Name') }}</label>
                                    <input type="text" id="name"
                                        class="form-control @error('name') border-danger @enderror" name="name"
                                        placeholder="{{ __('locale.Name') }}" value="{{ old('name') }}" required
                                        tabindex="1" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="code">{{ __('locale.Code') }}</label>
                                    <input type="text" id="code"
                                        class="form-control @error('code') border-danger @enderror" name="code"
                                        placeholder="{{ __('locale.Code') }}" value="{{ old('code') }}" required
                                        tabindex="1" />
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
@section('vendor-script')
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>
@endsection
@section('page-script')
<script src="{{ asset(mix('js/scripts/forms/form-select2.js')) }}"></script>
@endsection
