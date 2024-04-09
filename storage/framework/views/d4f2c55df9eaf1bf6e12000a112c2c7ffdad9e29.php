<!-- BEGIN: Vendor JS-->
<script src="<?php echo e(asset(mix('vendors/js/vendors.min.js'))); ?>"></script>
<!-- BEGIN Vendor JS-->
<!-- BEGIN: Page Vendor JS-->
<script sync src="<?php echo e(asset(mix('vendors/js/ui/jquery.sticky.js'))); ?>"></script>

<?php echo $__env->yieldContent('vendor-script'); ?>
<!-- END: Page Vendor JS-->
<!-- BEGIN: Theme JS-->
<script src="<?php echo e(asset(mix('js/core/app-menu.js'))); ?>"></script>
<script sync src="<?php echo e(asset(mix('js/core/app.js'))); ?>"></script>

<!-- custome scripts file for user -->
<script sync src="<?php echo e(asset(mix('js/core/scripts.js'))); ?>"></script>


<!-- END: Theme JS-->
<!-- BEGIN: Page JS-->
<?php echo $__env->yieldContent('page-script'); ?>
<!-- END: Page JS-->

<script sync src="<?php echo e(asset(mix('vendors/js/extensions/toastr.min.js'))); ?>"></script>
<?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/panels/scripts.blade.php ENDPATH**/ ?>