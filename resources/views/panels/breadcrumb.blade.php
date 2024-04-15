<div class="content-header row">
  <x-trails :titles="$titles ?? []"/>
  @if (!request()->is('/') && !request()->is('*/create'))
    <div class="content-header-right col-md-3 col-12 mb-2">
      <div class="row ">
        <div class="col-12">
          @php
           $path = explode('/',request()->path());   
          @endphp
          <a href="{{url(Str::singular($path[0]).'/create')}}" class="btn btn-primary w-100">
            {{__('locale.Create')}} {{__('locale.'.Str::ucfirst($path[0])) }}
          </a>
        </div>
      </div>
    </div>
  @endif
</div>
