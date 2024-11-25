@extends('layouts.tableLayout')

@section('title')
    {{ __('locale.Sale') }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="row">
            <div class="col-12">
                <div class="card mb-4">
                    <div class="card-header p-1">
                        <div class="card-head row w-100">
                            <div class="col-2">
                                <button
                                    class="btn btn-sm  btn-primary w-100 {{ $sale->bill->status == 0 ?: 'disabled' }}"
                                    data-bs-toggle="modal" type="button" data-bs-target="#addItem">
                                    {{ __('locale.Add Item') }}
                                </button>
                                <div class="modal fade" id="addItem" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                                        <div class="modal-content">
                                            <div class="modal-body p-0">
                                                @include('utils.sale_new_material_form')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 px-auto">
                                <button type="button"
                                    class="btn btn-sm btn-success
                                    {{ $sale->bill->status == 0 && $sale->materials()->count() > 0 ?: 'disabled' }}"
                                    onclick="document.getElementById('saveSaleForm').submit();">
                                    {{ __('locale.Save') }}
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary 
                                    {{ $sale->bill->status == 1 ? 'btn-primary' : 'disabled' }}"
                                    onclick="document.getElementById('checkSaleForm').submit();">
                                    {{ __('locale.Check') }}
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-outline-primary 
                                    {{ $sale->bill->status == 2 ? 'btn-primary' : 'disabled' }}"
                                    onclick="document.getElementById('auditSaleForm').submit();">
                                    {{ __('locale.Audit') }}
                                </button>
                                <button type="button"
                                    class="btn btn-sm btn-outline-danger 
                                    {{ $sale->bill->status == 0 ?: 'disabled' }}"
                                    onclick="document.getElementById('deleteSaleForm').submit();">
                                    {{ __('locale.Delete') }}
                                </button>
                                <form hidden id="saveSaleForm" method="POST"
                                    action="{{ route('sale.save', ['id' => $sale->id]) }}">
                                    @csrf
                                </form>
                                <form hidden id="checkSaleForm" method="POST"
                                    action="{{ route('sale.check', ['id' => $sale->id]) }}">
                                    @csrf
                                </form>
                                <form hidden id="auditSaleForm" method="POST"
                                    action="{{ route('sale.audit', ['id' => $sale->id]) }}">
                                    @csrf
                                </form>
                                <form hidden id="deleteSaleForm" method="POST"
                                    action="{{ route('sale.delete', ['id' => $sale->id]) }}">
                                    @csrf @method('delete')
                                </form>
                            </div>
                            <div class="col-4 row">
                                <div class="col-4">
                                    @php
                                        $color = match ($sale->bill->status) {
                                            0 => 'danger',
                                            1 => 'success',
                                            2 => 'info',
                                            default => 'primary',
                                        };
                                    @endphp
                                    <span class="badge badge-light-{{ $color }}">
                                        {{ $sale->bill->get_status }}
                                    </span>
                                </div>
                                <div class="col-4">
                                    <span class="badge badge-light-info ">
                                        {{ __('locale.Mark') }} {{ $sale->mark }}
                                    </span>
                                </div>
                                <div class="col-4">
                                    <span class="badge badge-light-info ">
                                        {{ __('locale.Level') }} {{ $sale->level }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body px-1">
                        <div class="table-responsive" style="min-height:5rem">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>{{ __('locale.Bill') }}</th>
                                        <th>{{ __('locale.Client') }}</th>
                                        <th>{{ __('locale.Inventory') }}</th>
                                        <th>{{ __('locale.Currency') }}</th>
                                        <th>{{ __('locale.User') }}</th>
                                        <th>{{ __('locale.Created at') }}</th>
                                        <th>{{ __('locale.Discount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>{{ $sale->bill?->serial }}</td>
                                        <td>{{ $sale->client?->fullName }}</td>
                                        <td>{{ $sale->inventory?->name }}</td>
                                        <td>{{ $sale->currency->name }}</td>
                                        <td>{{ $sale->user?->username }}</td>
                                        <td>{{ $sale->created_at->format('Y-m-d') }}</td>
                                        <td>{{ $sale->discount }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="table-responsive" style="min-height:10rem">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>{{ __('locale.Material') }}</th>
                                        <th>{{ __('locale.Quantity') }}</th>
                                        <th>{{ __('locale.Unit') }}</th>
                                        <th>{{ __('locale.Cost') }}</th>
                                        <th>{{ __('locale.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sale->materials as $material)
                                        <tr>
                                            <td>{{ $material->id }}</td>
                                            <td>{{ $material->name }}</td>
                                            <td>{{ $material->pivot->quantity }}</td>
                                            <td>{{ $material->pivot->unit?->name }}</td>
                                            <td>{{ $material->pivot->cost }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                        data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item"
                                                            onclick="document.getElementById('saleDeleteMaterial').submit();">
                                                            <i data-feather="trash" class="me-50"></i>
                                                            <span>Delete</span>
                                                        </a>
                                                        <form id="saleDeleteMaterial"
                                                            action="{{ route('sale.deleteMaterial', ['id' => $sale->id]) }}"
                                                            method="POST">
                                                            @csrf @method('delete')
                                                            <input type="hidden" name="material_id" value="{{$material->id}}">
                                                        </form>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="d-flex gap-1 pt-1">
                            <span>{{ __('locale.Note') }} :</span>
                            <p class="m-0">{{ $sale->note }}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@section('page-script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"></script>
<script>
    $(document).ready(function() {
        $(function() {
            'use strict';
            $('.items-repeater').repeater({
                isFirstItemUndeletable: true,
                initEmpty: false,
                show: function() {
                    $(this).slideDown();
                },
                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },
            });
        });
    });
</script>
@endsection