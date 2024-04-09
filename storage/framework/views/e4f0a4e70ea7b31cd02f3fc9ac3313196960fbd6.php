<?php $__env->startSection('title', 'Feather Icons'); ?>

<?php $__env->startSection('vendor-style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('vendors/css/extensions/toastr.min.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-style'); ?>
<link rel="stylesheet" href="<?php echo e(asset('css/base/plugins/extensions/ext-component-toastr.css')); ?>">
<link rel="stylesheet" href="<?php echo e(asset('css/base/pages/ui-feather.css')); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Feather icons section start -->
<section id="feather-icons">
  <div class="row">
    <div class="col-12">
      <div class="icon-search-wrapper my-3 mx-auto">
        <div class="mb-1 input-group input-group-merge">
          <span class="input-group-text"><i data-feather="search"></i></span>
          <input type="text" class="form-control" id="icons-search" placeholder="Search Icons..." />
        </div>
      </div>
    </div>
  </div>
  <div class="d-flex flex-wrap" id="icons-container"></div>
</section>
<!-- Feather icon-s section end -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
<script src="<?php echo e(asset('vendors/js/extensions/toastr.min.js')); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
<script src="<?php echo e(asset('js/scripts/ui/ui-feather.js')); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views//content/ui-pages/icons-feather.blade.php ENDPATH**/ ?>