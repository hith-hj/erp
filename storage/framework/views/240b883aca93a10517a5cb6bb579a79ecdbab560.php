

<?php $__env->startSection('title'); ?>
    
    <?php echo e($material->name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section id="card-content-types">
        <div class="card-head mb-1 row">
            <h4 class="col-10"><?php echo e(__('locale.Show')); ?></h4>
            <div class="col-2">
                <button class="btn btn-sm btn-outline-danger w-100" 
                    onclick="
                        if(confirm('<?php echo e(__('locale.Delete')); ?> ?')){
                            document.getElementById('deleteMaterialForm').submit();
                        }
                    " >
                    <?php echo e(__('locale.Delete')); ?>

                </button>
                <form id="deleteMaterialForm" 
                    method="Post" 
                    action="<?php echo e(route('material.delete',['material'=>$material->id])); ?>">
                    <?php echo csrf_field(); ?> <?php echo method_field('delete'); ?>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h5><?php echo e(__('locale.Details')); ?></h5>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            <?php echo e(__('locale.Name')); ?> :
                            <?php echo e($material->name); ?>

                        </h4>
                        <div class="card-text">
                            <?php echo e(__('locale.Type')); ?> : 
                            <?php echo e($material->type()); ?>

                        </div>
                        <?php if($material->main_material): ?>
                            <div class="card-text">
                                <?php echo e(__('locale.Main material')); ?>: 
                                <?php echo e($material->mainMaterial()->name); ?>

                            </div>
                        <?php endif; ?>
                        <p class="card-text">
                            <?php echo e(__('locale.Created at')); ?>

                            <?php echo e($material->created_at->diffForHumans()); ?>

                        </p>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th><?php echo e(__('locale.Name')); ?></th>
                                    <th><?php echo e(__('locale.Code')); ?></th>
                                    <th><?php echo e(__('locale.Is Default')); ?></th>
                                    <th><?php echo e(__('locale.Main unit')); ?></th>
                                    <th><?php echo e(__('locale.Rate')); ?></th>
                                    <th><?php echo e(__('locale.Created at')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                <?php $__empty_1 = true; $__currentLoopData = $material->units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <tr>
                                        <td><?php echo e($unit->id); ?></td>
                                        <td><?php echo e($unit->name); ?></td>
                                        <td><?php echo e($unit->code); ?></td>
                                        <td>
                                            <span class="badge rounded-pill badge-light-success me-1">
                                                <?php echo e($unit->pivot->is_default ? 'default' : ''); ?>

                                            </span>
                                        </td>
                                        <?php if(! is_null($unit->pivot->main_unit)): ?>
                                            <td><?php echo e($unit->pivot->mainUnitName()); ?></td>
                                        <?php else: ?>
                                            <td>-</td>
                                        <?php endif; ?>
                                        <td><?php echo e($unit->pivot->rate_to_main_unit); ?></td>
                                        <td><?php echo e($unit->pivot->created_at->format('Y-m-d')); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <?php endif; ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="table-responsive h-100" style="min-height: 15rem">
                    <h5><?php echo e(__('locale.Inventories')); ?></h5>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th><?php echo e(__('locale.Inventory')); ?></th>
                                        <th><?php echo e(__('locale.Quantity')); ?></th>
                                        <th><?php echo e(__('locale.Status')); ?></th>
                                        <th><?php echo e(__('locale.Options')); ?></th>
                                    </tr>
                                </thead>
                                <tbody class="table-hover">
                                    <?php $__empty_1 = true; $__currentLoopData = $material->inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                        <tr>
                                            <td><?php echo e($inventory->id); ?></td>
                                            <td><?php echo e($inventory->name); ?></td>
                                            <td><?php echo e($inventory->pivot->quantity); ?></td>
                                            <td>
                                                <span class="badge rounded-pill badge-light-success me-1">
                                                    <?php echo e($inventory->pivot->status == 1 ? 'active' : 'inactive'); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                        data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item" href="#">
                                                            <i data-feather="edit-2" class="me-50"></i>
                                                            <span>Edit</span>
                                                        </a>
                                                        <a class="dropdown-item" href="#">
                                                            <i data-feather="trash" class="me-50"></i>
                                                            <span>Delete</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <?php endif; ?>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/material/show.blade.php ENDPATH**/ ?>