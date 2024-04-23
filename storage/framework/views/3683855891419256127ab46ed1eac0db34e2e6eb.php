<!-- Edit User Modal -->
<div class="modal fade" id="addItem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content" x-data="{
            currencies: <?php echo e($currencies->keyBy('id')->toJson()); ?>,
        }">
            
            <div class="modal-body">
                <form id="purchase_form" method="POST" action="<?php echo e(route('purchase.store')); ?>" class="form form-vertical">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="bill_id" value="<?php echo e($bill->id); ?>">
                    <div x-data="{
                        currencies: <?php echo e($currencies->keyBy('id')->toJson()); ?>,
                        materials: <?php echo e($materials->keyBy('id')->toJson()); ?>

                    }" class="purchases-repeater">
                        
                        <div data-repeater-list="purchases" class="row">
                            <div data-repeater-item class="col-12">
                                <div class="card"
                                    x-data='
                                    {
                                        material_id:0,
                                        currency_id:0,
                                        rate_to:0,
                                        cost:0,
                                        total:0,
                                        materialUnits:{},
                                        currencyRates:{},
                                        setMaterialUnits(id){
                                            this.materialUnits = this.materials[id].units;
                                        },
                                        setCurrencyRates(id){
                                            this.currencyRates = this.currencies[id].rates;
                                        },
                                        setTotal(id){
                                            this.total = 0;
                                            Object.keys(this.currencyRates).forEach(rate => {
                                                if(this.currencyRates[rate].id == id)
                                                {
                                                    return this.total = (this.cost * this.currencyRates[rate].pivot.rate).toFixed(4);
                                                }
                                            }) 
                                        },
                                    }'>
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
                                    <div class="card-body pb-0">
                                        <div class="row">
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
                                                            <option value="<?php echo e($vendor->id); ?>">
                                                                <?php echo e($vendor->full_name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="discount"><?php echo e(__('locale.Discount')); ?></label>
                                                    <input type="number" id="discount" name="discount"
                                                        class="form-control <?php $__errorArgs = ['discount'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        placeholder="<?php echo e(__('locale.Discount')); ?>" value="<?php echo e(old('discount')); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="inventory_list"><?php echo e(__('locale.Inventory')); ?></label>
                                                    <select id="inventory_list" name="inventory_id" required class="form-select"
                                                        <?php $__errorArgs = ['inventory_id'];
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
                                                                <?php if(old('inventory_id') == $inventory->id): ?> selected <?php endif; ?>>
                                                                <?php echo e($inventory->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="material_list"><?php echo e(__('locale.Materials')); ?></label>
                                                    <select x-model="material_id" id="material_list" name="material_id" required
                                                        class="form-select" <?php $__errorArgs = ['material_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                                        x-init="$watch('material_id', value => setMaterialUnits(value))">
                                                        <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                                        <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($material->id); ?>"
                                                                <?php if(old('material_id') == $material->id): ?> selected <?php endif; ?>>
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
                                                        placeholder="<?php echo e(__('locale.Quantity')); ?>" value="<?php echo e(old('quantity')); ?>"
                                                        required />
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="mb-1">
                                                    <label class="form-label" for="units_list"><?php echo e(__('locale.Units')); ?></label>
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
                                                        <template x-for="unit in materialUnits" :key="unit.id">
                                                            <option x-bind:value="unit.id" x-text="unit.name"></option>
                                                        </template>
                                                    </select>
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
                                                        placeholder="<?php echo e(__('locale.Cost')); ?>" value="<?php echo e(old('cost')); ?>" required
                                                        x-model="cost" />
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="currency"><?php echo e(__('locale.Currency')); ?></label>
                                                    <select id="currency" name="currency_id" required x-model="currency_id"
                                                        x-init="$watch('currency_id', value => setCurrencyRates(value))"
                                                        class="form-select <?php $__errorArgs = ['currency_id'];
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
                                                                <?php if(old('currency_id') == $currency->id): ?> selected <?php endif; ?>>
                                                                <?php echo e($currency->name); ?>

                                                            </option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-1">
                                                    <label class="form-label" for="rate_to"><?php echo e(__('locale.Rate')); ?></label>
                                                    <select x-model="rate_to" name="rate_to"
                                                        class="form-select <?php $__errorArgs = ['rate_to'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                        x-init="$watch('rate_to', value => setTotal(value))" required>
                                                        <option value=""><?php echo e(__('locale.Chose')); ?></option>
                                                        <template x-for="(rate,index) in currencyRates" :key="rate.id">
                                                            <option x-bind:value="rate.id" x-text="rate.name">
                                                            </option>
                                                        </template>
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
                                                        value="" x-model="total" value="<?php echo e(old('total')); ?>" />
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="mb-1">
                                                    <label for="note" class="form-label"><?php echo e(__('locale.Note')); ?></label>
                                                    <input name="note" id="note" placeholder="<?php echo e(__('locale.Note')); ?>"
                                                        class="form-control">
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
                                                        <option value="0" <?php if(old('mark') == 0): ?> selected <?php endif; ?>>
                                                            <?php echo e(__('locale.None')); ?>

                                                        </option>
                                                        <option value="1" <?php if(old('mark') == 1): ?> selected <?php endif; ?>>
                                                            <?php echo e(__('locale.Audited')); ?>

                                                        </option>
                                                        <option value="2" <?php if(old('mark') == 2): ?> selected <?php endif; ?>>
                                                            <?php echo e(__('locale.Checked')); ?>

                                                        </option>
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
                                                        <option value="">
                                                            <?php echo e(__('locale.Chose')); ?>

                                                        </option>
                                                        <option value="0" <?php if(old('level') == 0): ?> selected <?php endif; ?>>
                                                            <?php echo e(__('locale.None')); ?>

                                                        </option>
                                                        <option value="1" <?php if(old('level') == 1): ?> selected <?php endif; ?>>
                                                            <?php echo e(__('locale.Closed')); ?>

                                                        </option>
                                                        <option value="2" <?php if(old('level') == 2): ?> selected <?php endif; ?>>
                                                            <?php echo e(__('locale.Secret')); ?>

                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12 p-1">
                                        <button type="button" class="btn btn-danger w-100" data-repeater-delete>
                                            <?php echo e(__('locale.Delete')); ?>

                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-6">
                                        <button type="button" class="btn btn-primary w-100" data-repeater-create>
                                            <?php echo e(__('locale.Add')); ?>

                                        </button>
                                    </div>
                                    <div class="col-6">
                                        <button typex="submit"
                                            class="btn btn-primary w-25">
                                            <?php echo e(__('locale.Store')); ?>

                                        </button>
                                        <button type="reset"
                                            class="btn btn-outline-primary">
                                            <?php echo e(__('locale.Reset')); ?>

                                        </button>
                                        <a href="<?php echo e(url('/')); ?>"class="btn btn-outline-dark">
                                            <?php echo e(__('locale.Cancel')); ?>

                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/utils/bill_purchase_modal.blade.php ENDPATH**/ ?>