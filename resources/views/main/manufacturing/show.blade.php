@extends('layouts/contentLayoutMaster')

@section('title', 'Manufacturing')

@section('content')
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="card-subtitle text-muted mb-1">{{ $manufacturing->material?->name }}</div>
                        <p >inventory : {{ $manufacturing->inventory?->name }}</p>
                        <p >bill : {{ $manufacturing->bill?->serial }}</p>
                        <p >quantity : {{ $manufacturing->quantity }}</p>
                        <p >cost : {{ $manufacturing->cost }}</p>
                        <p > manufactured at {{ $manufacturing->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
