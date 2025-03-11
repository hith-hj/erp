<div class='dropdown'>
    <button type='button' class='btn btn-sm dropdown-toggle hide-arrow py-0' data-bs-toggle='dropdown'>
        <i class='fa fa-ellipsis-v'></i>
    </button>
    <div class='dropdown-menu dropdown-menu-end'>
        @forelse ($options as $option)
            <a href={{$option['route'] ?? '#'}}
            @if($option['name'] == 'Delete') 
                onclick="
                if(!confirm('Are You sure?')){event.preventDefault() }
                "
            @endif
            class = "dropdown-item {{ $option['class'] ?? ''}}" >
                <i class='me-1 fa {{$option['icon'] ?? 'fa-circle-thin'}}'></i>
                <span>{{ $option['name'] ?? __('locale.None') }}</span>
            </a>
        @empty
            <a class='dropdown-item' href={{$route ?? '#'}}>
                <i class='fa fa-circle-thin me-1'></i>
                <span>{{ __('locale.View') }}</span>
            </a>
        @endforelse
    </div>
</div>