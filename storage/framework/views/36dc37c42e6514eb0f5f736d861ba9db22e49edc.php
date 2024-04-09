

<?php $__env->startSection('title', 'Create card'); ?>

<?php $__env->startSection('content'); ?>


<section id="multiple-column-form">
  <form method="POST" action="<?php echo e(route('user.store')); ?>" class="form form-vertical" >
  <?php echo csrf_field(); ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><?php echo e(__('locale.New User')); ?></h4>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="fullname"><?php echo e(__('locale.Full Name')); ?></label>
                    <input
                      type="text"
                      id="fullname"
                      class="form-control <?php $__errorArgs = ['fullname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                      name="full_name"
                      placeholder="<?php echo e(__('locale.Full Name')); ?>"
                      value="<?php echo e(old('fullname')); ?>"
                      required
                      tabindex="1"/>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="email"><?php echo e(__('locale.Email')); ?></label>
                    <input type="email" 
                      id="email" 
                      class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                      name="email" 
                      placeholder="<?php echo e(__('locale.Email')); ?>"                      
                      value="<?php echo e(old('email')); ?>"
                      required
                      tabindex="3"/>
                  </div>                  
                </div>                
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="password"><?php echo e(__('locale.Password')); ?></label>
                    <input type="password" 
                      id="password" 
                      class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                      name="password" 
                      placeholder="<?php echo e(__('locale.Password')); ?>"
                      required
                      tabindex="5"/>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="username"><?php echo e(__('locale.Username')); ?></label>
                    <input
                      type="text"
                      id="username"
                      class="form-control <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                      name="username"
                      placeholder="<?php echo e(__('locale.Username')); ?>"
                      value="<?php echo e(old('username')); ?>"
                      required
                      tabindex="2"/>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="phone_number"><?php echo e(__('locale.Phone')); ?></label>
                    <input
                      type="phone"
                      inputmode="numeric"
                      id="phone_number"
                      class="form-control <?php $__errorArgs = ['phone_number'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                      name="phone_number"
                      placeholder="<?php echo e(__('locale.Phone Number')); ?>"
                      value="<?php echo e(old('phone_number')); ?>"
                      required
                      tabindex="4"/>
                  </div>
                </div>                           
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="password_confirmation"><?php echo e(__('locale.Confirm Password')); ?></label>
                    <input
                      type="password"
                      id="password_confirmation"
                      class="form-control"
                      name="password_confirmation"
                      placeholder="<?php echo e(__('locale.Confirm Password')); ?>"
                      required
                      tabindex="6"/>
                  </div>
                </div>
              </div>
              
            </div>
            <div class="col-12">
              <button typex="submit" class="btn btn-primary btn-sm w-25">Submit</button>
              <button type="reset" class="btn btn-outline-secondary btn-sm">Reset</button>
              <a href="<?php echo e(url('/')); ?>"class="btn btn-outline-dark btn-sm">Cancel</a>
            </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</section>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/user/create.blade.php ENDPATH**/ ?>