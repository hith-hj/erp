

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.Purchase')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="table-responsive" style="min-height:10rem">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Bill</th>
                                    <th>Vendor</th>
                                    <th>Inventory</th>
                                    <th>Material</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Cost</th>
                                    <th>Currency</th>
                                    <th>Discount</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><?php echo e($purchase->id); ?></td>
                                    <td><?php echo e($purchase->bill_id); ?></td>
                                    <td><?php echo e($purchase->vendor); ?></td>
                                    <td><?php echo e($purchase->inventory->name); ?></td>
                                    <td><?php echo e($purchase->material->name); ?></td>
                                    <td><?php echo e($purchase->quantity); ?></td>
                                    <td><?php echo e($purchase->unit->name); ?></td>
                                    <td><?php echo e($purchase->cost); ?></td>
                                    <td><?php echo e($purchase->currency->name); ?></td>
                                    <td><?php echo e($purchase->discount); ?></td>
                                    <td><?php echo e($purchase->note); ?></td>
                                    <td><span class="badge rounded-pill badge-light-success me-1">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                data-bs-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" 
                                                    onclick="document.getElementById('deletePurchaseForm').submit();">
                                                    <i data-feather="trash" class="me-50"></i>
                                                    <span>Delete</span>
                                                </a>
                                                <form 
                                                    id="deletePurchaseForm"
                                                    action="<?php echo e(route('purchase.delete',['purchase'=>$purchase->id])); ?>"
                                                    method="POST"
                                                    >
                                                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                                                </form>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.tableLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/purchase/show.blade.php ENDPATH**/ ?>