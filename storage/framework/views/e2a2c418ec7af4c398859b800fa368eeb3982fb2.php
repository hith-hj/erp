

<?php $__env->startSection('title', 'Create card'); ?>

<?php $__env->startSection('content'); ?>

<?php $__env->startSection('page-style'); ?>
  <link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/forms/form-validation.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php if($errors->any()): ?>
    <div class="alert alert-danger">
        <ul>
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </ul>
    </div>
<?php endif; ?>
<section id="multiple-column-form">
  <?php
      $action = isset($card) && !is_null($card) ? 
      route('card.update',['id'=>$card->id]):
      route('card.store');
  ?>
  <form method="POST" action="<?php echo e($action); ?>" class="form form-vertical" >
  <?php echo csrf_field(); ?>
  <input type="hidden" name="type" value="<?php echo e($cardType); ?>">
  <div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Card Details</h4>
        </div>
        <div class="card-body">
            <div class="row">
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="card-name">Name</label>
                    <input
                      type="text"
                      id="card-name"
                      class="form-control
                      <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                      "
                      name="name"
                      placeholder="Name"
                      value="<?php echo e($card->name ?? old('name')); ?>"
                      required/>
                      <div class="invalid-feedback">Please enter card name.</div>
                  </div>
                </div>
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label" for="card-code">Code</label>
                    <input type="numeric" 
                      id="card-code" 
                      class="form-control
                      <?php $__errorArgs = ['code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                      " 
                      name="code" 
                      placeholder="Code"                      
                      value="<?php echo e($card->code ?? old('code')); ?>"
                      required/>
                      <div class="invalid-feedback">Please enter card code</div>
                  </div>
                </div>
              </div>
              <div class="col-6">
                <div class="col-12">
                  <div class="mb-1">
                    <label class="form-label">Note</label>
                    <textarea
                      class="form-control
                      <?php $__errorArgs = ['note'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                      "
                      name="note"
                      placeholder="Note"
                      rows="4"
                    ><?php echo e($card->note ?? old('note')); ?></textarea>
                  </div>
                </div>
              </div>
            </div>
            <?php if(in_array($cardType,['shift','build'])): ?>
              <?php echo $__env->make("main.card.$cardType", \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            <?php else: ?>
              <h3 class="text-danger">This card type is not supported</h3>
            <?php endif; ?>
            <div class="col-12">
              <button type="submit" class="btn btn-primary me-1">Submit</button>
              <?php if(isset($card) && !is_null($card)): ?>
                <a href="<?php echo e(route('card.show',['id'=>$card->id])); ?>"
                  class="btn btn-outline-secondary"> 
                  Cancel
                </a>
              <?php else: ?>
                <button type="reset" class="btn btn-outline-secondary">Reset</button>
              <?php endif; ?>
            </div>
        </div>
      </div>
    </div>
  </div>
  </form>
</section>

    
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
  <!-- Page js files -->
  <script src="<?php echo e(asset(mix('js/scripts/forms/form-validation.js'))); ?>"></script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/card/create.blade.php ENDPATH**/ ?>