@extends('layouts.tableLayout')

@section('title')
    {{ __('locale.Purchase') }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Account</th>
                                    <th>Vendor</th>
                                    <th>Inventory</th>
                                    <th>Material</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Cost</th>
                                    <th>Currency</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>{{ $purchase->account }}</td>
                                    <td>{{ $purchase->vendor }}</td>
                                    <td>{{ $purchase->inventory->name }}</td>
                                    <td>{{ $purchase->material->name }}</td>
                                    <td>{{ $purchase->quantity }}</td>
                                    <td>{{ $purchase->unit->name }}</td>
                                    <td>{{ $purchase->cost }}</td>
                                    <td>{{ $purchase->currency->name }}</td>
                                    <td><span class="badge rounded-pill badge-light-success me-1">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                data-bs-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" href="#">
                                                    <i data-feather="edit-2" class="me-50"></i>
                                                    <span>Edit</span>
                                                </a>
                                                <a class="dropdown-item" href="#">
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
