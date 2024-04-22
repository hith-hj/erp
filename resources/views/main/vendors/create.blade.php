@extends('layouts/contentLayoutMaster')
@section('title')
    {{ __('locale.New vendor') }}
@endsection
@section('vendor-style')
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
@endsection

@section('content')
    <section>
        <form method="POST" action="{{ route('vendor.store') }}" class="form form-vertical">
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
                    <h4 class="card-title">{{ __('locale.New vendor') }}</h4>
                </div>
                <div class="card-body col-12 row vendors-repeater">
                    <div data-repeater-list="vendors" class="col-12">
                        <div data-repeater-item class="row">
                            <div class="col-6">
                                <div class="mb-6">
                                    <label class="form-label" for="first_name">{{ __('locale.First name') }}</label>
                                    <input type="text" name="first_name" id="first_name"
                                        class="form-control @error('first_name') border-danger @enderror" 
                                        placeholder="{{ __('locale.First name') }}" 
                                        value="{{ old('first_name') }}" required  />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="last_name">{{ __('locale.Last name') }}</label>
                                    <input type="text" name="last_name" id="last_name"
                                        class="form-control @error('last_name') border-danger @enderror" 
                                        placeholder="{{ __('locale.Last name') }}" 
                                        value="{{ old('last_name') }}" required  />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="phone">{{ __('locale.Phone') }}</label>
                                    <input type="number" name="phone" id="phone"
                                        class="form-control @error('phone') border-danger @enderror"
                                        placeholder="{{ __('locale.Phone') }}" 
                                        value="{{ old('phone') }}" required />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="email">{{ __('locale.Email') }}</label>
                                    <input type="email" name="email" id="email"
                                        class="form-control @error('email') border-danger @enderror"
                                        placeholder="{{ __('locale.Email') }}" 
                                        value="{{ old('email') }}" required />
                                </div>
                            </div>
                            <div class="col-12" data-repeater-delete>
                                <div class="mb-1">
                                    <label class="form-label" for="rate">{{ __('locale.Delete') }}</label>
                                    <button type="button" class="btn btn-icon btn-danger w-100">
                                        <span>{{ __('locale.Delete') }}</span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 row">
                        <div class="col-6" data-repeater-create>
                            <button type="button" class="btn btn-sm  btn-primary w-100">
                                {{ __('locale.Add') }}
                            </button>
                        </div>
                        <div class="col-6">
                            <div class="p-1 pt-0">
                                <button typex="submit" class="btn btn-primary btn-sm w-50">
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
                $('.vendors-repeater').repeater({
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
