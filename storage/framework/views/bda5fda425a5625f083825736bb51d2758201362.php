

<?php $__env->startSection('title'); ?><?php echo e(__("locale.New Material")); ?><?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('vendor-style'); ?>
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/forms/select/select2.min.css'))); ?>">
<?php $__env->stopSection(); ?>

<section id="multiple-column-form">
  <form method="POST" action="<?php echo e(route('material.store')); ?>" class="form form-vertical" >
  <?php echo csrf_field(); ?>
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title"><?php echo e(__('locale.New Material')); ?></h4>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="fullname"><?php echo e(__('locale.Name')); ?></label>
                    <input
                      type="text"
                      id="name"
                      class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                      name="name"
                      placeholder="<?php echo e(__('locale.Name')); ?>"
                      value="<?php echo e(old('name')); ?>"
                      required
                      tabindex="1"/>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="email"><?php echo e(__('locale.Type')); ?></label>
                      <select name="type" tabindex="3" required id="type"
                      class="form-select <?php $__errorArgs = ['type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                          <option value="1"><?php echo e(__('locale.Base')); ?></option>
                          <option value="2"><?php echo e(__('locale.Manufactured')); ?></option>
                      </select>
                  </div>                  
                </div> 
              </div>
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="base_unit"><?php echo e(__('locale.Base Unit')); ?></label>
                      <select name="base_unit" tabindex="2" id="base_unit"required
                      class="form-select <?php $__errorArgs = ['base_unit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                        <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                          <option value="<?php echo e($unit->id); ?>">
                            <?php echo e($unit->symbol); ?> - <?php echo e(__('locale.'.$unit->name)); ?> 
                          </option>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      </select>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="phone_number"><?php echo e(__('locale.Units')); ?></label>
                    <select name="units[]" id="select2-basic" multiple tabindex="4"required
                    class="select2 form-select <?php $__errorArgs = ['units'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" >
                      <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <option value="<?php echo e($unit->id); ?>">
                          <?php echo e($unit->symbol); ?> - <?php echo e(__('locale.'.$unit->name)); ?> 
                        </option>
                      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-12">
              <button typex="submit" class="btn btn-primary btn-sm w-25"><?php echo e(__('locale.Store')); ?></button>
              <button type="reset" class="btn btn-outline-primary btn-sm"><?php echo e(__('locale.Reset')); ?></button>
              <a href="<?php echo e(url('/')); ?>"class="btn btn-outline-dark btn-sm"><?php echo e(__('locale.Cancel')); ?></a>
            </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('vendor-script'); ?>
  <!-- vendor files -->
  <script src="<?php echo e(asset(mix('vendors/js/forms/select/select2.full.min.js'))); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
  <!-- Page js files -->
  <script src="<?php echo e(asset(mix('js/scripts/forms/form-select2.js'))); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/material/create.blade.php ENDPATH**/ ?>