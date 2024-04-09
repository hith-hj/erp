<?php $__env->startSection('content'); ?>
<div class="auth-wrapper auth-basic px-2">
    <?php echo $__env->yieldContent('auth'); ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.guestLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/layouts/app.blade.php ENDPATH**/ ?>