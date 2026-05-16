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
                                    class="btn btn-sm  btn-primary w-100 {{ $sale->bill?->status == 0 ?: 'disabled' }}"
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
                            <div class="col-2">
                                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown"
                                    aria-haspopup="true">
                                    <i class="ficon"data-feather="dots-vertical"></i>
                                    {{__('locale.Options')}}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-1" aria-labelledby="dropdown-flag">
                                    <button type="button" class="btn btn-sm btn-success
                                        {{ $sale->bill?->status == 0 && $sale->materials()->count() > 0 ?: 'disabled' }}"
                                        onclick="document.getElementById('savePurchaseForm').submit();">
                                        {{ __('locale.Save') }}
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary
                                        {{ $sale->bill?->status == 1 ? 'btn-primary' : 'disabled' }}"
                                        onclick="document.getElementById('checkPurchaseForm').submit();">
                                        {{ __('locale.Check') }}
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-primary
                                        {{ $sale->bill?->status == 2 ? 'btn-primary' : 'disabled' }}"
                                        onclick="document.getElementById('auditPurchaseForm').submit();">
                                        {{ __('locale.Audit') }}
                                    </button>
                                    <button type="button" class="btn btn-sm btn-outline-danger
                                        {{ $sale->bill?->status == 0 ?: 'disabled' }}"
                                        onclick="document.getElementById('deletePurchaseForm').submit();">
                                        {{ __('locale.Delete') }}
                                    </button>
                                </div>

                                <form hidden id="savePurchaseForm" method="POST"
                                    action="{{ route('sale.save', ['id' => $sale->id]) }}">
                                    @csrf
                                </form>
                                <form hidden id="checkPurchaseForm" method="POST"
                                    action="{{ route('sale.check', ['id' => $sale->id]) }}">
                                    @csrf
                                </form>
                                <form hidden id="auditPurchaseForm" method="POST"
                                    action="{{ route('sale.audit', ['id' => $sale->id]) }}">
                                    @csrf
                                </form>
                                <form hidden id="deletePurchaseForm" method="POST"
                                    action="{{ route('sale.delete', ['id' => $sale->id]) }}">
                                    @csrf @method('delete')
                                </form>
                            </div>
                            <div class="col-2">
                                <a class="nav-link dropdown-toggle" id="dropdown-flag" href="#"
                                    data-bs-toggle="dropdown" aria-haspopup="true">
                                    <i class="ficon"data-feather="dots-vertical"></i>
                                    {{__('locale.Status')}}
                                </a>
                                <div class="dropdown-menu dropdown-menu-end p-1" aria-labelledby="dropdown-flag">
                                    @php
                                        $color = match ($sale->bill?->status) {
                                            0 => 'danger',
                                            1 => 'success',
                                            2 => 'info',
                                            default => 'primary',
                                        };
                                    @endphp
                                    <button class="btn btn-sm btn-outline-{{ $color }} text-{{ $color }}">
                                        {{ $sale->bill?->get_status }}
                                    </button>
                                    <button class="btn btn-sm btn-outline-info text-info ">
                                        {{ __('locale.Mark') }} {{ $sale->mark }}
                                    </button>
                                    <button class="btn btn-sm btn-outline-info text-info ">
                                        {{ __('locale.Level') }} {{ $sale->level }}
                                    </button>
                                </div>
                            </div>

                            <div class="col-6 d-flex gap-1">
                                @php
                                    $transaction = $sale->bill->transaction;
                                @endphp

                                @if($sale->bill->status !== 0 && $transaction === null)
                                    <button class='btn btn-sm btn-outline-warning' type="button"
                                    data-bs-toggle='modal' data-bs-target='#billTransfer{{$sale->bill->id}}'>
                                        <i class="ficon" data-feather="plus"></i>
                                        {{__('locale.Transfer') }}
                                    </button>

                                    <div class='modal fade' id='billTransfer{{$sale->bill->id}}' aria-hidden='true'>
                                        <div class='modal-dialog modal-sm modal-dialog-centered modal-edit-user'>
                                            <div class='modal-content'>
                                                <div class='modal-header'>
                                                    <h4>{{__('locale.Transfer Amount')}}</h4>
                                                </div>
                                                <div class='modal-body p-0'>
                                                    <form id='transfer_form' method='POST' action='{{ route('cashier.billTransaction') }}'
                                                        class='form form-vertical'>
                                                        @csrf
                                                        <input type='hidden' name='bill_id' value='{{ $sale->bill->id }}'>
                                                        <div>
                                                            <div class='card mb-1'>
                                                                <div class='card-body p-0 px-1'>
                                                                    <div class='row'>
                                                                        <div class='col-6'>
                                                                            <div class='mb-1'>
                                                                                <label class='form-label' for='amount'>{{__('locale.Cashier')}}</label>
                                                                                <select name="cashier_id" id="" class="form-select" required>
                                                                                    @if($sale->bill->transaction == null)
                                                                                        @forelse ($cashiers as $cashier)
                                                                                            <option value="{{$cashier->id}}" {{$cashier->is_default ? 'selected' : ''}}  >
                                                                                                {{$cashier->name}}
                                                                                            </option>
                                                                                        @empty
                                                                                            <option disabled class='border-danger text-danger' title="add cashier first">
                                                                                                {{__('locale.Not Found')}}
                                                                                            </option>
                                                                                        @endforelse
                                                                                    @else
                                                                                        <option value="{{$sale->bill->transaction->cashier->id}}">
                                                                                            {{$sale->bill->transaction->cashier->name}}
                                                                                        </option>
                                                                                    @endif
                                                                                </select>
                                                                            </div>
                                                                        </div>
                                                                        <div class='col-6'>
                                                                            <div class='mb-1'>
                                                                                <label class='form-label' for='amount'>{{__('locale.Amount')}}</label>
                                                                                <input type='number' name='amount' min='0' id='amount'
                                                                                    class='form-control' required {{count($cashiers) == 0 ? 'disabled':''}}>
                                                                            </div>
                                                                        </div>
                                                                        <div class='col-12'>
                                                                            <button typex='submit' class='btn btn-primary'>
                                                                                {{__('locale.Store')}}
                                                                            </button>
                                                                            <button type='reset' class='btn btn-outline-primary'>
                                                                                {{__('locale.Reset')}}
                                                                            </button>
                                                                            <a class='btn btn-outline-dark' data-bs-dismiss='modal' aria-label='Close'>
                                                                                {{__('locale.Cancel')}}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if ($transaction !== null  && count($transaction->transfers) > 0 && $transaction->remaining > 0)
                                    <button class="btn btn-sm btn-outline-success" type="button"
                                        data-bs-toggle="modal" data-bs-target="#addTransfer{{ $transaction->id }}">
                                        <i class="ficon" data-feather="list"></i>
                                        {{ __('locale.Add') }}
                                    </button>

                                    <div class="modal fade" id="addTransfer{{ $transaction->id }}"
                                        tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-sm modal-dialog-centered modal-edit-user">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>{{__('locale.Transfer Amount')}}</h4>
                                                </div>
                                                <div class="modal-body p-0">
                                                    <form id="transfer_form" method="POST"
                                                        action="{{ route('cashier.transfer', $transaction->cashier->id) }}"
                                                        class="form form-vertical">
                                                        @csrf
                                                        <input type="hidden" name="transaction_id"
                                                            value="{{ $transaction->id }}">
                                                        <div>
                                                            <div class="card mb-1">
                                                                <div class="card-body p-0 px-1">
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            <div class="mb-1">
                                                                                <label class="form-label"
                                                                                    for="amount">{{ __('locale.Amount') }}</label>
                                                                                <input type="number"
                                                                                    name="amount"
                                                                                    min="0"
                                                                                    id="amount"
                                                                                    class="form-control">
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-12">
                                                                            <button typex="submit"
                                                                                class="btn btn-primary">
                                                                                {{ __('locale.Store') }}
                                                                            </button>
                                                                            <a class="btn btn-outline-dark"
                                                                                data-bs-dismiss="modal"
                                                                                aria-label="Close">
                                                                                {{ __('locale.Cancel') }}
                                                                            </a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                @if($transaction !== null  && count($transaction->transfers) > 0)
                                    <button class="btn btn-sm btn-outline-info" type="button"
                                    data-bs-toggle="modal" data-bs-target="#transaction{{ $transaction->id }}Transfers">
                                        {{ __('locale.Transfers') }}
                                        <i class="ficon"data-feather='list'></i>
                                    </button>

                                    <div class="modal fade" id="transaction{{ $transaction->id }}Transfers" aria-hidden="true">
                                        <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h4>
                                                        {{ __('locale.Transfers') }}
                                                    </h4>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="card">
                                                        <div class="card-header">
                                                            <h4 class="card-title">
                                                                {{ __('locale.Type') }} :
                                                                {{ $transaction->getType() }}
                                                            </h4>
                                                            <div class="card-text">
                                                                {{ __('locale.Is Payed') }} :
                                                                {{ $transaction->remaining == 0 ? __('locale.Is Payed') : '-' }}
                                                            </div>
                                                            <div class="card-text">
                                                                {{ __('locale.Amount') }} :
                                                                {{ $transaction->amount }}
                                                            </div>
                                                            <div class="card-text">
                                                                {{ __('locale.Remaining') }} :
                                                                {{ $transaction->remaining }}
                                                            </div>
                                                            <div class="card-text">
                                                                {{ __('locale.Transfers') }} :
                                                                {{ $transaction->transfers()->count() }}
                                                            </div>
                                                            <div class="card-text">
                                                                {{ __('locale.Created at') }}
                                                                {{ $transaction->created_at->diffForHumans() }}
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <table class="table table-sm table-bordered">
                                                                <thead>
                                                                    <tr>
                                                                        <th>Id</th>
                                                                        <th>{{ __('locale.Amount') }}</th>
                                                                        <th>{{ __('locale.Created at') }}</th>
                                                                    </tr>
                                                                </thead>
                                                                <tbody class="table-hover">
                                                                    @forelse ($transaction->transfers as $transfer)
                                                                        <tr>
                                                                            <td>{{ $transfer->id }}</td>
                                                                            <td>{{ $transfer->amount }}</td>
                                                                            <td>{{ $transfer->created_at->diffForHumans() }}</td>
                                                                        </tr>
                                                                    @empty
                                                                    @endforelse
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
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
                                        <th>{{ __('locale.Total') }}</th>
                                        <th>{{ __('locale.User') }}</th>
                                        <th>{{ __('locale.Created at') }}</th>
                                        <th>{{ __('locale.Discount') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>{{ $sale->id }}</td>
                                        <td>
                                            <a href="{{route('bill.show',$sale->bill?->id)}}"
                                                target="__blanck">
                                                {{ $sale->bill?->serial }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('client.show',$sale->client?->id)}}"
                                                target="__blanck">
                                                {{ $sale->client?->fullName }}
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{route('inventory.show',$sale->inventory?->id)}}"
                                                target="__blanck">
                                                {{ $sale->inventory?->name }}
                                            </a>
                                        </td>
                                        <td>{{ $sale->currency->name }}</td>
                                        <td>{{ $sale->total() }}</td>
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
                                        <th>{{ __('locale.Total') }}</th>
                                        <th>{{ __('locale.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($sale->materials as $material)
                                        <tr>
                                            <td>{{ $material->id }}</td>
                                            <td>
                                                <a href="{{route('material.show',$material->id)}}"
                                                target="__blank">
                                                    {{ $material->name }}
                                                </a>
                                            </td>
                                            <td>{{ $material->pivot->quantity }}</td>
                                            <td>{{ $material->pivot->unit?->name }}</td>
                                            <td>{{ $material->pivot->cost }}</td>
                                            <td>{{ $material->pivot->cost * $material->pivot->quantity  }}</td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                                        data-bs-toggle="dropdown">
                                                        <i data-feather="more-vertical"></i>
                                                    </button>
                                                    <div class="dropdown-menu dropdown-menu-end">
                                                        <a class="dropdown-item {{ $sale->bill?->status == 0 ? '' : 'disabled' }}"
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
