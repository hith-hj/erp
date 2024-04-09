<div class="card-header">
  <h4 class="card-title">Build Details</h4>
</div>
<div class="row">
<div class="col-6">
    <div class="col-12">
        <div class="mb-1">
            <label class="form-label" for="card-name">Build Name</label>
            <input type="text" id="card-name" class="form-control" name="build_name" placeholder="Name" required 
            value="<?php echo e(old('shift_type')); ?>"/>
        </div>
    </div>
</div>
<div class="col-6">
    <div class="col-12">
        <div class="mb-1">
            <label class="form-label" for="card-code">Inventory Name </label>
            <input type="text" id="card-code" class="form-control" name="shift_name" placeholder="Code" required 
            value="<?php echo e(old('shift_name')); ?>"/>
            <div class="invalid-feedback">Please enter Shift Name</div>
        </div>
    </div>
</div>
<div class="col-12">
    <div class="mb-1">
        <label class="form-label" for="card-name">Select Materials</label>
        <select class="form-select" name="type" id="" onchange="ShowMatTable(value)">
            <option value="" >Choes Type</option>
            <option value="base">Base</option>
            <option value="manu">Manufactured</option>
        </select>
    </div>
</div>
</div>

<div class="col-12 hidden " id="tablesParent">
    <div class="card">
    <div class="card-header">
        <h4 class="card-title">Material Details</h4>
        <h4 class="card-title" >
            Add New Material 
            <i class="text-xl" data-feather='plus-square'></i>
        </h4>
    </div>
    <div class="table-responsive">
        <table id="BaseMatTable" class="table table-bordered table-sm hidden">
        <thead>
            <tr id="BaseMatHeader">
            <th>Name</th>
            <th>Unit</th>
            <th>quantity</th>
            <th>inventory</th>
            <th>Cost</th>
            </tr>
        </thead>
        <tbody id="BaseMatBody">
            <tr>
            <td><input type="text" name="" class="form-control form-sm" ></td>
            <td><input type="text" name="" class="form-control form-sm" ></td>
            <td><input type="text" name="" class="form-control form-sm" ></td>
            <td><input type="text" name="" class="form-control form-sm" ></td>
            <td><input type="text" name="" class="form-control form-sm" ></td>
            </tr>
        </tbody>             
        </table>
        <table id="ManuMatTable" class="table table-bordered table-sm hidden">   
        <thead id="ManuMatHeader">
            <tr >
            <th>Name</th>
            <th>Unit</th>
            <th>Cost</th>
            </tr>
        </thead>
        <tbody id="ManuMatBody">
            <tr>
            <td><input type="text" name="" class="form-control" ></td>
            <td><input type="text" name="" class="form-control" ></td>
            <td><input type="text" name="" class="form-control" ></td>
            </tr>
        </tbody>
        </table>
    </div>
    </div>
</div>

<script>
    function ShowMatTable(value){
        let base = document.getElementById('BaseMatTable');
        let manu = document.getElementById('ManuMatTable');
        let container = document.getElementById('tablesParent');
        if(value == 'base'){
            base.classList.remove('hidden')
            container.classList.remove('hidden')
            manu.classList.add('hidden')
        }else if(value == 'manu'){
            manu.classList.remove('hidden')
            container.classList.remove('hidden')
            base.classList.add('hidden')
        }else{
            container.classList.add('hidden')
            base.classList.add('hidden')
            manu.classList.add('hidden')
        }
    }

</script>
<?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/card/build.blade.php ENDPATH**/ ?>