
<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.New vendor')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('vendor-style'); ?>
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section>
        <form method="POST" action="<?php echo e(route('vendor.store')); ?>" class="form form-vertical">
            <?php echo csrf_field(); ?>
            <div class="card row">
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
                    <h4 class="card-title"><?php echo e(__('locale.New vendor')); ?></h4>
                </div>
                <div class="card-body col-12 row vendors-repeater">
                    <div data-repeater-list="vendors" class="col-12">
                        <div data-repeater-item class="row">
                            <div class="col-6">
                                <div class="mb-6">
                                    <label class="form-label" for="first_name"><?php echo e(__('locale.First name')); ?></label>
                                    <input type="text" name="first_name" id="first_name"
                                        class="form-control <?php $__errorArgs = ['first_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        placeholder="<?php echo e(__('locale.First name')); ?>" 
                                        value="<?php echo e(old('first_name')); ?>" required  />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="last_name"><?php echo e(__('locale.Last name')); ?></label>
                                    <input type="text" name="last_name" id="last_name"
                                        class="form-control <?php $__errorArgs = ['last_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                        placeholder="<?php echo e(__('locale.Last name')); ?>" 
                                        value="<?php echo e(old('last_name')); ?>" required  />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="phone"><?php echo e(__('locale.Phone')); ?></label>
                                    <input type="number" name="phone" id="phone"
                                        class="form-control <?php $__errorArgs = ['phone'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="<?php echo e(__('locale.Phone')); ?>" 
                                        value="<?php echo e(old('phone')); ?>" required />
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-1">
                                    <label class="form-label" for="email"><?php echo e(__('locale.Email')); ?></label>
                                    <input type="email" name="email" id="email"
                                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        placeholder="<?php echo e(__('locale.Email')); ?>" 
                                        value="<?php echo e(old('email')); ?>" required />
                                </div>
                            </div>
                            <div class="col-12" data-repeater-delete>
                                <div class="mb-1">
                                    <label class="form-label" for="rate"><?php echo e(__('locale.Delete')); ?></label>
                                    <button type="button" class="btn btn-icon btn-danger w-100">
                                        <span><?php echo e(__('locale.Delete')); ?></span>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 row">
                        <div class="col-6" data-repeater-create>
                            <button type="button" class="btn btn-sm  btn-primary w-100">
                                <?php echo e(__('locale.Add')); ?>

                            </button>
                        </div>
                        <div class="col-6">
                            <div class="p-1 pt-0">
                                <button typex="submit" class="btn btn-primary btn-sm w-50">
                                    <?php echo e(__('locale.Store')); ?>

                                </button>
                                <button type="reset" class="btn btn-outline-primary btn-sm">
                                    <?php echo e(__('locale.Reset')); ?>

                                </button>
                                <a href="<?php echo e(url('/')); ?>"class="btn btn-outline-dark btn-sm">
                                    <?php echo e(__('locale.Cancel')); ?>

                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
    <script>
        $(document).ready(function() {
            $(function() {
                'use strict';
                // form repeater jquery
                $('.vendors-repeater').repeater({
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

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/vendors/create.blade.php ENDPATH**/ ?>