@section('title')
    {{__('locale.'.Str::ucfirst( Str::plural(explode('/',request()->path())[0]) )) }}
@endsection
@section('table')
    <section id="basic-datatable">
        <div class="row">
            <div class="col-12">
                <div class="card p-1">
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