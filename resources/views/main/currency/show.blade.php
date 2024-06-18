@extends('layouts/contentLayoutMaster')

@section('title'){{__('locale.Currency')}} - {{$currency->name}}@endsection

@section('content')
    <section id="card-content-types">
        <div class="card mb-4">
            <div class="table-responsive" style="min-height:15rem">
                <table class="table table-sm">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>{{__('locale.Name')}}</th>
                            <th>{{__('locale.Code')}}</th>
                            <th>{{__('locale.Rate')}}</th>
                            <th>{{__('locale.Default')}}</th>
                            <th>{{__('locale.Action')}}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{{ $currency->id }}</td>
                            <td>{{ $currency->name }}</td>
                            <td>{{ $currency->code }}</td>
                            <td>{{ $currency->rate_to_default }}</td>
                            <td>
                                <span class="badge rounded-pill badge-light-success me-1">
                                    {{ $currency->is_default ? __('locale.Default') : '-' }}
                                </span>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn btn-sm dropdown-toggle hide-arrow py-0"
                                        data-bs-toggle="dropdown">
                                        <i data-feather="more-vertical"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-end p-1">
                                        @if(!$currency->is_default)
                                            <button class="btn btn-sm btn-primary w-100 my-1"
                                                data-bs-toggle="modal" type="button" data-bs-target="#setAsDefaultForm">
                                                {{ __('locale.Default') }}
                                            </button>
                                        @endif
                                        <button form="deleteCurrencyForm" type="submit" 
                                            class="btn btn-danger w-100" >
                                            {{__('locale.Delete')}}
                                        </button>
                                        <form id="deleteCurrencyForm" method="post" 
                                            action="{{route('currency.delete',['id'=>$currency->id])}}">
                                            @csrf
                                            @method('delete')
                                        </form>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal fade" id="setAsDefaultForm" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                <div class="modal-content p-1">
                    <form action="{{route('currency.setDefault',['id'=>$currency->id])}}" method="post">
                        @csrf
                        <div class="modal-header mb-1">
                            <div class="modal-title">
                                <h4 class="font-lg">
                                    Set new rates to the new default currency
                                </h4>
                            </div>
                        </div>
                        <div class="modal-body p-0">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>{{__('locale.Currency')}}</th>
                                        <th>{{__('locale.Rate')}}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($currencies as $value)
                                        <tr>
                                            <td>{{$loop->index + 1}}</td>
                                            <td>{{ $value->name }}</td>
                                            <td>
                                                <input type="number" name="{{$value->id}}" 
                                                    step="0.01" min="0.01" max="100000"
                                                    class="form-control" required>
                                            </td>
                                        </tr>
                                    @empty
                                        
                                    @endforelse
                                </tbody>
                            </table>
                            <p>the new default "{{$currency->name}}" rate  will be set to 1</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary w-100">{{__('locale.Save')}}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
@endsection
