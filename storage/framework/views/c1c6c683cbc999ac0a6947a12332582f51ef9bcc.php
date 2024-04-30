

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.New Inventory')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section id="multiple-column-form">
    <form id="inventory_form" method="POST" action="<?php echo e(route('inventory.store')); ?>" class="form form-vertical">
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
                        <h4 class="card-title"><?php echo e(__('locale.New Inventory')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
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
                                         />
                                </div>
                            </div>
                            <h4><?php echo e(__('locale.New Materials')); ?></h4>
                            <div class="col-12 row inventory-materials-repeater">
                                <div data-repeater-list="materials" class="col-10">
                                    <div data-repeater-item class="row">
                                        <div class="col-5">
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="phone_number"><?php echo e(__('locale.Materials')); ?></label>
                                                <select id="material_list" name="material_id"
                                                    class="form-select" required>
                                                    <option value="">Chose Material</option>
                                                    <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($material->id); ?>">
                                                            <?php echo e($material->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="phone_number"><?php echo e(__('locale.Quantity')); ?></label>
                                                <input type="number" name="quantity" id="material_quantity"
                                                    class="form-control <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    placeholder="<?php echo e(__('locale.Quantity')); ?>" required  />
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
                        <div class="col-12">
                            <button type="submit"
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
<?php $__env->startSection('page-script'); ?>
<!-- Page js files -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            'use strict';
            // form repeater jquery
            $('.inventory-materials-repeater').repeater({
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


<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/inventory/create.blade.php ENDPATH**/ ?>