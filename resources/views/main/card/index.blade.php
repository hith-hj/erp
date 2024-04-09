@extends('layouts/contentLayoutMaster')

@section('title', 'Card List')

@section('content')
    <section id="card-content-types">
        <div class="row">
            <div class="col-md-6 col-lg-12 row">
                <h6 class="my-2 text-muted">{{ count($cards) }}-Cards</h6>
                @forelse ($cards as $card)
                    @include('main.card.baseCard', ['index' => 'index'])
                    <div class="modal fade text-start" id="card{{ $card->id }}" tabindex="-1"
                        aria-labelledby="myModalLabel4" data-bs-backdrop="false" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4 class="modal-title" id="myModalLabel4">Delete Card</h4>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are You Sure You want to Delete This.? </p>
                                </div>
                                <div class="modal-footer">
                                    <a href="{{ route('card.delete', ['id' => $card->id]) }}">
                                        <button type="button" class="btn btn-danger"
                                            data-bs-dismiss="modal">Accept</button>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @empty
                    <h6 class="my-2 text-muted">No Cards Yet</h6>
                @endforelse
            </div>
        </div>
        @if(isset($cards->links))
            {{ $cards->links('Utils.paginator') }}
        @endif
    </section>

@endsection
