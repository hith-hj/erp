

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.New Inventory')); ?>

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>

<section id="multiple-column-form">
    <form id="inventory_form" method="POST" action="<?php echo e(route('inventory.store')); ?>" class="form form-vertical">
        <?php echo csrf_field(); ?>
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger m-1">
                            <ul class="m-0">
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li class="p-1"><?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <div class="card-header">
                        <h4 class="card-title"><?php echo e(__('locale.New Inventory')); ?></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="mb-1">
                                    <label class="form-label" for="fullname"><?php echo e(__('locale.Name')); ?></label>
                                    <input type="text" id="name"
                                        class="form-control <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="name"
                                        placeholder="<?php echo e(__('locale.Name')); ?>" value="<?php echo e(old('name')); ?>" required
                                        tabindex="1" />
                                </div>
                            </div>
                            <h4><?php echo e(__('locale.New Materials')); ?></h4>
                            <div class="col-12">
                                <div class="row">
                                    <div class="col-4">
                                        <div class="mb-1">
                                            <label class="form-label"
                                                for="phone_number"><?php echo e(__('locale.Materials')); ?></label>
                                            <select id="material_list" tabindex="2"required class=" form-select">
                                                <option value="">Chose Material</option>
                                                <?php $__currentLoopData = $materials; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $material): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <option value="<?php echo e($material->id); ?>">
                                                        <?php echo e($material->name); ?>

                                                    </option>
                                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-1">
                                            <label class="form-label"
                                                for="phone_number"><?php echo e(__('locale.Quantity')); ?></label>
                                            <input type="number" id="material_quantity"
                                                class="form-control <?php $__errorArgs = ['quantity'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-danger <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                                placeholder="<?php echo e(__('locale.Quantity')); ?>" required tabindex="3" />
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="mb-1">
                                            <label class="form-label" for="phone_number"><?php echo e(__('locale.Add')); ?></label>
                                            <span class="btn btn-outline-primary w-100" onclick="addMaterial(event)">
                                                <?php echo e(__('locale.New Material')); ?>

                                            </span>
                                        </div>
                                    </div>
                                </div>

                                <div id="materials" class="hiddenx my-1 row mx-0">
                                    <div class="col-1 p-1 border">
                                        id
                                    </div>
                                    <div class="col-5 p-1 border">
                                        <?php echo e(__('locale.Material Name')); ?>

                                    </div>
                                    <div class="col-5 p-1 border">
                                        <?php echo e(__('locale.Material Quantity')); ?> 
                                    </div>
                                    <div class="col-1 p-1 border">
                                        <?php echo e(__('locale.Options')); ?>

                                    </div>
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
<script>
    // let form = document.querySelector("#inventory_form");
    let material = document.querySelector("#material_list");
    let quantity = document.querySelector("#material_quantity");
    let materials_div = document.querySelector("#materials");

    function addMaterial(event) {
        if (material.selectedIndex == 0 || quantity.value == 0) {
            return;
        }
        materials_div.classList.remove('hidden');
        let id = displayMaterial();
        addInput(id);
    }

    function addInput(id) {
        let div = document.querySelector(`#${id}`);
        let input_id = 'matInp_' + material.selectedIndex;
        if (document.querySelector("#" + input_id) != null) {
            let input = document.querySelector("#" + input_id);
            input.value = quantity.value;
            return;
        }
        let input = document.createElement('input');
        input.id = input_id
        input.type = 'hidden';
        input.name = "materials[" + material.options[material.selectedIndex].value + "]";
        input.value = quantity.value;
        div.appendChild(input);
    }

    function displayMaterial() {
        let matDiv_id = 'matDiv_' + material.selectedIndex;
        if (document.querySelector("#quantity_" + matDiv_id) != null) {
            let matDiv = document.querySelector("#quantity_" + matDiv_id);
            matDiv.textContent = quantity.value;
            return;
        }
        let parent = document.createElement('div')
        parent.id = matDiv_id;
        parent.setAttribute('class', 'col-12 row mx-0 p-0')

        let id_div = document.createElement('div');
        let name_div = document.createElement('div');
        let quantiy_div = document.createElement('div');
        let delete_div = document.createElement('div');

        id_div.setAttribute('class', 'col-1 p-1 border');
        name_div.setAttribute('class', 'col-5 p-1 border');
        quantiy_div.setAttribute('class', 'col-5 p-1 border');
        quantiy_div.setAttribute('id', 'quantity_' + matDiv_id);
        delete_div.setAttribute('class', 'col-1 p-1 border');

        id_div.textContent = material.selectedIndex
        name_div.textContent = material.options[material.selectedIndex].text;
        quantiy_div.textContent = quantity.value;
        delete_div.textContent = 'delete';
        delete_div.setAttribute('onclick', 'deleteMaterial(' + material.selectedIndex + ')');

        parent.appendChild(id_div);
        parent.appendChild(name_div);
        parent.appendChild(quantiy_div);
        parent.appendChild(delete_div);
        materials_div.appendChild(parent);
        console.log(matDiv_id);
        return matDiv_id;
    }

    function deleteMaterial(id) {
        console.log(id);
        let div = document.querySelector("#matDiv_" + id);
        let input = document.querySelector("#matInp_" + id);

        // div.replaceChildren();
        while (div.hasChildNodes()) {
            div.removeChild(div.firstChild);
        }
        input.remove();
        div.remove();
    }
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/inventory/create.blade.php ENDPATH**/ ?>