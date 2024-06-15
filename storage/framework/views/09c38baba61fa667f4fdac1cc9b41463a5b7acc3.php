<?php if(isset($pageConfigs)): ?>
    <?php echo Helper::updatePageConfig($pageConfigs); ?>

<?php endif; ?>

<!DOCTYPE html>
<?php
    $configData = Helper::applClasses();
?>

<html class="loading <?php echo e($configData['theme'] === 'light' ? '' : $configData['layoutTheme']); ?>"
    lang="<?php if(session()->has('locale')): ?> 
    <?php echo e(session()->get('locale')); ?>

    <?php else: ?>
    <?php echo e($configData['defaultLanguage']); ?> 
    <?php endif; ?>"
    data-textdirection="<?php echo e(app()->getLocale() == 'ar' ? 'rtl' : 'ltr'); ?>"
    <?php if($configData['theme'] === 'dark'): ?> data-layout="dark-layout" <?php endif; ?>>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,minimal-ui">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <meta name="description" content="<?php echo e(env('APP_NAME', 'APP')); ?> | Dashboard">
    <meta name="keywords" content="<?php echo e(env('APP_NAME', 'APP')); ?> | Dashboard">
    <meta name="author" content="Darbi">
    <title><?php echo e(env('APP_NAME', 'APP')); ?> | <?php echo $__env->yieldContent('title'); ?></title>
    <link rel="apple-touch-icon" href="<?php echo e(asset('images/ico/apple-icon-120.png')); ?>">
    
    <link rel="shortcut icon" type="image/x-icon" href="<?php echo e(asset('images/logo/white-sm.png')); ?>">

    
    <?php echo $__env->make('panels/styles', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
</head>

<?php if(isset($configData['mainLayoutType'])): ?>
    
<?php endif; ?>

<?php echo $__env->make($configData['mainLayoutType'] === 'horizontal' ? 'layouts.horizontalLayoutMaster' : 'layouts.verticalLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/layouts/contentLayoutMaster.blade.php ENDPATH**/ ?>