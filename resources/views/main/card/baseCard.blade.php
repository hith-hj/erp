<div class="col-6">
  <div class="card mb-4">
      <div class="card-header">
          <h4 class="card-title">{{ $card->name }}</h4>
          <div class="btn-group">
              <i id="card{{ $card->code }}DropDown" data-bs-toggle="dropdown"
                  data-featherx="more-vertical"
                  class="font-medium-3 cursor-pointer dropdown-toggle "></i>
              <div class="dropdown-menu" aria-labelledby="card{{ $card->code }}DropDown">
                    <a href="{{ url('user/show', ['id' => $card->user_id]) }}"
                    class="dropdown-item">owner</a>
                    <a href="{{ url('section/show', ['id' => $card->section_id]) }}"
                    class="dropdown-item">Section</a>
                    <a href="{{ route('card.edit',['id'=>$card->id]) }}"          class="dropdown-item">Edit</a>
                    <span class="border-danger dropdown-item" data-bs-toggle="modal" data-bs-target="#card{{$card->id}}">
                        Delete
                      </span>
              </div>
          </div>
      </div>
      <div class="card-body">
          <div class="card-subtitle text-muted mb-1">
            {{ $card->code }} | {{ucfirst( $card->type)}}
          </div>
          <p class="card-text">
              {{ $card->note }}
          </p>
          <span class="card-link">{{$card->created_at->diffForHumans()}}</span>
          @switch($index)
              @case('index')
                <a href="{{ route('card.show',['id'=>$card->id]) }}" class="card-link">View</a>
                  @break
              @case('show')
                <a href="#" class="card-link">Like</a>
                <a href="#" class="card-link">Share</a>
                  @break
              @default
                  
          @endswitch
          
      </div>
  </div>
</div>
