<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.'.Str::ucfirst( Str::plural(explode('/',request()->path())[0]) ))); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('table'); ?>
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card p-1">
                    <div class="card-body p-0">
                        <?php echo e($dataTable->table()); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo e($dataTable->scripts(attributes: ['type' => 'module'])); ?>

<?php $__env->stopPush(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/utils/table.blade.php ENDPATH**/ ?>