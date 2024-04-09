

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.New Currency')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section id="multiple-column-form">
    <form id="inventory_form" method="POST" action="<?php echo e(route('currency.store')); ?>" class="form form-vertical">
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
                        <h4 class="card-title"><?php echo e(__('locale.New Currency')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="fullname"><?php echo e(__('locale.Name')); ?></label>
                                    <input type="text" id="name"
                                        class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
                                        placeholder="<?php echo e(__('locale.Name')); ?>" value="<?php echo e(old('name')); ?>" required
                                        tabindex="1" />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="code"><?php echo e(__('locale.Code')); ?></label>
                                    <input type="text" id="code"
                                        class="form-control <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="code"
                                        placeholder="<?php echo e(__('locale.Code')); ?>" value="<?php echo e(old('code')); ?>" required
                                        tabindex="1" />
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

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/currency/create.blade.php ENDPATH**/ ?>