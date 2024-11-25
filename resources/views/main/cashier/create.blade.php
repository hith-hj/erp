@extends('layouts/contentLayoutMaster')
@section('title')
    {{ __('locale.New Cashier') }}
@endsection

@section('content')
    <section>
        <form method="POST" action="{{ route('cashier.store') }}" class="form form-vertical">
            @csrf
            <div class="card row">
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
                    <h4 class="card-title">{{ __('locale.New Cashier') }}</h4>
                </div>
                <div class="card-body col-12 row">
                    <div class="col-12">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="name">{{ __('locale.Name') }}</label>
                                    <input type="text" name="name" id="name"
                                        class="form-control @error('name') border-danger @enderror" 
                                        placeholder="{{ __('locale.Name') }}" 
                                        value="{{ old('name') }}" required  />
                                </div>
                            </div>
                            <div class="col-6">
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
                        </div>
                    </div>
                    <div class="col-12 ">
                        <button type="submit" class="btn btn-primary btn-sm w-50">
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
        </form>
    </section>
@endsection
@section('page-script')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <script>
        $(document).ready(function() {
            $(function() {
                'use strict';
                // form repeater jquery
                $('.clients-repeater').repeater({
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
