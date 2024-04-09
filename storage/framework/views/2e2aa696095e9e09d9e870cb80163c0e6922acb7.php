<?php $__env->startSection('title', 'Leaflet Maps'); ?>

<?php $__env->startSection('vendor-style'); ?>
  <!-- vendor css files -->
  <link rel="stylesheet" href="<?php echo e(asset(mix('vendors/css/maps/leaflet.min.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('page-style'); ?>
 <link rel="stylesheet" href="<?php echo e(asset(mix('css/base/plugins/maps/map-leaflet.css'))); ?>">
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<section class="maps-leaflet">
  <div class="row">
    <!-- Basic Starts -->
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header">
          <h4 class="card-title">Basic Map</h4>
        </div>
        <div class="card-body">
          <div class="leaflet-map" id="basic-map"></div>
        </div>
      </div>
    </div>
    <!-- /Basic Ends -->

    <!-- Marker Circle & Polygon Starts -->
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header">
          <h4 class="card-title">Marker Circle & Polygon</h4>
        </div>
        <div class="card-body">
          <div class="leaflet-map" id="shape-map"></div>
        </div>
      </div>
    </div>
    <!-- /Marker Circle & Polygon Ends -->

    <!-- Draggable Marker With Popup Starts -->
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header">
          <h4 class="card-title">Draggable Marker With Popup</h4>
        </div>
        <div class="card-body">
          <div class="leaflet-map" id="drag-map"></div>
        </div>
      </div>
    </div>
    <!-- /Draggable Marker With Popup Ends -->

    <!-- User Location Starts -->
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header">
          <h4 class="card-title">User Location</h4>
        </div>
        <div class="card-body">
          <div class="leaflet-map" id="user-location"></div>
        </div>
      </div>
    </div>
    <!-- /User Location Ends -->

    <!-- Custom Icons Starts -->
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header">
          <h4 class="card-title">Custom Icons</h4>
        </div>
        <div class="card-body">
          <div class="leaflet-map" id="custom-icons"></div>
        </div>
      </div>
    </div>
    <!-- /Custom Icons Ends -->

    <!-- GeoJson Starts -->
    <div class="col-12">
      <div class="card mb-4">
        <div class="card-header">
          <h4 class="card-title">GeoJson</h4>
        </div>
        <div class="card-body">
          <div class="leaflet-map" id="geojson"></div>
        </div>
      </div>
    </div>
    <!-- /GeoJson Ends -->

    <!-- Layer Control Starts -->
    <div class="col-12">
      <div class="card">
        <div class="card-header">
          <h4 class="card-title">Layer Control</h4>
        </div>
        <div class="card-body">
          <div class="leaflet-map" id="layer-control"></div>
        </div>
      </div>
    </div>
    <!-- /Layer Control Ends -->
  </div>
</section>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('vendor-script'); ?>
  <!-- vendor files -->
  <script src="<?php echo e(asset(mix('vendors/js/maps/leaflet.min.js'))); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
  <!-- Page js files -->
  <script src="<?php echo e(asset(mix('js/scripts/maps/map-leaflet.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views//content/charts-maps/maps-leaflet.blade.php ENDPATH**/ ?>