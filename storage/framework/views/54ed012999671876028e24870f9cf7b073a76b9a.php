

<?php $__env->startSection('title'); ?>
    <?php echo e(__('locale.Profile')); ?>

<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-12">
            <!-- profile -->
            <div class="card">
                <?php if($errors->any()): ?>
                    <div class="alert alert-danger m-1">
                        <ul class="m-0">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class=""><?php echo e($error); ?></li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </div>
                <?php endif; ?>
                <div class="card-header border-bottom py-1">
                    <h4 class="card-title"><?php echo e(__('locale.Profile')); ?></h4>
                </div>
                <div class="card-body py-1">

                    <!-- form -->
                    <form class="validate-form" method="POST" action="<?php echo e(route('user.update', ['id' => $user->id])); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="row">
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountFirstName">
                                    <?php echo e(__('locale.Full Name')); ?></label>
                                <input type="text" class="form-control" id="accountFirstName" name="full_name"
                                    placeholder="<?php echo e(__('locale.Full Name')); ?>" value="<?php echo e($user->full_name); ?>" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountLastName">
                                    <?php echo e(__('locale.Username')); ?>

                                </label>
                                <input type="text" class="form-control" id="accountLastName" name="username"
                                    placeholder="<?php echo e(__('locale.Username')); ?>" value="<?php echo e($user->username); ?>" readonly />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountEmail">
                                    <?php echo e(__('locale.Email')); ?>

                                </label>
                                <input type="email" class="form-control" id="accountEmail"
                                    placeholder="<?php echo e(__('locale.Email')); ?>" value="<?php echo e($user->email); ?>" readonly />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountPhoneNumber">
                                    <?php echo e(__('locale.Phone')); ?>

                                </label>
                                <input type="text" class="form-control" id="accountPhoneNumber" name="phone_number"
                                    placeholder="<?php echo e(__('locale.Phone')); ?>"
                                    value="<?php echo e($user->getSetting('phone_number')); ?>" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountPhoneNumber">
                                    <?php echo e(__('locale.Phone')); ?> No2
                                </label>
                                <input type="text" class="form-control " id="accountPhoneNumber"name="phone_number_n2"
                                    placeholder="<?php echo e(__('locale.Phone')); ?> No2"
                                    value="<?php echo e($user->getSetting('phone_number_n2')); ?>" />
                            </div>
                            <div class="col-12 col-sm-6 mb-1">
                                <label class="form-label" for="accountAddress">
                                    <?php echo e(__('locale.Address')); ?>

                                </label>
                                <input type="text" class="form-control" id="accountAddress" name="address"
                                    placeholder="<?php echo e(__('locale.Address')); ?>"
                                    value="<?php echo e($user->getSetting('address')); ?>" />
                            </div>
                            <div class="col-12">
                                <button type="submit"
                                    class="btn btn-primary mt-1 w-25"><?php echo e(__('locale.Save Changes')); ?></button>
                                <button type="reset"
                                    class="btn btn-outline-secondary mt-1"><?php echo e(__('locale.Cancel')); ?></button>
                            </div>
                        </div>
                    </form>
                    <!--/ form -->
                </div>
            </div>


            <!-- deactivate account  -->
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title"><?php echo e(__('locale.Change Password')); ?></h4>
                </div>
                <div class="card-body ">
                    <a href='<?php echo e(url("/changePassword/$user->id")); ?>' class="btn btn-outline-primary my-1">
                        <i class="me-50" data-feather="user"></i>
                        <?php echo e(__('locale.Change Password')); ?>

                    </a>
                </div>
            </div>
            <div class="card">
                <div class="card-header border-bottom">
                    <h4 class="card-title"><?php echo e(__('locale.Delete Account')); ?></h4>
                </div>
                <form id="deleteUserForm" action="<?php echo e(route('user.delete', ['user' => $user->id])); ?>" method="POST"><?php echo csrf_field(); ?>
                    <?php echo method_field('delete'); ?></form>
                <div class="card-body ">
                    <button type="submit" class="btn btn-danger deactivate-account my-1"
                        onclick="document.getElementById('deleteUserForm').submit();"><?php echo e(__('locale.Delete Account')); ?></button>
                </div>
            </div>
        </div>
        <!--/ profile -->
    </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts/contentLayoutMaster', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/user/profile.blade.php ENDPATH**/ ?>