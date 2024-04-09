<div class="row">
    <div class="card-header">
        <h4 class="card-title">Shift Details</h4>
    </div>
    <div class="col-6">
      <div class="col-12">
          <div class="mb-1">
              <label class="form-label" for="card-name">Shift Type</label>
              <input type="text" id="card-name" class="form-control
              <?php $__errorArgs = ['shift_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              " name="shift_type" placeholder="Name" required 
              value="<?php echo e($card->shift->shift_type ?? old('shift_type')); ?>"/>
              <div class="invalid-feedback">Please enter Shift Type.</div>
          </div>
      </div>
      <div class="col-12">
          <div class="mb-1">
              <label class="form-label" for="card-code">Shift Name</label>
              <input type="text" id="card-code" class="form-control
              <?php $__errorArgs = ['shift_name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
              " name="shift_name" placeholder="Code" required 
              value="<?php echo e($card->shift->shift_name ?? old('shift_name')); ?>"/>
              <div class="invalid-feedback">Please enter Shift Name</div>
          </div>
      </div>
  </div>
  <div class="col-6">
    <div class="col-12">
        <div class="mb-1">
            <label class="form-label" for="card-name">Start Time</label>
            <input type="time" id="card-name" class="form-control
            <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            " name="start_time" placeholder="Name" required
            value="<?php echo e($card->shift->start_time ?? old('start_time')); ?>" />
            <div class="invalid-feedback">Please enter start Time.</div>
        </div>
    </div>
    <div class="col-12">
        <div class="mb-1">
            <label class="form-label" for="card-code">End Time</label>
            <input type="time" id="card-code" class="form-control
            <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            " name="end_time" placeholder="Code" required 
            value="<?php echo e($card->shift->end_time ?? old('end_time')); ?>"/>
            <div class="invalid-feedback">Please enter End Time.</div>
        </div>
    </div>
  </div>
</div>
<?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/card/shift.blade.php ENDPATH**/ ?>