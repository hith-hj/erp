


<?php $__env->startSection('title', 'Main'); ?>

<?php $__env->startSection('content'); ?>
<div class="container">
  <div class="card">
      <div class="card-header">Manage Users</div>
      <div class="card-body">
          <?php echo e($dataTable->table()); ?>

      </div>
  </div>
</div>
<?php $__env->stopSection(); ?>


<?php $__env->startPush('scripts'); ?>
    <?php echo e($dataTable->scripts(attributes: ['type' => 'module'])); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/tables/user/users-datatable.blade.php ENDPATH**/ ?>