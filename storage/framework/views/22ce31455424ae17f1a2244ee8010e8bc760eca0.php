

<?php $__env->startSection('title'); ?><?php echo e(__('locale.Currency')); ?> - <?php echo e($currency->name); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section id="card-content-types">
        <div class="card mb-4">
            <div class="table-responsive" style="min-height:15rem">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th><?php echo e(__('locale.Name')); ?></th>
                            <th><?php echo e(__('locale.Code')); ?></th>
                            <th><?php echo e(__('locale.Rate')); ?></th>
                            <th><?php echo e(__('locale.Default')); ?></th>
                            <th><?php echo e(__('locale.Action')); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo e($currency->id); ?></td>
                            <td><?php echo e($currency->name); ?></td>
                            <td><?php echo e($currency->code); ?></td>
                            <td><?php echo e($currency->rate_to_default); ?></td>
                            <td>
                                <span class="badge rounded-pill badge-light-success me-1">
                                    <?php echo e($currency->is_default ? __('locale.Default') : '-'); ?>

                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                        data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end p-1">
                                        <?php if(!$currency->is_default): ?>
                                            <button class="btn btn-sm btn-primary w-100 my-1"
                                                data-bs-toggle="modal" type="button" data-bs-target="#setAsDefaultForm">
                                                <?php echo e(__('locale.Default')); ?>

                                            </button>
                                        <?php endif; ?>
                                        <button form="deleteCurrencyForm" type="submit" 
                                            class="btn btn-danger w-100" >
                                            <?php echo e(__('locale.Delete')); ?>

                                        </button>
                                        <form id="deleteCurrencyForm" method="post" 
                                            action="<?php echo e(route('currency.delete',['id'=>$currency->id])); ?>">
                                            <?php echo csrf_field(); ?>
                                            <?php echo method_field('delete'); ?>
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="setAsDefaultForm" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content p-1">
                    <form action="<?php echo e(route('currency.setDefault',['id'=>$currency->id])); ?>" method="post">
                        <?php echo csrf_field(); ?>
                        <div class="modal-header mb-1">
                            <div class="modal-title">
                                <h4 class="font-lg">
                                    Set new rates to the new default currency
                                </h4>
                            </div>
                        </div>
                        <div class="modal-body p-0">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th><?php echo e(__('locale.Currency')); ?></th>
                                        <th><?php echo e(__('locale.Rate')); ?></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__empty_1 = true; $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($loop->index + 1); ?></td>
                                            <td><?php echo e($value->name); ?></td>
                                            <td>
                                                <input type="number" name="<?php echo e($value->id.'-'.$value->name); ?>" 
                                                    step="0.01" min="0.01" max="100000"
                                                    class="form-control" required>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                        
                                    <?php endif; ?>
                                </tbody>
                            </table>
                            <p>the new default "<?php echo e($currency->name); ?>" rate  will be set to 1</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100"><?php echo e(__('locale.Save')); ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/currency/show.blade.php ENDPATH**/ ?>