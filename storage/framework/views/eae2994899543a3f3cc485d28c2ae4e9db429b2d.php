

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.New Bill')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <section id="multiple-column-form" >
        <form id="inventory_form" method="POST" action="<?php echo e(route('bill.store')); ?>" class="form form-vertical">
            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger m-1">
                                <ul class="m-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="p-1"><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="card-header">
                            <h4 class="card-title"><?php echo e(__('locale.New Bill')); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-1">
                                        <label class="form-label" for="type"><?php echo e(__('locale.Type')); ?></label>
                                        <select id="type" name="type" required class="form-select" >
                                            <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                            <option value="1"><?php echo e(__('locale.Purchase')); ?></option>
                                            <option value="2"><?php echo e(__('locale.Sale')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                

                            </div>
                            <div class="col-12">
                                <button typex="submit"
                                    class="btn btn-primary btn-sm w-25"><?php echo e(__('locale.Store')); ?></button>
                                <button type="reset"
                                    class="btn btn-outline-primary btn-sm"><?php echo e(__('locale.Reset')); ?></button>
                                <a
                                    href="<?php echo e(url('/')); ?>"class="btn btn-outline-dark btn-sm"><?php echo e(__('locale.Cancel')); ?></a>
                            </div>
                            
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('vendor-script'); ?>
    <script src="<?php echo e(asset(mix('vendors/js/forms/select/select2.full.min.js'))); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
    <script src="<?php echo e(asset(mix('js/scripts/forms/form-select2.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/bill/create.blade.php ENDPATH**/ ?>