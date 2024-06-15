

<?php $__env->startSection('title', 'Card List'); ?>

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
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <button form="deleteCurrencyForm" type="submit" 
                                                    class="btn btn-danger w-75 mx-2" >
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
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/currency/show.blade.php ENDPATH**/ ?>