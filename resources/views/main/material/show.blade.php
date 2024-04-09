@extends('layouts/contentLayoutMaster')

@section('title')
    {{-- {{ __('locale.Show') }} {{ __('locale.Material') }} --}}
    {{ $material->name }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="card-head mb-1 row">
            <h4 class="col-10">{{ __('locale.Show') }}</h4>
            <div class="col-2">
                <button class="btn btn-sm btn-outline-danger w-100">{{ __('locale.Delete') }}</button>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h5>{{__('locale.Details')}}</h5>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">{{ $material->name }}</h4>
                        <div class="card-text">
                            {{ $material->type() }}
                        </div>
                        <p class="card-text">
                            {{ $material->created_at->diffForHumans() }}
                        </p>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>{{__('locale.Name')}}</th>
                                    <th>{{__('locale.Code')}}</th>
                                    <th>{{__('locale.Is Default')}}</th>
                                    <th>{{__('locale.Created at')}}</th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                @forelse ($material->units as $unit)
                                    <tr>
                                        <td>{{ $unit->id }}</td>
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ $unit->symbol }}</td>
                                        <td>
                                            <span class="badge rounded-pill badge-light-success me-1">
                                                {{ $unit->pivot->is_default ? 'default' : '' }}
                                            </span>
                                        </td>
                                        <td>{{ $unit->pivot->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="table-responsive h-100" style="min-height: 15rem">
                    <h5>{{__('locale.Inventories')}}</h5>
                    <div class="card">
                        <div class="card-body">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>{{__('locale.Inventory')}}</th>
                                        <th>{{__('locale.Quantity')}}</th>
                                        <th>{{__('locale.Status')}}</th>
                                        <th>{{__('locale.Options')}}</th>
                                    </tr>
                                </thead>
                                <tbody class="table-hover">
                                    @forelse ($material->inventories as $inventory)
                                        <tr>
                                            <td>{{ $inventory->id }}</td>
                                            <td>{{ $inventory->name }}</td>
                                            <td>{{ $inventory->pivot->quantity }}</td>
                                            <td>
                                                <span class="badge rounded-pill badge-light-success me-1">
                                                    {{ $inventory->pivot->status == 1 ? 'active' : 'inactive' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button type="button"
                                                        class="btn btn-sm dropdown-toggle hide-arrow py-0"
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
                                    @empty
                                    @endforelse

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
