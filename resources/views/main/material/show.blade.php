@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.Material') }} {{ $material->name }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="d-flex justify-content-between">
            <h4 class=""> {{ $material->name }} {{ __('locale.Material') }} </h4>
            <div class="d-flex justify-content-around">
                <button class="btn btn-sm btn-outline-info w-100 mx-1">
                    {{ __('locale.Edit') }}
                </button>
                <button class="btn btn-sm btn-outline-danger w-100"
                    onclick="
                        if(confirm('{{ __('locale.Delete') }} ?')){
                            document.getElementById('deleteMaterialForm').submit();
                        }
                    ">
                    {{ __('locale.Delete') }}
                </button>
                <form id="deleteMaterialForm" method="Post"
                    action="{{ route('material.delete', ['material' => $material->id]) }}">
                    @csrf @method('delete')
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h3>{{ __('locale.Details') }}</h3>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{ __('locale.Name') }} :
                            {{ $material->name }}
                        </h4>
                        <div class="card-text">
                            {{ __('locale.Type') }} :
                            {{ $material->getType() }}
                        </div>
                        @if ($material->main_material)
                            <div class="card-text">
                                {{ __('locale.Main material') }}:
                                {{ $material->mainMaterial()->name }}
                            </div>
                        @endif
                        <div class="card-text">
                            {{ __('locale.Created at') }}
                            {{ $material->created_at->diffForHumans() }}
                        </div>

                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>{{ __('locale.Name') }}</th>
                                    <th>{{ __('locale.Code') }}</th>
                                    <th>{{ __('locale.Is Default') }}</th>
                                    <th>{{ __('locale.Main unit') }}</th>
                                    <th>{{ __('locale.Rate') }}</th>
                                    <th>{{ __('locale.Created at') }}</th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                @forelse ($material->units as $unit)
                                    <tr>
                                        <td>{{ $unit->id }}</td>
                                        <td>{{ $unit->name }}</td>
                                        <td>{{ $unit->code }}</td>
                                        <td>
                                            <span class="badgex rounded-pill badge-light-success me-1">
                                                {{ $unit->pivot->is_default ? 'default' : '-' }}
                                            </span>
                                        </td>
                                        @if (!is_null($unit->pivot->main_unit))
                                            <td>{{ $unit->pivot->mainUnitName() }}</td>
                                        @else
                                            <td>-</td>
                                        @endif
                                        <td>{{ $unit->pivot->rate_to_main_unit }}</td>
                                        <td>{{ $unit->pivot->created_at->format('Y-m-d') }}</td>
                                    </tr>
                                @empty
                                @endforelse

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            @if ($material->type === 2)
                <div class="col-12">
                    <h3>{{__('locale.Manufacture model')}}</h3>
                    <div class="card">
                        @if (!$material->hasManufactureModel())
                            <div class="card-header">
                                <div class="card-text">
                                    <h3 class="text-danger">
                                        {{__('locale.Nothing found')}}
                                    </h3>
                                </div>
                                <div class="card-text">
                                    <a class="btn btn-primary"
                                        href="{{ route('material.create_manufacture_model', ['id' => $material->id]) }}">
                                        {{__('locale.Create New')}}
                                    </a>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>{{ __('locale.Name') }}</th>
                                            <th>{{ __('locale.Inventory') }}</th>
                                            <th>{{ __('locale.Quantity') }}</th>
                                            <th>{{ __('locale.Unit') }}</th>
                                            <th>{{ __('locale.Cost') }}</th>
                                            <th>{{ __('locale.Total') }}</th>
                                            <th>{{ __('locale.Currency') }}</th>
                                            <th>{{ __('locale.Created at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                        @forelse ($material->manufactureModel as $model)
                                            <tr>
                                                <td>{{ $model->id }}</td>
                                                <td>{{ $model->material?->name }}</td>
                                                <td>{{ $model->inventory?->name }}</td>
                                                <td>{{ $model->quantity }}</td>
                                                <td>{{ $model->unit?->name }}</td>
                                                <td>{{ $model->cost }}</td>
                                                <td>{{ $model->cost * $model->quantity }}</td>
                                                <td>{{ $model->currency?->name }}</td>
                                                <td>{{ $model->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
            <div class="col-12">
                <h3>{{__('locale.Accounts')}}</h3>
                <div class="card">
                    @if ($material->accounts()->count() == 0)
                        <div class="card-header">
                            <div class="card-text">
                                <h3 class="text-danger">
                                    {{__('locale.Nothing found')}}
                                </h3>
                            </div>
                        </div>
                    @else
                        @forelse ($material->accounts as $account)
                            <div class="card-body">
                                <h4> {{ __('locale.Account type') }} {{ $account->type }}</h4>
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>{{ __('locale.Expense') }}</th>
                                            <th>{{ __('locale.Cost') }}</th>
                                            <th>{{ __('locale.Note') }}</th>
                                            <th>{{ __('locale.Created at') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table-hover">
                                        @forelse ($account->expenses as $expense)
                                            <tr>
                                                <td>{{ $expense->id }}</td>
                                                <td>{{ $expense->name }}</td>
                                                <td>{{ $expense->pivot->cost }}</td>
                                                <td>{{ $expense->pivot->note }}</td>
                                                <td>{{ $expense->pivot->created_at->format('Y-m-d') }}</td>
                                            </tr>
                                        @empty
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        @empty
                            <small> No accounts wired !!! </small>
                        @endforelse
                    @endif
                </div>
            </div>
            <div class="col-12">
                <div class="table-responsive h-100" style="min-height: 15rem">
                    <h3>{{ __('locale.Inventories') }}</h3>
                    <div class="card">
                        @if($material->inventories()->count() == 0)
                            <div class="card-header">
                                <div class="card-text">
                                    <h3 class="text-danger">
                                        {{__('locale.Nothing found')}}
                                    </h3>
                                </div>
                            </div>
                        @else
                            <div class="card-body">
                                <table class="table table-sm table-bordered">
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>{{ __('locale.Inventory') }}</th>
                                            <th>{{ __('locale.Quantity') }}</th>
                                            <th>{{ __('locale.Status') }}</th>
                                            <th>{{ __('locale.Options') }}</th>
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
                                                                <span>{{__('locale.Edit')}}</span>
                                                            </a>
                                                            <a class="dropdown-item" href="#">
                                                                <i data-feather="trash" class="me-50"></i>
                                                                <span>{{__('locale.Delete')}}</span>
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
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
