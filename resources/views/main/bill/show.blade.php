@extends('layouts.tableLayout')

@section('title')
    {{ __('locale.Bill') }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="card mb-4 p-1">
            <div class="card-head row">
                <div class="col-3">
                    <button class="btn btn-sm  btn-primary w-100 {{ $bill->status == 0 ?: 'disabled' }}"
                        data-bs-toggle="modal" type="button" data-bs-target="#addItem">
                        {{ __('locale.Add Item') }}
                    </button>
                </div>

                <div class="col-6 px-auto">
                    <button type="button"
                        class="btn btn-sm btn-success
                        {{ $bill->status == 0 && $bill->item->materials()->count()>0 ?: 'disabled' }}"
                        onclick="document.getElementById('saveBillForm').submit();">
                        {{ __('locale.Save') }}
                    </button>                    
                    <button type="button"
                        class="btn btn-sm btn-outline-primary 
                        {{ $bill->status == 1 ? 'btn-primary' : 'disabled' }}">
                        {{ __('locale.Check') }}
                    </button>
                    <button type="button"
                        class="btn btn-sm btn-outline-primary 
                        {{ $bill->status == 2 ?: 'disabled' }}">
                        {{ __('locale.Audit') }}
                    </button>
                    <button type="button"
                        class="btn btn-sm btn-outline-danger 
                        {{ $bill->status == 0 ?: 'disabled' }}"
                        onclick="document.getElementById('deleteBillForm').submit();">
                        {{ __('locale.Delete') }}
                    </button>
                </div>

                <div class="col-3 row">
                    <div class="col-4">
                        @if ($bill->type == 1)
                            <span class="badge  badge-light-success ">
                                {{ $bill->get_type }}
                            </span>
                        @else
                            <span class="badge  badge-light-primary">
                                {{ $bill->get_type }}
                            </span>
                        @endif
                    </div>
                    <div class="col-4">
                        @php
                            $color = match ($bill->status) {
                                0 => 'danger',
                                1 => 'success',
                                2 => 'info',
                                default => 'primary',
                            };
                        @endphp
                        <span class="badge badge-light-{{ $color }}">
                            {{ $bill->get_status }}
                        </span>
                    </div>
                </div>
                
                <form id="saveBillForm" method="POST" action="{{ route('bill.save', ['id' => $bill->id]) }}">
                    @csrf
                </form>
                <form id="auditeBillForm" method="POST" action="{{ route('bill.audit', ['id' => $bill->id]) }}">
                    @csrf @method('delete')
                </form>
                <form id="deleteBillForm" method="POST" action="{{ route('bill.delete', ['id' => $bill->id]) }}">
                    @csrf @method('delete')
                </form>
            </div>
            <div class="card-body px-0">
                {{ $dataTable->table() }}
            </div>
            @if ($bill->type == 1)
                @include('utils.bill_purchase_modal')
            @else
                @include('utils.bill_sale_modal')
            @endif
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
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
                    if (confirm(
                            "{{ __('Are you sure you want to delete this element?') }}"
                        )) {
                        $(this).slideUp(deleteElement);
                    }
                },

            });
        });
    });
</script>
@endpush
