<!-- BEGIN: Vendor JS-->
<script src="{{ asset('vendors/js/vendors.min.js') }}"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script sync src="{{ asset('vendors/js/ui/jquery.sticky.js') }}"></script>

@yield('vendor-script')
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="{{ asset('js/core/app-menu.js') }}"></script>
<script sync src="{{ asset('js/core/app.js') }}"></script>

<!-- custome scripts file for user -->
<script sync src="{{ asset('js/core/scripts.js') }}"></script>

@if ($configData['blankPage'] === false)
    <script src="{{ asset('customizer.js') }}"></script>
@endif

<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
@yield('page-script')
<!-- END: Page JS-->

<script src="{{ asset('js/alpine.js') }}" defer></script>
<script sync src="{{ asset('vendors/js/extensions/toastr.min.js') }}"></script>
