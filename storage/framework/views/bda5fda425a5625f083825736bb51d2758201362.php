

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.New Material')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<?php $__env->startSection('vendor-style'); ?>
    <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/forms/select/select2.min.css'))); ?>">
    <link href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/base/jquery-ui.css" rel="stylesheet" />
<?php $__env->stopSection(); ?>

<section id="multiple-column-form">
    <form method="POST" action="<?php echo e(route('material.store')); ?>" class="form form-vertical">
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
                        <h4 class="card-title"><?php echo e(__('locale.New Material')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 row">
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
                                        <label class="form-label" for="type"><?php echo e(__('locale.Type')); ?></label>
                                        <select name="type" tabindex="2" id="type"required
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
                            <div class="col-12 row">
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="main">
                                            <?php echo e(__('locale.Main material')); ?>

                                        </label>
                                        <select name="main_material" tabindex="3" id="main"
                                            class="form-select <?php $__errorArgs = ['main'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value=""><?php echo e(__('locale.None')); ?></option>
                                            <?php $__empty_1 = true; $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                <option value="<?php echo e($material->id); ?>"><?php echo e($material->name); ?></option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                <option value=""><?php echo e(__('locale.None')); ?></option>
                                            <?php endif; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="main_unit">
                                            <?php echo e(__('locale.Main unit')); ?>

                                        </label>
                                        <select name="main_unit" tabindex="2" id="main_unit"required
                                            class="form-select <?php $__errorArgs = ['main_unit'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($unit->id); ?>">
                                                    <?php echo e($unit->code); ?> - <?php echo e(__('locale.' . $unit->name)); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 row units-rates-repeater">
                                <div data-repeater-list="units" class="col-10">
                                    <div data-repeater-item class="row">
                                        <div class="col-5">
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="phone_number"><?php echo e(__('locale.Units')); ?></label>
                                                <select name="unit" tabindex="4"required
                                                    class="form-select <?php $__errorArgs = ['units'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                                    <?php $__currentLoopData = $units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($unit->id); ?>">
                                                            <?php echo e($unit->code); ?> -
                                                            <?php echo e(__('locale.' . $unit->name)); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="rate"><?php echo e(__('locale.Rate')); ?></label>
                                                <input type="number" id="rate"
                                                    class="form-control <?php $__errorArgs = ['rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    name="rate" placeholder="<?php echo e(__('locale.Rate')); ?>"
                                                    value="<?php echo e(old('rate')); ?>" required tabindex="1" />
                                            </div>
                                        </div>
                                        <div class="col-2" data-repeater-delete>
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="rate"><?php echo e(__('locale.Delete')); ?></label>
                                                <button type="button" class="btn btn-icon btn-danger w-100">
                                                    <span><?php echo e(__('locale.Delete')); ?></span>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-2" data-repeater-create>
                                    <div class="mb-1">
                                        <label class="form-label" for="rate"><?php echo e(__('locale.Add')); ?></label>
                                        <button type="button" class="btn btn-icon btn-primary w-100">
                                            <span><?php echo e(__('locale.Add')); ?></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="p-1 pt-0">
                        <button typex="submit" class="btn btn-primary btn-sm w-25">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            'use strict';
            // form repeater jquery
            $('.units-rates-repeater').repeater({
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

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/material/create.blade.php ENDPATH**/ ?>