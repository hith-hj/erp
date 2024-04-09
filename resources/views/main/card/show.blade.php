@extends('layouts/contentLayoutMaster')

@section('title', 'Card List')

@section('content')
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                {{-- <div class="card mb-4">
                    <div class="card-header">
                        <h4 class="card-title">{{ $card->name }}</h4>

                        <div class="btn-group">
                            <i id="card{{ $card->code }}DropDown" data-bs-toggle="dropdown" data-feather="more-vertical"
                                class="font-medium-3 cursor-pointer dropdown-toggle"></i>
                            <div class="dropdown-menu" aria-labelledby="card{{ $card->code }}DropDown">
                                <a href="{{ url('user/show', ['id' => $card->user_id]) }}" class="dropdown-item">owner</a>
                                <a href="{{ url('section/show', ['id' => $card->section_id]) }}"
                                    class="dropdown-item">Section</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="card-subtitle text-muted mb-1">{{ $card->code }}</div>
                        <p class="card-text">
                            {{ $card->note }}
                        </p>
                        <a href="{{ url('card/show', ['id' => $card->id]) }}" class="card-link">Edit</a>
                        <a href="{{ url('card/show', ['id' => $card->id]) }}" class="card-link color-danger">Delete</a>
                    </div>
                </div> --}}
                @include('main.card.baseCard',['index'=>'show'])
            </div>
        </div>
    </section>
@endsection
