@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.Profile') }}
@endsection
@section('content')
    <div class="row">
        <div class="col-12">
            <!-- profile -->
            <div class="card">
                @if ($errors->any())
                    <div class="alert alert-danger m-1">
                        <ul class="m-0">
                            @foreach ($errors->all() as $error)
                                <li class="">{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="card-header border-bottom py-1">
                    <h4 class="card-title">{{ __('locale.Profile') }}</h4>
                </div>
                <div class="card-body py-1">

                    <!-- form -->
                    <form class="validate-form" method="POST" action="{{ route('user.update', ['id' => $user->id]) }}">
                        @csrf
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountFirstName">
                                    {{ __('locale.Full Name') }}</label>
                                <input type="text" class="form-control" id="accountFirstName" name="full_name"
                                    placeholder="{{ __('locale.Full Name') }}" value="{{ $user->full_name }}" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountLastName">
                                    {{ __('locale.Username') }}
                                </label>
                                <input type="text" class="form-control" id="accountLastName" 
                                    placeholder="{{ __('locale.Username') }}" value="{{ $user->username }}" readonly />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountEmail">
                                    {{ __('locale.Email') }}
                                </label>
                                <input type="email" class="form-control" id="accountEmail"
                                    placeholder="{{ __('locale.Email') }}" value="{{ $user->email }}" readonly />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountPhoneNumber">
                                    {{ __('locale.Phone') }}
                                </label>
                                <input type="tel" class="form-control" id="accountPhoneNumber" name="phone_number"
                                    placeholder="{{ $user->getSetting('phone_number') }}"
                                    value="{{ old('phone_number') }}" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountPhoneNumber">
                                    {{ __('locale.Phone') }} No2
                                </label>
                                <input type="tel" class="form-control" 
                                    id="accountPhoneNumber" name="phone_number_n2"
                                    placeholder="{{$user->getSetting('phone_number_n2') }}"
                                    value="{{ old('phone_number_n2') }}" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountAddress">
                                    {{ __('locale.Address') }}
                                </label>
                                <input type="text" class="form-control" id="accountAddress" name="address"
                                    placeholder="{{ $user->getSetting('address') }}"
                                    value="{{ old('address') }}" />
                            </div>
                            <div class="col-12">
                                <button type="submit"
                                    class="btn btn-primary mt-1 w-25">{{ __('locale.Save Changes') }}</button>
                                <button type="reset"
                                    class="btn btn-outline-secondary mt-1">{{ __('locale.Cancel') }}</button>
                            </div>
                        </div>
                    </form>
                    <!--/ form -->
                </div>
            </div>


            <!-- deactivate account  -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('locale.Change Password') }}</h4>
                </div>
                <div class="card-body ">
                    <a href='{{ url("/changePassword/$user->id") }}' class="btn btn-outline-primary my-1">
                        <i class="me-50" data-feather="user"></i>
                        {{ __('locale.Change Password') }}
                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title">{{ __('locale.Delete Account') }}</h4>
                </div>
                <form id="deleteUserForm" action="{{ route('user.delete', ['user' => $user->id]) }}" method="POST">@csrf
                    @method('delete')</form>
                <div class="card-body ">
                    <button type="submit" class="btn btn-danger deactivate-account my-1"
                        onclick="document.getElementById('deleteUserForm').submit();">{{ __('locale.Delete Account') }}</button>
                </div>
            </div>
        </div>
        <!--/ profile -->
    </div>
    </div>
@endsection
