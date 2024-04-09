<div class="col-6">
  <div class="card mb-4">
      <div class="card-header">
          <h4 class="card-title"><?php echo e($card->name); ?></h4>
          <div class="btn-group">
              <i id="card<?php echo e($card->code); ?>DropDown" data-bs-toggle="dropdown"
                  data-featherx="more-vertical"
                  class="font-medium-3 cursor-pointer dropdown-toggle "></i>
              <div class="dropdown-menu" aria-labelledby="card<?php echo e($card->code); ?>DropDown">
                    <a href="<?php echo e(url('user/show', ['id' => $card->user_id])); ?>"
                    class="dropdown-item">owner</a>
                    <a href="<?php echo e(url('section/show', ['id' => $card->section_id])); ?>"
                    class="dropdown-item">Section</a>
                    <a href="<?php echo e(route('card.edit',['id'=>$card->id])); ?>"          class="dropdown-item">Edit</a>
                    <span class="border-danger dropdown-item" data-bs-toggle="modal" data-bs-target="#card<?php echo e($card->id); ?>">
                        Delete
                      </span>
              </div>
          </div>
      </div>
      <div class="card-body">
          <div class="card-subtitle text-muted mb-1">
            <?php echo e($card->code); ?> | <?php echo e(ucfirst( $card->type)); ?>

          </div>
          <p class="card-text">
              <?php echo e($card->note); ?>

          </p>
          <span class="card-link"><?php echo e($card->created_at->diffForHumans()); ?></span>
          <?php switch($index):
              case ('index'): ?>
                <a href="<?php echo e(route('card.show',['id'=>$card->id])); ?>" class="card-link">View</a>
                  <?php break; ?>
              <?php case ('show'): ?>
                <a href="#" class="card-link">Like</a>
                <a href="#" class="card-link">Share</a>
                  <?php break; ?>
              <?php default: ?>
                  
          <?php endswitch; ?>
          
      </div>
  </div>
</div>
<?php /**PATH C:\Users\96393\Desktop\y1s\erp_v1\resources\views/main/card/baseCard.blade.php ENDPATH**/ ?>