
<?php $__env->startSection('title','Reset Password'); ?> 
<?php $__env->startSection('page-style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset(mix('css/base/pages/authentication.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="auth-inner pt-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-6 mx-auto">
                    <div class="card">
                        <div class="card-header text-center">
                            <h3>
                                <?php echo e(__('Reset Password')); ?>

                            </h3>
                        </div>

                        <div class="card-body row">
                            <form method="POST" action="<?php echo e(route('changePassword', ['user' => $user])); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="col-12 mb-1">
                                    <div class="">
                                        <label for="email"
                                        class="form-label"><?php echo e(__('Old Password')); ?></label>
                                        <input id="old_password" type="password"
                                            class="form-control <?php $__errorArgs = ['old_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="old_password" required autofocus>

                                        <?php $__errorArgs = ['old_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-12 mb-1">
                                    <div class="">
                                        <label for="password"
                                        class="form-label"><?php echo e(__('New Password')); ?></label>
                                        <input id="password" type="password"
                                            class="form-control <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="new_password" required autocomplete="new-password">

                                        <?php $__errorArgs = ['new_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <span class="invalid-feedback" role="alert">
                                                <strong><?php echo e($message); ?></strong>
                                            </span>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>

                                <div class="col-12 mb-1">
                                    <div class="">
                                        <label for="password-confirm"
                                        class="form-label"><?php echo e(__('Confirm Password')); ?></label>
                                        <input id="password-confirm" type="password" class="form-control"
                                            name="new_password_confirmation" required autocomplete="new-password">
                                    </div>
                                </div>

                                <div class="col-12 mb-0">
                                    <div class="">
                                        <button type="submit" class="btn btn-primary">
                                            <?php echo e(__('Reset Password')); ?>

                                        </button>
                                        <a href="/" class="btn btn-outline-dark">
                                            <?php echo e(__('locale.Cancel')); ?>

                                        </a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/auth/passwords/reset.blade.php ENDPATH**/ ?>