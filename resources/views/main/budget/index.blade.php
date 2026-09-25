@extends('layouts/contentLayoutMaster')
@section('title'){{__('locale.Home Page')}}@endsection

@section('content')
<div class="row">
<div class="col-12 p-6">
    <div class="card">
        <div class="card-header ">
            <div class="card-title">
                <h4 class="font-lg">
                    {{__('locale.Parameters')}}
                </h4>
            </div>
        </div>

        <div class="card-body d-flex flex-column" >
            <form 
                action="{{ route('budget.build') }}" 
                method="GET" 
                x-data="{ 
                    priceOption: '1',
                    manualPrice: ''
                }"
                x-init="$watch('priceOption', value => { if (value === '1') manualPrice = '' })">
                @csrf
                <div class="row g-2">
                    <!-- Material Pricing -->
                    <div class="col-12">
                        <label for="material_price_option" class="form-label">
                            {{ __('locale.Material Pricing') }}
                        </label>
                        <div class="input-group">
                            <span class="input-group-text">{{ __('locale.Options') }}</span>
                            <select class="form-select" x-model="priceOption" name="material_price_option" id="material_price_option">
                                <option value="1">{{ __('locale.Last price') }}</option>
                                <option value="2">{{ __('locale.Manual') }}</option>
                            </select>
                            <input 
                                type="text"
                                inputmode="numeric" 
                                name="manual-price"
                                aria-label="Manual price"
                                class="form-control"
                                x-model="manualPrice"
                                :disabled="priceOption === '1'"
                                :required="priceOption === '2'">
                        </div>
                    </div>
                    
                    <!-- Capital Amount -->
                    <div class="col-12">
                        <label for="capital_amount" class="form-label">
                            {{ __('locale.Capital') }}
                        </label>
                        <div class="input-group">
                            
                            @php
                                $last = Helper::file_data('last_capital');
                            @endphp
                            @if(is_array($last) && count($last) > 0)
                                <span class="input-group-text">
                                    {{ __('locale.Last amount') }}
                                </span>
                                <span class="input-group-text">
                                    {{ $last['last_capital'] }}
                                </span>
                            @else
                                <span class="input-group-text">
                                    {{ __('locale.Amount') }}
                                </span>
                            @endif
                            <input 
                                type="text" 
                                name="capital_amount"
                                id="capital_amount"
                                inputmode="numeric"
                                class="form-control"
                                required>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-12 pt-2">
                        <button type="submit" class="btn btn-outline-primary w-100">
                            {{ __('locale.Submit') }}
                        </button>
                    </div>
                </div>
            </form>
        
        </div>
    </div>
</div>
</div>
@endsection