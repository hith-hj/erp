

<?php $__env->startSection('title', 'Card List'); ?>

<?php $__env->startSection('content'); ?>
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                
                <?php echo $__env->make('main.card.baseCard',['index'=>'show'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/card/show.blade.php ENDPATH**/ ?>