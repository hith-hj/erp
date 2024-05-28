
<?php $__env->startSection('title'); ?><?php echo e(__('locale.Login')); ?><?php $__env->stopSection(); ?>
<?php $__env->startSection('auth'); ?>
    <div class="auth-inner pt-3">
        <div class="card mb-0">

            <div class="card-head text-center">
                <?php if(Session::has('error')): ?>
                    <div class="alert alert-danger alert-dismissible fade show m-1" role="alert">
                        <div class="alert-body">
                            <?php echo e(Session::get('error')); ?>

                        </div>
                    </div>
                <?php endif; ?>
                <a href="#" class="brand-logo mb-0">
                    
                    
                    <img src="<?php echo e(asset('images/logo/black.png')); ?>" width="200px">
                </a>

                
                <p class="card-text pb-1">Please sign-in to your account</p>
            </div>
            <div class="card-body pt-0">
                <form class="auth-login-form" id="loginForm" action="<?php echo e(route('login')); ?> " method="POST">
                    <?php echo csrf_field(); ?>
                    <div class="mb-1">
                        <label for="email" class="form-label"><?php echo e(__('locale.Email')); ?></label>
                        <input type="text" name="email" tabindex="1" autofocus=""
                            class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="email"
                            placeholder="<?php echo e(__('locale.Email')); ?>" aria-describedby="email"
                            value="<?php echo e(old('email') ?? 'admin@admin.com'); ?>" required>
                        <?php $__errorArgs = ['email'];
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

                    <div class="mb-1">
                        <div class="d-flex justify-content-between">
                            <label class="form-label" for="password"><?php echo e(__('locale.Password')); ?></label>
                            <a href="<?php echo e(route('password.request')); ?>">
                                <small><?php echo e(__('locale.Forgot_Password')); ?></small>
                            </a>
                        </div>
                        <div class="input-group input-group-merge form-password-toggle">
                            <input type="password" id="password" name="password" tabindex="2"
                                placeholder="<?php echo e(__('locale.Password')); ?>"aria-describedby="password"
                                class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required value="password">
                            <?php $__errorArgs = ['password'];
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
                    <button id="BTNdarbi" types="submit" onclickc="device_token()"
                        class="btn btn-primary w-100 waves-effect waves-float waves-light" tabindex="4">Sign in</button>
                </form>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/auth/login.blade.php ENDPATH**/ ?>