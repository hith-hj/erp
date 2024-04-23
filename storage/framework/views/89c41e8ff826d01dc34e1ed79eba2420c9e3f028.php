

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.Bill')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section id="card-content-types">
        <div class="card mb-4 p-1">
            <div class="card-head row">
                <div class="col-3">
                    <button class="btn btn-sm  btn-primary w-100 <?php echo e($bill->status == 0 ?: 'disabled'); ?>"
                        data-bs-toggle="modal" type="button" data-bs-target="#addItem">
                        <?php echo e(__('locale.Add Item')); ?>

                    </button>
                </div>

                <div class="col-6 px-auto">
                    <button type="button"
                        class="btn btn-sm btn-success
                        <?php echo e($bill->status == 0 && $bill->items()->count()>0 ?: 'disabled'); ?>"
                        onclick="document.getElementById('saveBillForm').submit();">
                        <?php echo e(__('locale.Save')); ?>

                    </button>                    
                    <button type="button"
                        class="btn btn-sm btn-outline-primary 
                        <?php echo e($bill->status == 1 ? 'btn-primary' : 'disabled'); ?>">
                        <?php echo e(__('locale.Check')); ?>

                    </button>
                    <button type="button"
                        class="btn btn-sm btn-outline-primary 
                        <?php echo e($bill->status == 2 ?: 'disabled'); ?>">
                        <?php echo e(__('locale.Audit')); ?>

                    </button>
                    <button type="button"
                        class="btn btn-sm btn-outline-danger 
                        <?php echo e($bill->status == 0 ?: 'disabled'); ?>"
                        onclick="document.getElementById('deleteBillForm').submit();">
                        <?php echo e(__('locale.Delete')); ?>

                    </button>
                </div>

                <div class="col-3 row">
                    <div class="col-4">
                        <?php if($bill->type == 1): ?>
                            <span class="badge  badge-light-success ">
                                <?php echo e(__('locale.'.$bill->get_type)); ?>

                            </span>
                        <?php else: ?>
                            <span class="badge  badge-light-primary">
                                <?php echo e(__('locale.'.$bill->get_type)); ?>

                            </span>
                        <?php endif; ?>
                    </div>
                    <div class="col-4">
                        <?php
                            $color = match ($bill->status) {
                                0 => 'danger',
                                1 => 'success',
                                2 => 'info',
                                default => 'primary',
                            };
                        ?>
                        <span class="badge badge-light-<?php echo e($color); ?>">
                            <?php echo e(__('locale.'.$bill->get_status)); ?>

                        </span>
                    </div>
                </div>
            </div>
            <form id="saveBillForm" method="POST" action="<?php echo e(route('bill.save', ['id' => $bill->id])); ?>">
                <?php echo csrf_field(); ?>
            </form>
            <form id="auditeBillForm" method="POST" action="<?php echo e(route('bill.audit', ['id' => $bill->id])); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
            </form>
            <form id="deleteBillForm" method="POST" action="<?php echo e(route('bill.delete', ['id' => $bill->id])); ?>">
                <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
            </form>
            <div class="card-body px-0">
                <?php echo e($dataTable->table()); ?>

            </div>
            <?php if($bill->type == 1): ?>
                <?php echo $__env->make('utils.bill_purchase_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
                <?php echo $__env->make('utils.bill_sale_modal', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php endif; ?>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo e($dataTable->scripts(attributes: ['type' => 'module'])); ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            'use strict';
            $('.purchases-repeater').repeater({
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tableLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/bill/show.blade.php ENDPATH**/ ?>