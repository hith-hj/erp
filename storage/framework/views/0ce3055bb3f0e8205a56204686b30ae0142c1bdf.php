
<?php $__env->startSection('title'); ?><?php echo e(__('locale.Currencies')); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('table'); ?>
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card p-1">
                    <div class="card-head">
                        <a href="<?php echo e(route('currency.create')); ?>"
                        class="btn btn-primary w-100"><?php echo e(__('locale.Create New')); ?></a>
                    </div>
                    <div class="card-body px-0">
                        <?php echo e($dataTable->table()); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo e($dataTable->scripts(attributes: ['type' => 'module'])); ?>

<?php $__env->stopPush(); ?>
<?php echo $__env->make('layouts.tableLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/currency/index.blade.php ENDPATH**/ ?>