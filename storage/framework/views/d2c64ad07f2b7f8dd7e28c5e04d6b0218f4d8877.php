

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.New Purchase')); ?>

<?php $__env->stopSection(); ?>
<?php if(request()->old()): ?>
    
<?php endif; ?>
<?php $__env->startSection('content'); ?>
    <section id="multiple-column-form" x-data="{
        currencies: <?php echo e($currencies->keyBy('id')->toJson()); ?>,
    }">
        <form id="inventory_form" method="POST" action="<?php echo e(route('purchase.store')); ?>" class="form form-vertical">

            <?php echo csrf_field(); ?>
            <div class="row">
                <div class="col-12">
                    <div class="card"
                        x-data='
                    {
                        ml:0,
                        cost:0,
                        from:0,
                        to:0,
                        rate:0,
                        total:0,
                        setMl(id){return this.ml=id},
                        setFrom(id){return this.from = id},
                        setTotal(id){
                            this.total = 0;
                            this.to = id;
                            Object.keys(this.currencies[this.from].rates).forEach(rate => {
                                if(this.currencies[this.from].rates[rate].id == this.to)
                                {
                                    return this.rate = this.currencies[this.from].rates[rate].pivot.rate;
                                }
                            })                            
                            return this.total = this.cost * this.rate;
                        },
                    }
                    '>
                        <?php if($errors->any()): ?>
                            <div class="alert alert-danger m-1">
                                <ul class="m-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="pb-1"><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <div class="card-header">
                            <h4 class="card-title"><?php echo e(__('locale.New Purchase')); ?></h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="account"><?php echo e(__('locale.Account')); ?></label>
                                        <select id="account" name="account" required class="form-select" >
                                            <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                            <?php $__currentLoopData = $accounts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $account): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                
                                                <option value="<?php echo e($account['id']); ?>" 
                                                    <?php if(old('account') == $account['id']): ?> selected <?php endif; ?>>
                                                    <?php echo e($account['name']); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="vendor"><?php echo e(__('locale.Vendor')); ?></label>
                                        <select id="vendor" name="vendor" required 
                                            class="form-select <?php $__errorArgs = ['vendor'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                            <?php $__currentLoopData = $vendors; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $vendor): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($vendor['id']); ?>"
                                                    <?php if(old('vendor') == $vendor['id']): ?> selected <?php endif; ?>>
                                                    <?php echo e($vendor['name']); ?>

                                                </option>
                                                
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="inventory_list"><?php echo e(__('locale.Inventory')); ?></label>
                                        <select id="inventory_list" name="inventory_id" required 
                                            class="form-select" <?php $__errorArgs = ['inventory_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                            <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                            <?php $__currentLoopData = $inventories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $inventory): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($inventory->id); ?>"
                                                    <?php if(old('inventory_id') == $inventory->id ): ?> selected <?php endif; ?>>
                                                    <?php echo e($inventory->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="material_list"><?php echo e(__('locale.Materials')); ?></label>
                                        <select x-model="ml" id="material_list" name="material_id" required
                                            class="form-select" <?php $__errorArgs = ['material_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>>
                                            <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                            <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($material->id); ?>"
                                                    <?php if(old('material_id') == $material->id ): ?> selected <?php endif; ?>>
                                                    <?php echo e($material->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label"
                                            for="material_quantity"><?php echo e(__('locale.Quantity')); ?></label>
                                        <input type="number" id="material_quantity" name="quantity"
                                            class="form-control <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="<?php echo e(__('locale.Quantity')); ?>" value="<?php echo e(old('quantity')); ?>" required />
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-1">
                                        <label class="form-label" for="units_list"><?php echo e(__('locale.Units')); ?></label>
                                        <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <template x-if="ml == <?php echo e($material->id); ?>">
                                                <select id="units_list" name="unit_id" required 
                                                    class="form-select <?php $__errorArgs = ['unit_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> ">
                                                    <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                                    <?php $__empty_1 = true; $__currentLoopData = $material->units; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $unit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                                        <option value="<?php echo e($unit->id); ?>"
                                                            <?php if(old('unit_id') == $unit->id ): ?> selected <?php endif; ?>>
                                                            <?php echo e($unit->name); ?> | <?php echo e($unit->pivot->is_default ? 'default' : ''); ?>

                                                        </option>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                                        <option>No Units Available</option>
                                                    <?php endif; ?>
                                                </select>
                                            </template>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <template x-if="ml == 0">
                                            <select class="form-select ">
                                                <option value="">Chose Material First</option>
                                            </select>
                                        </template>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="cost"><?php echo e(__('locale.Cost')); ?></label>
                                        <input type="number" id="cost" name="cost"
                                            class="form-control <?php $__errorArgs = ['cost'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            placeholder="<?php echo e(__('locale.Cost')); ?>" value="<?php echo e(old('cost')); ?>" required x-model="cost" />
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="currency"><?php echo e(__('locale.Currency')); ?></label>
                                        <select id="currency" x-model="from" x-init="$watch('from', value => setFrom(value))" name="currency_id"
                                            required class=" form-select <?php $__errorArgs = ['currency_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($currency->id); ?>"
                                                    <?php if(old('currency_id') == $currency->id ): ?> selected <?php endif; ?>>
                                                    <?php echo e($currency->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="rate_to"><?php echo e(__('locale.Rate')); ?></label>
                                        <select x-model="to" name="rate_to" 
                                            class="form-select <?php $__errorArgs = ['rate_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            x-init="$watch('to', value => setTotal(value))" required> 
                                            <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                            <?php $__currentLoopData = $currencies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $currency): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($currency->id); ?>">
                                                    <?php echo e($currency->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="mb-1">
                                        <label class="form-label" for="total"><?php echo e(__('locale.Total')); ?></label>
                                        <input type="number" id="total" name="total"
                                            class="form-control <?php $__errorArgs = ['total'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required readonly
                                            value="" x-model="total" value="<?php echo e(old('total')); ?>"/>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-1">
                                        <label for="note" class="form-label"><?php echo e(__('locale.Note')); ?></label>
                                        <input name="note" id="note" placeholder="<?php echo e(__('locale.Note')); ?>" class="form-control">
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-1">
                                        <label for="mark" class="form-label"><?php echo e(__('locale.Mark')); ?></label>
                                        <select id="mark" name="mark" required 
                                            class="form-select <?php $__errorArgs = ['mark'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                            <option value="0"  
                                            <?php if(old('mark') == 0 ): ?> selected <?php endif; ?>><?php echo e(__('locale.None')); ?></option>
                                            <option value="1" 
                                            <?php if(old('mark') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('locale.Audited')); ?></option>
                                            <option value="2" 
                                            <?php if(old('mark') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('locale.Checked')); ?></option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-1">
                                        <label for="level" class="form-label"><?php echo e(__('locale.Level')); ?></label>
                                        <select id="level" name="level" required 
                                            class="form-select <?php $__errorArgs = ['level'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                            <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                            <option value="0"
                                            <?php if(old('level') == 0 ): ?> selected <?php endif; ?>><?php echo e(__('locale.None')); ?></option>
                                            <option value="1"
                                            <?php if(old('level') == 1 ): ?> selected <?php endif; ?>><?php echo e(__('locale.Closed')); ?></option>
                                            <option value="2"
                                            <?php if(old('level') == 2 ): ?> selected <?php endif; ?>><?php echo e(__('locale.Secret')); ?></option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                            <div class="col-12">
                                <button typex="submit"
                                    class="btn btn-primary btn-sm w-25"><?php echo e(__('locale.Store')); ?></button>
                                <button type="reset"
                                    class="btn btn-outline-primary btn-sm"><?php echo e(__('locale.Reset')); ?></button>
                                <a
                                    href="<?php echo e(url('/')); ?>"class="btn btn-outline-dark btn-sm"><?php echo e(__('locale.Cancel')); ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </section>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('vendor-script'); ?>
    <script src="<?php echo e(asset(mix('vendors/js/forms/select/select2.full.min.js'))); ?>"></script>
<?php $__env->stopSection(); ?>
<?php $__env->startSection('page-script'); ?>
    <script src="<?php echo e(asset(mix('js/scripts/forms/form-select2.js'))); ?>"></script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/purchase/create.blade.php ENDPATH**/ ?>