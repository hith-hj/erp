<div class='dropdown'>
    <button type='button' class='btn btn-sm dropdown-toggle hide-arrow py-0' data-bs-toggle='dropdown'>
        {{ __('locale.Options') }}
    </button>
    <div class='dropdown-menu dropdown-menu-end'>
        @forelse ($options as $option)
            <a class='dropdown-item' href={{$option['route']}}>
                <i data-feather='edit-2' class='me-50'></i>
                <span>{{ __('locale.'.$option['name']) }}</span>
            </a>
        @empty
            <a class='dropdown-item' href={{$route}}>
                <i data-feather='edit-2' class='me-50'></i>
                <span>{{ __('locale.View') }}</span>
            </a>
        @endforelse
    </div>
</div>
