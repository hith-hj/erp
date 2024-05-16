@extends('layouts/contentLayoutMaster')

@section('title') {{__('locale.New User')}} @endsection

@section('content')


<section id="multiple-column-form">
  <form method="POST" action="{{route('user.store')}}" class="form form-vertical" >
  @csrf
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{__('locale.New User')}}</h4>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="fullname">{{__('locale.Full Name')}}</label>
                    <input
                      type="text"
                      id="fullname"
                      class="form-control @error('fullname') border-danger @enderror"
                      name="full_name"
                      placeholder="{{__('locale.Full Name')}}"
                      value="{{old('fullname')}}"
                      required
                      tabindex="1"/>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="email">{{__('locale.Email')}}</label>
                    <input type="email" 
                      id="email" 
                      class="form-control @error('email') border-danger @enderror" 
                      name="email" 
                      placeholder="{{__('locale.Email')}}"                      
                      value="{{old('email')}}"
                      required
                      tabindex="3"/>
                  </div>                  
                </div>                
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="password">{{__('locale.Password')}}</label>
                    <input type="password" 
                      id="password" 
                      class="form-control @error('password') border-danger @enderror" 
                      name="password" 
                      placeholder="{{__('locale.Password')}}"
                      required
                      tabindex="5"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="username">{{__('locale.Username')}}</label>
                    <input
                      type="text"
                      id="username"
                      class="form-control @error('username') border-danger @enderror"
                      name="username"
                      placeholder="{{__('locale.Username')}}"
                      value="{{old('username')}}"
                      required
                      tabindex="2"/>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="phone_number">{{__('locale.Phone')}}</label>
                    <input
                      type="phone"
                      inputmode="numeric"
                      id="phone_number"
                      class="form-control @error('phone_number') border-danger @enderror"
                      name="phone_number"
                      placeholder="{{__('locale.Phone')}}"
                      value="{{old('phone_number')}}"
                      required
                      tabindex="4"/>
                  </div>
                </div>                           
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="password_confirmation">{{__('locale.Confirm Password')}}</label>
                    <input
                      type="password"
                      id="password_confirmation"
                      class="form-control"
                      name="password_confirmation"
                      placeholder="{{__('locale.Confirm Password')}}"
                      required
                      tabindex="6"/>
                  </div>
                </div>
              </div>
              {{-- <div class="col-12">
                <div class="mb-1">
                  <label class="form-label" for="role_id">Role</label>
                  <input
                    type="password"
                    id="role_id"
                    class="form-control"
                    name="role"
                    placeholder="Role"
                    required
                    tabindex="4"/>
                </div>
              </div> --}}
            </div>
            <div class="col-12">
              <button typex="submit" class="btn btn-primary btn-sm w-25">{{__('locale.Submit')}}</button>
              <button type="reset" class="btn btn-outline-secondary btn-sm">{{__('locale.Reset')}}</button>
              <a href="{{url('/')}}"class="btn btn-outline-dark btn-sm">{{__('locale.Cancel')}}</a>
            </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</section>
@endsection