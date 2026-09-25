{{-- <div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <h2 class="content-header-title float-start mb-0">@yield('title')</h2>
            <div class="breadcrumb-wrapper">
                @if (@isset($breadcrumbs))
                    <ol class="breadcrumb">
                        @foreach ($breadcrumbs as $crumb)
                            <li class="breadcrumb-item">
                                @if($crumb['link'])
                                    <a href="{{ $crumb['link'] }}">{{ $crumb['name'] }}</a>
                                @else
                                    {{ $crumb['name'] }}
                                @endif
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>
    </div>
</div> --}}

<div class="content-header-left col-md-9 col-12 mb-2">
    <div class="row breadcrumbs-top">
        <div class="col-12">
            <h2 class="content-header-title float-start mb-0">@yield('title')</h2>
            <div class="breadcrumb-wrapper">
                @if(!empty($breadcrumbs))
                    <ol class="breadcrumb">
                        @foreach ($breadcrumbs as $crumb)
                            <li class="breadcrumb-item {{ $crumb['active'] ? 'active' : '' }}" 
                                @if($crumb['active']) aria-current="page" @endif>
                                
                                @if($crumb['link'])
                                    <a href="{{ $crumb['link'] }}">{{ $crumb['name'] }}</a>
                                @else
                                    {{ $crumb['name'] }}
                                @endif
                                
                            </li>
                        @endforeach
                    </ol>
                @endif
            </div>
        </div>
    </div>
</div>
