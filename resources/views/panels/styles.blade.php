@if (app()->getLocale() == 'ar')
    <link rel="stylesheet" href="{{ asset('vendors/css/vendors-rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css-rtl/bootstrap.css') }}" />
    <link rel="stylesheet" href="{{ asset('css-rtl/bootstrap-extended.css') }}" />
    <link rel="stylesheet" href="{{ asset('css-rtl/components.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css-rtl/core/menu/menu-types/vertical-menu.css') }}">
    <link rel="stylesheet" href="{{ asset('css-rtl/custom-rtl.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css-rtl/colors.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('css-rtl/style-rtl.css') }}" />
@else
    <link rel="stylesheet" href="{{ asset('vendors/css/vendors.min.css') }}" media="print" onload="this.media='all'" />
    <link rel="stylesheet" href="{{ asset('css/base/core/menu/menu-types/vertical-menu.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/core.css') }}" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}" />
@endif
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/toastr.min.css') }}">

<link rel="stylesheet" href="{{ asset('css/base/themes/dark-layout.css') }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@yield('vendor-style')

@yield('page-style')

<link rel="stylesheet" href="{{ asset('css/overrides.css') }}" />
