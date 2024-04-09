

<?php $__env->startSection('title', 'Card List'); ?>

<?php $__env->startSection('content'); ?>
    <section id="card-content-types">
        <div class="row">
            <div class="col-md-6 col-lg-12 row">
                <h6 class="my-2 text-muted"><?php echo e(count($cards)); ?>Cards</h6>
                <?php $__empty_1 = true; $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <div class="col-6">
                        <div class="card mb-4">
                            <div class="card-header">
                                <h4 class="card-title"><?php echo e($card->name); ?></h4>

                                <div class="btn-group">
                                    <i id="card<?php echo e($card->code); ?>DropDown" data-bs-toggle="dropdown"
                                        data-feather="more-vertical"
                                        class="font-medium-3 cursor-pointer dropdown-toggle"></i>
                                    <div class="dropdown-menu" aria-labelledby="card<?php echo e($card->code); ?>DropDown">
                                        <a href="<?php echo e(url('user/show', ['id' => $card->user_id])); ?>"
                                            class="dropdown-item">owner</a>
                                        <a href="<?php echo e(url('section/show', ['id' => $card->section_id])); ?>"
                                            class="dropdown-item">Section</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="card-subtitle text-muted mb-1"><?php echo e($card->code); ?></div>
                                <p class="card-text">
                                    <?php echo e($card->note); ?>

                                </p>
                                <a href="<?php echo e(url('card/show', ['id' => $card->id])); ?>" class="card-link">View</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <h6 class="my-2 text-muted">No Cards Yet</h6>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/cards/index.blade.php ENDPATH**/ ?>