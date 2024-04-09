

<?php $__env->startSection('title', 'Table'); ?>

<?php $__env->startSection('vendor-style'); ?>
  
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css'))); ?>">
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css'))); ?>">
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css'))); ?>">
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/rowGroup.bootstrap5.min.css'))); ?>">
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<?php echo $__env->yieldContent('table'); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->yieldPushContent('scripts'); ?>





<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/layouts/tablesLayout.blade.php ENDPATH**/ ?>