<!-- Edit User Modal -->
<div class="modal fade" id="addItem" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
        <div class="modal-content">
            <div class="modal-body">
                <?php echo $__env->make('utils.purchase_form', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            </div>
        </div>
    </div>
</div><?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/utils/bill_purchase_modal.blade.php ENDPATH**/ ?>