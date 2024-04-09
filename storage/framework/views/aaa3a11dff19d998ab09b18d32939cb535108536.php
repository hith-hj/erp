<?php $__env->startSection('title', 'Toastr'); ?>

<?php $__env->startSection('vendor-style'); ?>
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/extensions/toastr.min.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-style'); ?>
  <link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/extensions/ext-component-toastr.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Types section -->
<section id="toastr-types">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Types</h4>
    </div>
    <div class="card-body">
      <div class="demo-inline-spacing">
        <button type="button" class="btn btn-outline-success" id="type-success">Success</button>
        <button type="button" class="btn btn-outline-danger" id="type-error">Error</button>
        <button type="button" class="btn btn-outline-warning" id="type-warning">Warning</button>
        <button type="button" class="btn btn-outline-info" id="type-info">Info</button>
        <button type="button" class="btn btn-outline-success" id="progress-bar">Success Progress Bar</button>
        <button type="button" class="btn btn-outline-primary" id="clear-toast-btn">Clear Toast</button>
      </div>
    </div>
  </div>
</section>
<!--/ Types section -->

<!-- Position section -->
<section id="toastr-position">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Position</h4>
    </div>
    <div class="card-body">
      <div class="row">
        <div class="col-sm-12">
          <h5 class="mb-0">Top Positions</h5>
          <div class="demo-inline-spacing">
            <button type="button" class="btn btn-outline-primary" id="position-top-left">Top Left</button>
            <button type="button" class="btn btn-outline-primary" id="position-top-center">Top Center</button>
            <button type="button" class="btn btn-outline-primary" id="position-top-right">Top Right</button>
            <button type="button" class="btn btn-outline-primary" id="position-top-full">Top Full Width</button>
          </div>
        </div>

        <div class="col-sm-12">
          <h5 class="mt-2 mb-0">Bottom Positions</h5>
          <div class="demo-inline-spacing">
            <button type="button" class="btn btn-outline-primary" id="position-bottom-left">Bottom Left</button>
            <button type="button" class="btn btn-outline-primary" id="position-bottom-center">Bottom Center</button>
            <button type="button" class="btn btn-outline-primary" id="position-bottom-right">Bottom Right</button>
            <button type="button" class="btn btn-outline-primary" id="position-bottom-full">Bottom Full Width</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<!--/ Position section -->

<!-- Duration & Timeout section -->
<section id="toastr-duration-timeout">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Duration & Timeout</h4>
    </div>
    <div class="card-body">
      <p class="card-text mb-0">
        You can use options like <code>showDuration</code>, <code>hideDuration</code>, <code>timeout</code> for your
        toasts. To create a sticky toast set the <code>timeout</code> to <code>0</code>
      </p>
      <div class="demo-inline-spacing">
        <button type="button" class="btn btn-outline-primary" id="fast-duration">Show .5s</button>
        <button type="button" class="btn btn-outline-primary" id="slow-duration">Hide 3s</button>
        <button type="button" class="btn btn-outline-primary" id="timeout">Timeout 5s</button>
        <button type="button" class="btn btn-outline-primary" id="sticky">Sticky Toast</button>
      </div>
    </div>
  </div>
</section>
<!--/ Duration & Timeout section -->

<!-- Animation section -->
<section id="toastr-animation">
  <div class="card">
    <div class="card-header">
      <h4 class="card-title">Show / Hide Animation</h4>
    </div>
    <div class="card-body">
      <p class="card-text mb-0">
        Use the jQuery <code>show/hide</code> method of your choice. These default to <code>fadeIn/fadeOut</code>. The
        methods <code>fadeIn/fadeOut</code>, <code>slideDown/slideUp</code>, and <code>show/hide</code> are built into
        jQuery.
      </p>
      <div class="demo-inline-spacing">
        <button type="button" class="btn btn-outline-primary" id="slide-toast">slideDown - slideUp</button>
        <button type="button" class="btn btn-outline-primary" id="fade-toast">fadeIn - fadeOut</button>
      </div>
    </div>
  </div>
</section>
<!--/ Animation section -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
  <script src="<?php echo e(asset(mix('vendors/js/extensions/toastr.min.js'))); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
  <script src="<?php echo e(asset(mix('js/scripts/extensions/ext-component-toastr.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views//content/extensions/ext-component-toastr.blade.php ENDPATH**/ ?>