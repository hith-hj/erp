<div class="content-header row">
  <x-trails :titles="$titles ?? []" />

  @php
      $path = request()->path();
      $segments = request()->segments();
      $baseResource = $segments[0] ?? '';

      // Clean white-list checking for pages allowed to display the Create button
      $shouldShowCreate = !empty($baseResource) 
          && !request()->is('/')
          && !Str::contains($path, ['/create', '/show/'])
          && !in_array($baseResource, ['bill', 'ledger', 'budget']);
  @endphp

  @if ($shouldShowCreate)
      <div class="content-header-right col-md-3 col-12 mb-2">
          <div class="row">
              <div class="col-12">
                  <a href="{{ url(Str::singular($baseResource) . '/create') }}" class="btn btn-primary w-100">
                      {{ __('locale.Create') }} {{ __('locale.' . Str::ucfirst($baseResource)) }}
                  </a>
              </div>
          </div>
      </div>
  @endif
</div>
