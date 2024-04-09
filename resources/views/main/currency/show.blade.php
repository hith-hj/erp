@extends('layouts/contentLayoutMaster')

@section('title', 'Card List')

@section('content')
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ $currency->name }}</h4>
                        <div class="btn-group">
                            <i id="card{{ $currency->code }}DropDown" data-bs-toggle="dropdown" data-feather="more-vertical"
                                class="font-medium-3 cursor-pointer dropdown-toggle"></i>
                            <div class="dropdown-menu" aria-labelledby="card{{ $currency->code }}DropDown">
                                <a href="">{{__('locale.Delete')}}</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-subtitle text-muted mb-1">{{ $currency->code }}</div>
                        @forelse ($currency->rates as $rate)
                            <p class="card-text">
                                Rate To : {{ $rate->name }} 
                                - Is Equal : {{ $rate->pivot->rate }}
                            </p>
                        @empty
                            <p>no rates for this curency</p>
                        @endforelse
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h4>{{ __('locale.Add Rate') }}</h4>
                            <form method="POST"
                                action="{{ route('currency.rates.store', ['currency_id' => $currency->id]) }}">
                                @csrf
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="phone_number">{{ __('locale.Currency') }}</label>
                                                <select id="material_list" name="to_id" required class=" form-select">
                                                    <option value="">Chose Material</option>
                                                    @foreach ($currencies as $currency)
                                                        <option value="{{ $currency->id }}">
                                                            {{ $currency->name }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="rate">{{ __('locale.Rate') }}</label>
                                                <input type="text" id="rate" name="rate"
                                                    class="form-control @error('rate') border-danger @enderror"
                                                    placeholder="{{ __('locale.Rate') }}" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <button type="submit"
                                        class="btn btn-outline-primary w-100 ">{{ __('locale.Store') }}</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
@endsection
