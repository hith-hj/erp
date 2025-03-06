

<?php $__env->startSection('title'); ?>
    
    <?php echo e($client->first_name); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <section id="card-content-types">
        <div class="card-head mb-1 row">
            <h4 class="col-10"><?php echo e(__('locale.Show')); ?></h4>
            <div class="col-2">
                <button class="btn btn-sm btn-outline-danger w-100" 
                    onclick="
                        if(confirm('<?php echo e(__('locale.Delete')); ?> ?')){
                            document.getElementById('deleteClientForm').submit();
                        }
                    " >
                    <?php echo e(__('locale.Delete')); ?>

                </button>
                <form id="deleteClientForm" 
                    method="Post" 
                    action="<?php echo e(route('client.delete',['client'=>$client->id])); ?>">
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
                            <?php echo e(__('locale.First name')); ?> :
                            <?php echo e($client->first_name); ?>

                        </h4>
                        <div class="card-text">
                            <?php echo e(__('locale.Last name')); ?> : 
                            <?php echo e($client->last_name); ?>

                        </div>
                        <div class="card-text">
                            <?php echo e(__('locale.Email')); ?> : 
                            <?php echo e($client->email); ?>

                        </div>
                        <div class="card-text">
                            <?php echo e(__('locale.Phone')); ?> : 
                            <?php echo e($client->phone); ?>

                        </div>
                        <p class="card-text">
                            <?php echo e(__('locale.Created at')); ?>

                            <?php echo e($client->created_at->diffForHumans()); ?>

                        </p>
                    </div>
                    <?php echo e($client->sales); ?>

                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th><?php echo e(__('locale.Name')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                    <tr>
                                        <td>
                                            <span class="badge rounded-pill badge-light-success me-1">
                                               something
                                            </span>
                                        </td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/client/show.blade.php ENDPATH**/ ?>