<!-- BEGIN: Vendor JS-->
<script src="<?php echo e(asset('vendors/js/vendors.min.js')); ?>"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script sync src="<?php echo e(asset('vendors/js/ui/jquery.sticky.js')); ?>"></script>

<?php echo $__env->yieldContent('vendor-script'); ?>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="<?php echo e(asset('js/core/app-menu.js')); ?>"></script>
<script sync src="<?php echo e(asset('js/core/app.js')); ?>"></script>

<!-- custome scripts file for user -->
<script sync src="<?php echo e(asset('js/core/scripts.js')); ?>"></script>

<?php if($configData['blankPage'] === false): ?>
    <script src="<?php echo e(asset('customizer.js')); ?>"></script>
<?php endif; ?>

<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
<?php echo $__env->yieldContent('page-script'); ?>
<!-- END: Page JS-->

<script src="<?php echo e(asset('js/alpine.js')); ?>" defer></script>
<script sync src="<?php echo e(asset('vendors/js/extensions/toastr.min.js')); ?>"></script>
<?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/panels/scripts.blade.php ENDPATH**/ ?>