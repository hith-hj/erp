<!-- BEGIN: Footer-->
<footer class="footer footer-light {{($configData['footerType'] === 'footer-hidden') ? 'd-none':''}} {{$configData['footerType']}}">
  <p class="clearfix mb-0">
    <span class="float-md-start d-none d-md-block">
        All rights Reserved
    </span>
    <span class="float-md-end d-block d-md-inline-block mt-25">
      <a class="ms-25" href="https://your1site.com" target="_blank">Your1Site</a> 
        &copy;
      <script>document.write(new Date().getFullYear())</script>
      {{-- <span class="d-none d-sm-inline-block">All rights Reserved</span> --}}
    </span>
    {{-- <span class="float-md-end d-none d-md-block">
        Hand-crafted & Made with <i data-feather="heart"></i>
    </span> --}}
  </p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->
