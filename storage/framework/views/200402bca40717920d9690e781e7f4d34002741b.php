<?php if(app()->getLocale() == 'ar'): ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendors/css/vendors-rtl.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css-rtl/bootstrap.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css-rtl/bootstrap-extended.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css-rtl/components.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css-rtl/core/menu/menu-types/vertical-menu.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('css-rtl/custom-rtl.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css-rtl/colors.min.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css-rtl/style-rtl.css')); ?>" />
<?php else: ?>
    <link rel="stylesheet" href="<?php echo e(asset('vendors/css/vendors.min.css')); ?>" media="print" onload="this.media='all'" />
    <link rel="stylesheet" href="<?php echo e(asset('css/base/core/menu/menu-types/vertical-menu.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/core.css')); ?>" />
    <link rel="stylesheet" href="<?php echo e(asset('css/style.css')); ?>" />
<?php endif; ?>
<link rel="stylesheet" href="<?php echo e(asset('vendors/css/extensions/toastr.min.css')); ?>">

<link rel="stylesheet" href="<?php echo e(asset('css/base/themes/dark-layout.css')); ?>" />
<?php echo $__env->yieldContent('vendor-style'); ?>

<?php echo $__env->yieldContent('page-style'); ?>

<link rel="stylesheet" href="<?php echo e(asset('css/overrides.css')); ?>" />
<?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/panels/styles.blade.php ENDPATH**/ ?>