<!DOCTYPE html>


<html class="loading "lang="@if(session()->has('locale')){{session()->get('locale')}}@endif"
data-textdirection="ltr">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta name="viewport" content="width=device-width,initial-scale=1.0,minimal-ui">
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <meta name="description" content="{{env('APP_NAME','APP')}} | Dashboard">
  <meta name="keywords" content="{{env('APP_NAME','APP')}} | Dashboard">
  <meta name="author" content="Darbi">
  <title>{{env('APP_NAME','APP')}} | @yield('title')</title>
  <link rel="apple-touch-icon" href="{{asset('images/ico/apple-icon-120.png')}}">
  <link rel="shortcut icon" type="image/x-icon" href="{{asset('images/logo/favicon.ico')}}">

  {{-- Include core + vendor Styles --}}
  @include('panels/styles')

</head>
<!-- END: Head-->

<!-- BEGIN: Body-->
<body class="vertical-layout vertical-menu-modern"data-open="click">
  <!-- BEGIN: Content-->
  <div class="app-content">
    <!-- BEGIN: Header-->
    <div class="content-wrapper ">
      {{-- Include Breadcrumb --}}
      <div class="content-body ">
        {{-- Include Page Content --}}
        @yield('content')
      </div>
    </div>

  </div>
  <!-- End: Content-->


</body>
</html>
