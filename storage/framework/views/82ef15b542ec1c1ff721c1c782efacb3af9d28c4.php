

<?php $__env->startSection('title', 'Media Player'); ?>

<?php $__env->startSection('vendor-style'); ?>
  <!-- vendor css files -->
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/extensions/plyr.min.css'))); ?>">
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-style'); ?>
  <!-- Page css files -->
  <link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/extensions/ext-component-media-player.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<!-- Media Player -->
<section id="media-player-wrapper">
  <div class="row">
    <!-- VIDEO -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Video</h4>
          <div class="video-player" id="plyr-video-player">
            <iframe src="https://www.youtube.com/embed/bTqVqk7FSmY" allowfullscreen allow="autoplay"></iframe>
          </div>
        </div>
      </div>
    </div>
    <!--/ VIDEO -->

    <!-- AUDIO -->
    <div class="col-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title">Audio</h4>
          <audio id="plyr-audio-player" class="audio-player" controls>
            <source
              src="https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.mp3"
              type="audio/mp3"
            />
            <source
              src="https://cdn.plyr.io/static/demo/Kishi_Bashi_-_It_All_Began_With_a_Burst.ogg"
              type="audio/ogg"
            />
          </audio>
        </div>
      </div>
    </div>
    <!--/ AUDIO -->
  </div>
</section>
<!--/ Media Player -->
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
  <!-- vendor files -->
  <script src="<?php echo e(asset(mix('vendors/js/extensions/plyr.min.js'))); ?>"></script>
  <script src="<?php echo e(asset(mix('vendors/js/extensions/plyr.polyfilled.min.js'))); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
  <!-- Page js files -->
  <script src="<?php echo e(asset(mix('js/scripts/extensions/ext-component-media-player.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views//content/extensions/ext-component-media-player.blade.php ENDPATH**/ ?>