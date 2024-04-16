@extends('layouts/contentLayoutMaster')

@section('title'){{__("locale.New Material")}}@endsection

@section('content')
@section('vendor-style')
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/forms/select/select2.min.css')) }}">
@endsection

<section id="multiple-column-form">
  <form method="POST" action="{{route('material.store')}}" class="form form-vertical" >
  @csrf
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">{{__('locale.New Material')}}</h4>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="fullname">{{__('locale.Name')}}</label>
                    <input
                      type="text"
                      id="name"
                      class="form-control @error('name') border-danger @enderror"
                      name="name"
                      placeholder="{{__('locale.Name')}}"
                      value="{{old('name')}}"
                      required
                      tabindex="1"/>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="email">{{__('locale.Type')}}</label>
                      <select name="type" tabindex="3" required id="type"
                      class="form-select @error('type') border-danger @enderror">
                          <option value="1">{{__('locale.Base')}}</option>
                          <option value="2">{{__('locale.Manufactured')}}</option>
                      </select>
                  </div>                  
                </div> 
              </div>
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="base_unit">{{__('locale.Base Unit')}}</label>
                      <select name="base_unit" tabindex="2" id="base_unit"required
                      class="form-select @error('base_unit') border-danger @enderror">
                        @foreach($units as $unit)
                          <option value="{{$unit->id}}">
                            {{$unit->symbol}} - {{__('locale.'.$unit->name)}} 
                          </option>
                        @endforeach
                      </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="phone_number">{{__('locale.Units')}}</label>
                    <select name="units[]" id="select2-basic" multiple tabindex="4"required
                    class="select2 form-select @error('units') border-danger @enderror" >
                      @foreach($units as $unit)
                        <option value="{{$unit->id}}">
                          {{$unit->symbol}} - {{__('locale.'.$unit->name)}} 
                        </option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <button typex="submit" class="btn btn-primary btn-sm w-25">{{__('locale.Store')}}</button>
              <button type="reset" class="btn btn-outline-primary btn-sm">{{__('locale.Reset')}}</button>
              <a href="{{url('/')}}"class="btn btn-outline-dark btn-sm">{{__('locale.Cancel')}}</a>
            </div>
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
@endsection