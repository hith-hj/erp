
<?php $__env->startSection('vendor-style'); ?>
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/dataTables.bootstrap5.min.css'))); ?>">
  <link  rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/responsive.bootstrap5.min.css'))); ?>">
  <link  rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/tables/datatable/buttons.bootstrap5.min.css'))); ?>">
  
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/pickers/flatpickr/flatpickr.min.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>

<?php echo $__env->yieldContent('table'); ?>

<?php $__env->startSection('vendor-script'); ?>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js'))); ?>"></script>
  <script sync src="<?php echo e(asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.min.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/datatables.checkboxes.min.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/datatables.buttons.min.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/jszip.min.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/pdfmake.min.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/vfs_fonts.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/buttons.html5.min.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/buttons.print.min.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/tables/datatable/dataTables.rowGroup.min.js'))); ?>"></script>
  <script sync src="<?php echo e(asset(mix('vendors/js/pickers/flatpickr/flatpickr.min.js'))); ?>"></script>
  
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-script'); ?>
  <?php echo $__env->yieldPushContent('scripts'); ?>
<?php $__env->stopSection(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/layouts/tableLayout.blade.php ENDPATH**/ ?>