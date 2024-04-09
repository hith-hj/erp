<div class="row">
    <div class="card-header">
        <h4 class="card-title">Shift Details</h4>
    </div>
    <div class="col-6">
      <div class="col-12">
          <div class="mb-1">
              <label class="form-label" for="card-name">Shift Type</label>
              <input type="text" id="card-name" class="form-control
              @error('shift_type') border-danger @enderror
              " name="shift_type" placeholder="Name" required 
              value="{{$card->shift->shift_type ?? old('shift_type')}}"/>
              <div class="invalid-feedback">Please enter Shift Type.</div>
          </div>
      </div>
      <div class="col-12">
          <div class="mb-1">
              <label class="form-label" for="card-code">Shift Name</label>
              <input type="text" id="card-code" class="form-control
              @error('shift_name') border-danger @enderror
              " name="shift_name" placeholder="Code" required 
              value="{{$card->shift->shift_name ?? old('shift_name')}}"/>
              <div class="invalid-feedback">Please enter Shift Name</div>
          </div>
      </div>
  </div>
  <div class="col-6">
    <div class="col-12">
        <div class="mb-1">
            <label class="form-label" for="card-name">Start Time</label>
            <input type="time" id="card-name" class="form-control
            @error('start_time') border-danger @enderror
            " name="start_time" placeholder="Name" required
            value="{{$card->shift->start_time ?? old('start_time')}}" />
            <div class="invalid-feedback">Please enter start Time.</div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1">
            <label class="form-label" for="card-code">End Time</label>
            <input type="time" id="card-code" class="form-control
            @error('end_time') border-danger @enderror
            " name="end_time" placeholder="Code" required 
            value="{{$card->shift->end_time ?? old('end_time')}}"/>
            <div class="invalid-feedback">Please enter End Time.</div>
        </div>
    </div>
  </div>
</div>
