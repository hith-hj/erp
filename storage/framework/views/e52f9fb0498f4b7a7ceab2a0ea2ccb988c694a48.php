

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.Inventory') . ' - ' . $inventory->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
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
        <div class="card-header pb-0 d-flex">
            <div class="div">
                <h3><?php echo e($inventory->name); ?></h3>
            </div>
            <div class="div">
                <?php if($inventory->is_default == true): ?>
                    <span class="badge  badge-light-success">
                        <?php echo e(__('locale.Default')); ?>

                    </span>
                <?php else: ?>
                    <button class="btn btn-outline-info" form="setDefaultInventroyForm">
                        <?php echo e(__('locale.Default')); ?>

                    </button>
                    <form action="<?php echo e(route('inventory.setDefault',['id'=>$inventory->id])); ?>" 
                        id="setDefaultInventroyForm" method="post">
                        <?php echo csrf_field(); ?>
                    </form>
                <?php endif; ?>
            </div>
        </div>
        <div class="card-body">
            <h4><?php echo e(__('locale.Add')); ?> <?php echo e(__('locale.Material')); ?></h4>
            <div class="row">
                <form method="POST" action="<?php echo e(route('inventory.material.store', ['inventory_id' => $inventory->id])); ?>">
                    <?php echo csrf_field(); ?>
                    <div class="row px-1 inventory-materials-repeater">
                        <div data-repeater-list="materials" class="col-10 p-0">
                            <div data-repeater-item class="row">
                                <div class="col-5">
                                    <div class="mb-1">
                                        <label class="form-label" for="">
                                            <?php echo e(__('locale.Materials')); ?>

                                        </label>
                                        <select id="material_list" name="material_id" 
                                            class="form-select" required>
                                            <option value=""><?php echo e(__('locale.Chose')); ?></option>
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
                                        <label class="form-label" for="">
                                            <?php echo e(__('locale.Quantity')); ?>

                                        </label>
                                        <input type="number" min="1" name="quantity" id="material_quantity"
                                            class="form-control <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="<?php echo e(__('locale.Quantity')); ?>" required />
                                    </div>
                                </div>
                                <div class="col-2 p-0" data-repeater-delete>
                                    <div class="mb-1">
                                        <label class="form-label" for="rate"><?php echo e(__('locale.Delete')); ?></label>
                                        <button type="button" class="btn btn-icon btn-danger w-100">
                                            <span><?php echo e(__('locale.Delete')); ?></span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-2 p-0" data-repeater-create>
                            <div class="mb-1">
                                <label class="form-label" for="rate"><?php echo e(__('locale.Add')); ?></label>
                                <button type="button" class="btn btn-icon btn-outline-primary w-100">
                                    <span><?php echo e(__('locale.Add')); ?></span>
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <button  type="submit"
                            class="btn btn-primary w-100"><?php echo e(__('locale.Store')); ?></button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <?php echo e($dataTable->table()); ?>

                    </div>
                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('scripts'); ?>
    <?php echo e($dataTable->scripts(attributes: ['type' => 'module'])); ?>

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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.tableLayout', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/inventory/show.blade.php ENDPATH**/ ?>