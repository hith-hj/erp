@extends('layouts/contentLayoutMaster')

@section('title', 'Create card')

@section('content')

@section('page-style')
  <link rel="stylesheet" href="{{ asset(mix('css/base/plugins/forms/form-validation.css')) }}">
@endsection

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
<section id="multiple-column-form">
  @php
      $action = isset($card) && !is_null($card) ? 
      route('card.update',['id'=>$card->id]):
      route('card.store');
  @endphp
  <form method="POST" action="{{$action}}" class="form form-vertical" >
  @csrf
  <input type="hidden" name="type" value="{{$cardType}}">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Card Details</h4>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="card-name">Name</label>
                    <input
                      type="text"
                      id="card-name"
                      class="form-control
                      @error('name') border-danger @enderror
                      "
                      name="name"
                      placeholder="Name"
                      value="{{$card->name ?? old('name')}}"
                      required/>
                      <div class="invalid-feedback">Please enter card name.</div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="card-code">Code</label>
                    <input type="numeric" 
                      id="card-code" 
                      class="form-control
                      @error('code') border-danger @enderror
                      " 
                      name="code" 
                      placeholder="Code"                      
                      value="{{$card->code ?? old('code')}}"
                      required/>
                      <div class="invalid-feedback">Please enter card code</div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label">Note</label>
                    <textarea
                      class="form-control
                      @error('note') border-danger @enderror
                      "
                      name="note"
                      placeholder="Note"
                      rows="4"
                    >{{$card->note ?? old('note')}}</textarea>
                  </div>
                </div>
              </div>
            </div>
            @if(in_array($cardType,['shift','build']))
              @include("main.card.$cardType")
            @else
              <h3 class="text-danger">This card type is not supported</h3>
            @endif
            <div class="col-12">
              <button type="submit" class="btn btn-primary me-1">Submit</button>
              @if (isset($card) && !is_null($card))
                <a href="{{route('card.show',['id'=>$card->id])}}"
                  class="btn btn-outline-secondary"> 
                  Cancel
                </a>
              @else
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
              @endif
            </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</section>

    
@endsection
@section('page-script')
  <!-- Page js files -->
  <script src="{{ asset(mix('js/scripts/forms/form-validation.js')) }}"></script>
@endsection