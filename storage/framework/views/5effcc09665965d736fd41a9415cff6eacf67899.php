

<?php $__env->startSection('title', 'Card List'); ?>

<?php $__env->startSection('content'); ?>
    <section id="card-content-types">
        <div class="row">
            <div class="col-md-6 col-lg-12 row">
                <h6 class="my-2 text-muted"><?php echo e(count($cards)); ?>-Cards</h6>
                <?php $__empty_1 = true; $__currentLoopData = $cards; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $card): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                    <?php echo $__env->make('main.card.baseCard', ['index' => 'index'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <div class="modal fade text-start" id="card<?php echo e($card->id); ?>" tabindex="-1"
                        aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel4">Delete Card</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are You Sure You want to Delete This.? </p>
                                </div>
                                <div class="modal-footer">
                                    <a href="<?php echo e(route('card.delete', ['id' => $card->id])); ?>">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Accept</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                    <h6 class="my-2 text-muted">No Cards Yet</h6>
                <?php endif; ?>
            </div>
        </div>
        <?php if(isset($cards->links)): ?>
            <?php echo e($cards->links('Utils.paginator')); ?>

        <?php endif; ?>
    </section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/card/index.blade.php ENDPATH**/ ?>