@extends('layouts/contentLayoutMaster')

@section('title')
    {{ $client->first_name }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="card-head mb-1 row">
            <h4 class="col-10">{{ __('locale.Show') }}</h4>
            <div class="col-2">
                <button class="btn btn-sm btn-outline-danger w-100" 
                    onclick="
                        if(confirm('{{__('locale.Delete')}} ?')){
                            document.getElementById('deleteClientForm').submit();
                        }
                    " >
                    {{ __('locale.Delete') }}
                </button>
                <form id="deleteClientForm" 
                    method="Post" 
                    action="{{route('client.delete',['client'=>$client->id])}}">
                    @csrf @method('delete')
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <h5>{{__('locale.Details')}}</h5>
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{__('locale.Name')}} :
                            {{ $client->first_name. ' ' .$client->last_name }}
                        </h4>
                        <div class="card-text">
                            {{__('locale.Email')}} : 
                            {{ $client->email }}
                        </div>
                        <div class="card-text">
                            {{__('locale.Phone')}} : 
                            {{ $client->phone }}
                        </div>
                        <div class="card-text">
                            {{__('locale.Created at')}}
                            {{ $client->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm ">
                            <thead>
                                <tr>
                                    <th>Id</th>
                                    <th>{{__('locale.Bill')}}</th>
                                    <th>{{__('locale.Currency')}}</th>
                                    <th>{{__('locale.Transfers')}}</th>
                                    <th>{{__('locale.Total')}}</th>
                                    <th>{{__('locale.Payed')}}</th>
                                    <th>{{__('locale.Remaining')}}</th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                @php
                                    $sales = 0;
                                    $total = 0;
                                    $remaining = 0;
                                @endphp
                                @forelse ($client->sales as $sale)
                                    @php
                                        $sales += 1;
                                        $total += $sale->total();
                                        $remaining += $sale->bill->transaction->remaining;
                                        @endphp
                                    <tr>
                                        <td>{{$sale->id}}</td>
                                        <td>{{$sale->bill->serial}}</td>
                                        <td>{{$sale->currency->name}}</td>
                                        <td>{{$sale->bill->transaction->transfers()->count()}}</td>
                                        <td>{{ $sale->total()}}</td>
                                        <td>{{$total - $remaining}}</td>
                                        <td>{{$sale->bill->transaction->remaining}}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td>
                                            <span class="badge badge-light-info me-1">
                                                Not sales yet
                                            </span>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                            <tr class="text-primary border-primary">
                                <th> {{ __('locale.Sales') }} : {{ $sales}}</th>
                                <td></td>
                                <th> {{ __('locale.Total') }} : {{ $total}}</th>
                                <td></td>
                                <th> {{ __('locale.Payed') }} : {{ $total - $remaining}}</th>
                                <td></td>
                                <th> {{ __('locale.Remaining') }} : {{ $remaining}}</th>
                                <td></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </section>
@endsection
