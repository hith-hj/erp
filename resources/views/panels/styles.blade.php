@php $configData = Helper::applClasses(); @endphp
<!-- BEGIN: Theme CSS-->

<!-- BEGIN: Vendor CSS-->
{{-- @if ((isset($configData['direction']) && $configData['direction'] === 'rtl'))  --}}
@if (app()->getLocale()== 'ar') 
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors-rtl.min.css')) }}" />
  <link rel="stylesheet" href="{{ asset('css-rtl/bootstrap.css') }}" />
  <link rel="stylesheet" href="{{ asset('css-rtl/bootstrap-extended.css') }}" />
  <link rel="stylesheet" href="{{ asset('css-rtl/plugins/extensions/ext-component-toastr.css')}}">
  <link rel="stylesheet" href="{{ asset('css-rtl/components.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css-rtl/core/menu/menu-types/vertical-menu.css')}}">
  <link rel="stylesheet" href="{{ asset('css-rtl/custom-rtl.min.css') }}" />
  <link rel="stylesheet" href="{{ asset('css-rtl/colors.min.css') }}" />
  <link rel="stylesheet" href="{{ asset(mix('css-rtl/style-rtl.css')) }}" />
@else
  <link rel="stylesheet" href="{{ asset(mix('vendors/css/vendors.min.css')) }}" media="print" onload="this.media='all'"/>
  <link rel="stylesheet" href="{{ asset(mix('css/base/core/menu/menu-types/vertical-menu.css'))}}" />
  <link rel="stylesheet" href="{{ asset(mix('css/core.css')) }}" />
  <link rel="stylesheet" href="{{ asset(mix('css/style.css')) }}" />
@endif
<!-- END: Vendor CSS-->

<link rel="stylesheet" href="{{ asset(mix('css/base/themes/dark-layout.css')) }}" />
@yield('vendor-style')


{{-- Page Styles --}}
@yield('page-style')

<!-- laravel style -->
<link rel="stylesheet" href="{{ asset(mix('css/overrides.css')) }}" />
<link rel="stylesheet" href="{{ asset(mix('vendors/css/extensions/toastr.min.css')) }}">
