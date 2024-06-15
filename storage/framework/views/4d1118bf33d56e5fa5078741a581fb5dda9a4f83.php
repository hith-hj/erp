

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.Purchase')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <div class="card-head row w-100">
                            <div class="col-3">
                                <button
                                    class="btn btn-sm  btn-primary w-100 <?php echo e($purchase->bill->status == 0 ?: 'disabled'); ?>"
                                    data-bs-toggle="modal" type="button" data-bs-target="#addItem">
                                    <?php echo e(__('locale.Add Item')); ?>

                                </button>
                                <div class="modal fade" id="addItem" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                <?php echo $__env->make('utils.purchase_new_material_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 px-auto">
                                <button type="button"
                                    class="btn btn-sm btn-success
                                    <?php echo e($purchase->bill->status == 0 && $purchase->materials()->count() > 0 ?: 'disabled'); ?>"
                                    onclick="document.getElementById('savePurchaseForm').submit();">
                                    <?php echo e(__('locale.Save')); ?>

                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary 
                                    <?php echo e($purchase->bill->status == 1 ? 'btn-primary' : 'disabled'); ?>"
                                    onclick="document.getElementById('checkPurchaseForm').submit();">
                                    <?php echo e(__('locale.Check')); ?>

                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary 
                                    <?php echo e($purchase->bill->status == 2 ? 'btn-primary' : 'disabled'); ?>"
                                    onclick="document.getElementById('auditPurchaseForm').submit();">
                                    <?php echo e(__('locale.Audit')); ?>

                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger 
                                    <?php echo e($purchase->bill->status == 0 ?: 'disabled'); ?>"
                                    onclick="document.getElementById('deletePurchaseForm').submit();">
                                    <?php echo e(__('locale.Delete')); ?>

                                </button>
                                <form hidden id="savePurchaseForm" method="POST"
                                    action="<?php echo e(route('purchase.save', ['id' => $purchase->id])); ?>">
                                    <?php echo csrf_field(); ?>
                                </form>
                                <form hidden id="checkPurchaseForm" method="POST"
                                    action="<?php echo e(route('purchase.check', ['id' => $purchase->id])); ?>">
                                    <?php echo csrf_field(); ?>
                                </form>
                                <form hidden id="auditPurchaseForm" method="POST"
                                    action="<?php echo e(route('purchase.audit', ['id' => $purchase->id])); ?>">
                                    <?php echo csrf_field(); ?>
                                </form>
                                <form hidden id="deletePurchaseForm" method="POST"
                                    action="<?php echo e(route('purchase.delete', ['id' => $purchase->id])); ?>">
                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                </form>
                            </div>

                            <div class="col-3 row">
                                <div class="col-4">
                                    <?php
                                        $color = match ($purchase->bill->status) {
                                            0 => 'danger',
                                            1 => 'success',
                                            2 => 'info',
                                            default => 'primary',
                                        };
                                    ?>
                                    <span class="badge badge-light-<?php echo e($color); ?>">
                                        <?php echo e($purchase->bill->get_status); ?>

                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive" style="min-height:5rem">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th><?php echo e(__('locale.Bill')); ?></th>
                                        <th><?php echo e(__('locale.Vendor')); ?></th>
                                        <th><?php echo e(__('locale.Inventory')); ?></th>
                                        <th><?php echo e(__('locale.Discount')); ?></th>
                                        <th><?php echo e(__('locale.Note')); ?></th>
                                        <th><?php echo e(__('locale.Mark')); ?></th>
                                        <th><?php echo e(__('locale.Level')); ?></th>
                                        <th><?php echo e(__('locale.User')); ?></th>
                                        <th><?php echo e(__('locale.Created at')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?php echo e($purchase->id); ?></td>
                                        <td><?php echo e($purchase->bill?->serial); ?></td>
                                        <td><?php echo e($purchase->vendor?->fullName); ?></td>
                                        <td><?php echo e($purchase->inventory?->name); ?></td>
                                        <td><?php echo e($purchase->discount); ?></td>
                                        <td><?php echo e($purchase->note); ?></td>
                                        <td><?php echo e($purchase->mark); ?></td>
                                        <td><?php echo e($purchase->level); ?></td>
                                        <td><?php echo e($purchase->user?->username); ?></td>
                                        <td><?php echo e($purchase->created_at->format('Y-m-d')); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive" style="min-height:10rem">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th><?php echo e(__('locale.Material')); ?></th>
                                        <th><?php echo e(__('locale.Quantity')); ?></th>
                                        <th><?php echo e(__('locale.Unit')); ?></th>
                                        <th><?php echo e(__('locale.Cost')); ?></th>
                                        <th><?php echo e(__('locale.Currency')); ?></th>
                                        <th><?php echo e(__('locale.Rate')); ?></th>
                                        <th><?php echo e(__('locale.Rate_to')); ?></th>
                                        <th><?php echo e(__('locale.Action')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $purchase->materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($material->id); ?></td>
                                            <td><?php echo e($material->name); ?></td>
                                            <td><?php echo e($material->pivot->quantity); ?></td>
                                            <td><?php echo e($material->pivot->unit?->name); ?></td>
                                            <td><?php echo e($material->pivot->cost); ?></td>
                                            <td><?php echo e($material->pivot->currency?->name); ?></td>
                                            <td><?php echo e($material->pivot->rate); ?></td>
                                            <td><?php echo e($material->pivot->rateTo?->name); ?></td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                        data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                            onclick="document.getElementById('purchaseDeleteMaterial').submit();">
                                                            <i data-feather="trash" class="me-50"></i>
                                                            <span>Delete</span>
                                                        </a>
                                                        <form id="purchaseDeleteMaterial"
                                                            action="<?php echo e(route('purchase.deleteMaterial', ['id' => $purchase->id])); ?>"
                                                            method="POST">
                                                            <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                                            <input type="hidden" name="material_id" value="<?php echo e($material->id); ?>">
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
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
<?php echo $__env->make('layouts.tableLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/purchase/show.blade.php ENDPATH**/ ?>