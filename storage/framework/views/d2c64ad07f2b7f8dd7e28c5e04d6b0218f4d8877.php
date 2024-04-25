

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.New Purchase')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<?php echo $__env->make('utils.purchase_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            'use strict';
            $('.items-repeater').repeater({
                isFirstItemUndeletable: true,
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    if (confirm(
                            "<?php echo e(__('Are you sure you want to delete this element?')); ?>"
                        )) {
                        $(this).slideUp(deleteElement);
                    }
                },

            });
        });
    });
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/purchase/create.blade.php ENDPATH**/ ?>