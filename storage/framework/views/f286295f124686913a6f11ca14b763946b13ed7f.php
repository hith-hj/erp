

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
                            <?php echo e(__('locale.Name')); ?> :
                            <?php echo e($client->first_name. ' ' .$client->last_name); ?>

                        </h4>
                        <div class="card-text">
                            <?php echo e(__('locale.Email')); ?> : 
                            <?php echo e($client->email); ?>

                        </div>
                        <div class="card-text">
                            <?php echo e(__('locale.Phone')); ?> : 
                            <?php echo e($client->phone); ?>

                        </div>
                        <div class="card-text">
                            <?php echo e(__('locale.Created at')); ?>

                            <?php echo e($client->created_at->diffForHumans()); ?>

                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th><?php echo e(__('locale.Bill')); ?></th>
                                    <th><?php echo e(__('locale.Currency')); ?></th>
                                    <th><?php echo e(__('locale.Transfers')); ?></th>
                                    <th><?php echo e(__('locale.Total')); ?></th>
                                    <th><?php echo e(__('locale.Payed')); ?></th>
                                    <th><?php echo e(__('locale.Remaining')); ?></th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                <?php
                                    $sales = 0;
                                    $total = 0;
                                    $remaining = 0;
                                ?>
                                <?php $__empty_1 = true; $__currentLoopData = $client->sales; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sale): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                    <?php
                                        $sales += 1;
                                        $total += $sale->total();
                                        $remaining += $sale->bill->transaction->remaining;
                                        ?>
                                    <tr>
                                        <td><?php echo e($sale->id); ?></td>
                                        <td><?php echo e($sale->bill->serial); ?></td>
                                        <td><?php echo e($sale->currency->name); ?></td>
                                        <td><?php echo e($sale->bill->transaction->transfers()->count()); ?></td>
                                        <td><?php echo e($sale->total()); ?></td>
                                        <td><?php echo e($total - $remaining); ?></td>
                                        <td><?php echo e($sale->bill->transaction->remaining); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                    <tr>
                                        <td>
                                            <span class="badge badge-light-info me-1">
                                                Not sales yet
                                            </span>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                            <tr class="text-primary border-primary">
                                <th> <?php echo e(__('locale.Sales')); ?> : <?php echo e($sales); ?></th>
                                <td></td>
                                <th> <?php echo e(__('locale.Total')); ?> : <?php echo e($total); ?></th>
                                <td></td>
                                <th> <?php echo e(__('locale.Payed')); ?> : <?php echo e($total - $remaining); ?></th>
                                <td></td>
                                <th> <?php echo e(__('locale.Remaining')); ?> : <?php echo e($remaining); ?></th>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/client/show.blade.php ENDPATH**/ ?>