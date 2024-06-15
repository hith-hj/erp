@extends('layouts/contentLayoutMaster')

@section('title', 'Card List')

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
                                            <div class="dropdown-menu dropdown-menu-end">
                                                <button form="deleteCurrencyForm" type="submit" 
                                                    class="btn btn-danger w-75 mx-2" >
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
            </div>
        </div>
    </section>
@endsection
