<?php $configData = Helper::applClasses(); ?>
<!-- BEGIN: Theme CSS-->

<!-- BEGIN: Vendor CSS-->

<?php if(app()->getLocale()== 'ar'): ?> 
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/vendors-rtl.min.css'))); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('css-rtl/bootstrap.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('css-rtl/bootstrap-extended.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('css-rtl/plugins/extensions/ext-component-toastr.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css-rtl/components.min.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('css-rtl/core/menu/menu-types/vertical-menu.css')); ?>">
  <link rel="stylesheet" href="<?php echo e(asset('css-rtl/custom-rtl.min.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset('css-rtl/colors.min.css')); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset(mix('css-rtl/style-rtl.css'))); ?>" />
<?php else: ?>
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/vendors.min.css'))); ?>" media="print" onload="this.media='all'"/>
  <link rel="stylesheet" href="<?php echo e(asset(mix('css/base/core/menu/menu-types/vertical-menu.css'))); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset(mix('css/core.css'))); ?>" />
  <link rel="stylesheet" href="<?php echo e(asset(mix('css/style.css'))); ?>" />
<?php endif; ?>
<!-- END: Vendor CSS-->

<link rel="stylesheet" href="<?php echo e(asset(mix('css/base/themes/dark-layout.css'))); ?>" />
<?php echo $__env->yieldContent('vendor-style'); ?>



<?php echo $__env->yieldContent('page-style'); ?>

<!-- laravel style -->
<link rel="stylesheet" href="<?php echo e(asset(mix('css/overrides.css'))); ?>" />
<link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/extensions/toastr.min.css'))); ?>">
<?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/panels/styles.blade.php ENDPATH**/ ?>