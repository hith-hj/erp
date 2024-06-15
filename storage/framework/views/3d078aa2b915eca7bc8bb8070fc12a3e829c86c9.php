<div class="content-header row">
  <?php if (isset($component)) { $__componentOriginal852b5fefbb0d2a45750f1cd335c4e83390b91360 = $component; } ?>
<?php $component = $__env->getContainer()->make(App\View\Components\Trails::class, ['titles' => $titles ?? []]); ?>
<?php $component->withName('Trails'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal852b5fefbb0d2a45750f1cd335c4e83390b91360)): ?>
<?php $component = $__componentOriginal852b5fefbb0d2a45750f1cd335c4e83390b91360; ?>
<?php unset($__componentOriginal852b5fefbb0d2a45750f1cd335c4e83390b91360); ?>
<?php endif; ?>
  <?php if(!request()->is('/') && !request()->is('*/create') && !request()->is('*/show/*') && !request()->is('bill/*') ): ?>
    <div class="content-header-right col-md-3 col-12 mb-2">
      <div class="row ">
        <div class="col-12">
          <?php
           $path = explode('/',request()->path());   
          ?>
          <a href="<?php echo e(url(Str::singular($path[0]).'/create')); ?>" class="btn btn-primary w-100">
            <?php echo e(__('locale.Create')); ?> <?php echo e(__('locale.'.Str::ucfirst($path[0]))); ?>

          </a>
        </div>
      </div>
    </div>
  <?php endif; ?>
</div>
<?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/panels/breadcrumb.blade.php ENDPATH**/ ?>