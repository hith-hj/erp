@extends('layouts/contentLayoutMaster')

@section('title', __('locale.Manufacturing'))

@section('content')
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <table class="table table-sm table-borderd">
                            <thead>
                                <tr>
                                    <th>{{ __('locale.Material') }}</th>
                                    <td>{{ $manufacturing->material?->name }}</td>
                                </tr>
                                <tr>
                                    <th>{{ __('locale.Inventory') }}</th>
                                    <td> {{ $manufacturing->inventory?->name }} </td>
                                </tr>
                                <tr>
                                    <th>{{ __('locale.Bill') }}</th>
                                    <td> {{ $manufacturing->bill?->serial }} </td>
                                </tr>
                                <tr>
                                    <th>{{ __('locale.Quantity') }}</th>
                                    <td> {{ $manufacturing->quantity }} </td>
                                </tr>
                                <tr>
                                    <th>{{ __('locale.Cost') }}</th>
                                    <td> {{ $manufacturing->cost }} </td>
                                </tr>
                                <tr>
                                    <th>{{ __('locale.Created at') }}</th>
                                    <td> {{ $manufacturing->created_at->diffForHumans() }} </td>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
