

<?php $__env->startSection('title', 'Card List'); ?>

<?php $__env->startSection('content'); ?>
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e($currency->name); ?></h4>
                        <div class="btn-group">
                            <i id="card<?php echo e($currency->code); ?>DropDown" data-bs-toggle="dropdown" data-feather="more-vertical"
                                class="font-medium-3 cursor-pointer dropdown-toggle"></i>
                            <div class="dropdown-menu" aria-labelledby="card<?php echo e($currency->code); ?>DropDown">
                                <button form="deleteCurrencyForm" type="submit" class="btn btn-danger" >
                                    <?php echo e(__('locale.Delete')); ?>

                                </button>
                                <form id="deleteCurrencyForm" method="post" 
                                    action="<?php echo e(route('currency.delete',['id'=>$currency->id])); ?>">
                                    <?php echo csrf_field(); ?>
                                    <?php echo method_field('delete'); ?>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-subtitle text-muted mb-1"><?php echo e($currency->code); ?></div>
                        <?php $__empty_1 = true; $__currentLoopData = $currency->rates; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $rate): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <p class="card-text">
                                Rate To : <?php echo e($rate->name); ?> 
                                - Is Equal : <?php echo e($rate->pivot->rate); ?>

                            </p>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <p>no rates for this curency</p>
                        <?php endif; ?>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <h4><?php echo e(__('locale.Add Rate')); ?></h4>
                            <form method="POST"
                                action="<?php echo e(route('currency.rates.store', ['currency_id' => $currency->id])); ?>">
                                <?php echo csrf_field(); ?>
                                <div class="col-12">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-1">
                                                <label class="form-label"
                                                    for="phone_number"><?php echo e(__('locale.Currency')); ?></label>
                                                <select id="material_list" name="to_id" required class=" form-select">
                                                    <option value="">Chose Material</option>
                                                    <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                        <option value="<?php echo e($currency->id); ?>">
                                                            <?php echo e($currency->name); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-1">
                                                <label class="form-label" for="rate"><?php echo e(__('locale.Rate')); ?></label>
                                                <input type="text" id="rate" name="rate"
                                                    class="form-control <?php $__errorArgs = ['rate'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                    placeholder="<?php echo e(__('locale.Rate')); ?>" required />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="">
                                    <button type="submit"
                                        class="btn btn-outline-primary w-100 "><?php echo e(__('locale.Store')); ?></button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/currency/show.blade.php ENDPATH**/ ?>