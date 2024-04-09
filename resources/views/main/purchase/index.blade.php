@extends('layouts.tableLayout')
@section('title'){{__('locale.Purchase')}}@endsection
@section('table')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card p-1">
                    <div class="card-head">
                        <a href="{{route('purchase.create')}}"
                        class="btn btn-primary w-100">{{__('locale.Create New')}}</a>
                    </div>
                    <div class="card-body px-0">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
@push('scripts')
    {{ $dataTable->scripts(attributes: ['type' => 'module']) }}
@endpush