@extends('layouts.tableLayout')

@section('title')
    {{ __('locale.Purchase') }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="table-responsive" style="min-height:10rem">
                        <table class="table table-sm">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>Bill</th>
                                    <th>Vendor</th>
                                    <th>Inventory</th>
                                    <th>Material</th>
                                    <th>Quantity</th>
                                    <th>Unit</th>
                                    <th>Cost</th>
                                    <th>Currency</th>
                                    <th>Discount</th>
                                    <th>Note</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{{ $purchase->id }}</td>
                                    <td>{{ $purchase->bill_id }}</td>
                                    <td>{{ $purchase->vendor?->full_name }}</td>
                                    <td>{{ $purchase->inventory?->name }}</td>
                                    <td>{{ $purchase->material?->name }}</td>
                                    <td>{{ $purchase->quantity }}</td>
                                    <td>{{ $purchase->unit?->name }}</td>
                                    <td>{{ $purchase->cost }}</td>
                                    <td>{{ $purchase->currency?->name }}</td>
                                    <td>{{ $purchase->discount }}</td>
                                    <td>{{ $purchase->note }}</td>
                                    <td><span class="badge rounded-pill badge-light-success me-1">Active</span></td>
                                    <td>
                                        <div class="dropdown">
                                            <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                data-bs-toggle="dropdown">
                                                <i data-feather="more-vertical"></i>
                                            </button>
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <a class="dropdown-item" 
                                                    onclick="document.getElementById('deletePurchaseForm').submit();">
                                                    <i data-feather="trash" class="me-50"></i>
                                                    <span>Delete</span>
                                                </a>
                                                <form 
                                                    id="deletePurchaseForm"
                                                    action="{{route('purchase.delete',['purchase'=>$purchase->id])}}"
                                                    method="POST"
                                                    >
                                                    @csrf @method('delete')
                                                </form>
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
