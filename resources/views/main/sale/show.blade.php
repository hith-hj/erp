@extends('layouts.tableLayout')

@section('title')
    {{ __('locale.Sale') }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="table-responsive" style="min-height: 10rem;">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Client</th>
                                    <th>Dis</th>
                                    <th>Inv</th>
                                    <th>Mat</th>
                                    <th>Qut</th>
                                    <th>Unit</th>
                                    <th>Cost</th>
                                    <th>Currency</th>
                                    <th>Created by</th>
                                    <th>date</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $sale->id }}</td>
                                    <td>{{ $sale->client->full_name}}</td>
                                    <td>{{ $sale->discount ?? 0 }}</td>
                                    <td>{{ $sale->inventory->name }}</td>
                                    <td>{{ $sale->material->name }}</td>
                                    <td>{{ $sale->quantity }}</td>
                                    <td>{{ $sale->unit->name }}</td>
                                    <td>{{ $sale->cost }}</td>
                                    <td>{{ $sale->currency->name }}</td>
                                    <td>{{ $sale->user->username }}</td>
                                    <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                                    <td>{{ $sale->note }}</td>
                                    <td><span class="badge rounded-pill badge-light-success me-1">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                data-bs-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="{{route('sale.delete',['sale'=>$sale])}}">
                                                    <i data-feather="trash" class="me-50"></i>
                                                    <span>Delete</span>
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
