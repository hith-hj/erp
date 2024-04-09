
<ul class="dropdown-menu" data-bs-popper="none">
  <?php if(isset($menu)): ?>
  <?php $__currentLoopData = $menu; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $submenu): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
  <?php
  $custom_classes = "";
  if(isset($submenu->classlist)) {
    $custom_classes = $submenu->classlist;
  }
  ?>

  <li class="<?php echo e($custom_classes); ?> <?php echo e((isset($submenu->submenu)) ? 'dropdown dropdown-submenu' : ''); ?> <?php echo e($submenu->slug === Route::currentRouteName() ? 'active' : ''); ?>" <?php if(isset($submenu->submenu)): ?><?php echo e('data-menu=dropdown-submenu'); ?><?php endif; ?>>
    <a href="<?php echo e(isset($submenu->url) ? url($submenu->url):'javascript:void(0)'); ?>" class="dropdown-item <?php echo e((isset($submenu->submenu)) ? 'dropdown-toggle' : ''); ?> d-flex align-items-center"
      <?php echo e((isset($submenu->submenu)) ? 'data-bs-toggle=dropdown' : ''); ?> target="<?php echo e(isset($submenu->newTab) && $submenu->newTab === true  ? '_blank':'_self'); ?>">
      <?php if(isset($submenu->icon)): ?>
      <i data-feather="<?php echo e($submenu->icon); ?>"></i>
      <?php endif; ?>
      <span><?php echo e(__('locale.'.$submenu->name)); ?></span>
    </a>
    <?php if(isset($submenu->submenu)): ?>
    <?php echo $__env->make('panels/horizontalSubmenu', ['menu' => $submenu->submenu], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
  </li>
  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  <?php endif; ?>
</ul>
<?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/panels/horizontalSubmenu.blade.php ENDPATH**/ ?>