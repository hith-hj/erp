@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.New Bill') }}
@endsection
@section('content')
    <section id="multiple-column-form" >
        <form id="inventory_form" method="POST" action="{{ route('bill.store') }}" class="form form-vertical">
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
                            <h4 class="card-title">{{ __('locale.New Bill') }}</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="type">{{ __('locale.Type') }}</label>
                                        <select id="type" name="type" required class="form-select" >
                                            <option value="">{{__('locale.Chose')}}</option>
                                            <option value="1">{{__('locale.Purchase')}}</option>
                                            <option value="2">{{__('locale.Sale')}}</option>
                                        </select>
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
