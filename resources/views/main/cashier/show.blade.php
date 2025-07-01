@extends('layouts/contentLayoutMaster')

@section('title')
    {{ $cashier->name }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="d-flex justify-content-between">
            <h4 class=""> {{ __('locale.Transactions') }} </h4>
            <div class="d-flex justify-content-around gap-1">

                <button class="btn btn-sm btn-outline-success" type="button" data-bs-toggle="modal"
                    data-bs-target="#moneyForm{{ $cashier->id }}">
                    {{ __('locale.Transfers') }}
                </button>
                <div class="modal fade" id="moneyForm{{ $cashier->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-md modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h4>{{__('locale.Amount')}}</h4>
                            </div>
                            <div class="modal-body p-0">

                                <form id="transfer_form" method="POST" class="form form-vertical"
                                    action="{{ route('cashier.credits') }}">
                                    @csrf
                                    <input type="hidden" name="cashier_id" value="{{ $cashier->id }}">
                                    <div class="card mb-1">
                                        <div class="card-body p-0 px-1">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-1">
                                                        <label class="form-label" for="amount">{{ __('locale.Cashiers') }}</label>
                                                        <select name="to_cashier" id="credit_amount" class="form-select">
                                                            <option value="">{{ __('locale.Chose')}}</option>
                                                            @foreach($cashiers as $cash)
                                                                <option value="{{$cash->id}}">{{$cash->name}}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-1">
                                                        <label class="form-label"
                                                            for="amount">{{ __('locale.Amount') }}</label>
                                                        <input type="number" name="amount" min="0" max="{{$cashier->total}}"
                                                            id="amount" class="form-control" oninput="
                                                                let select = $('#credit_amount');
                                                                if(this.value > {{$cashier->total}}){
                                                                    this.classList.add('border-danger');
                                                                }else{
                                                                    this.classList.remove('border-danger');
                                                                }
                                                            ">
                                                    </div>
                                                </div>
                                                <div class="col-12">
                                                    <button typex="submit" class="btn btn-primary w-50">
                                                        {{ __('locale.Store') }}
                                                    </button>
                                                    <a class="btn btn-outline-dark" data-bs-dismiss="modal"
                                                        aria-label="Close">
                                                        {{ __('locale.Cancel') }}
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>

                                <details class="m-1">
                                    <summary>{{__('locale.Transfers')}}</summary>
                                    <ul>

                                            <table class="table table-sm table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>No</th>
                                                        <th>{{ __('locale.ID') }}</th>
                                                        <th>{{__('locale.from')}}</th>
                                                        <th>{{ __('locale.Amount') }}</th>
                                                        <th>{{ __('locale.Created at') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="table-hover">
                                                    @forelse ($cashierTransactions as $item)
                                                        <tr>
                                                            <td>{{ $loop->index + 1 }}</td>
                                                            <td>{{ $item->id }}</td>
                                                            <td>

                                                                <a href="{{ route("cashier.show",
                                                                 $item->cashier->id) }}">
                                                                    {{ $item->cashier->name }}
                                                                </a>
                                                            </td>
                                                            <td>{{ $item->amount }}</td>
                                                            <td>{{ $item->created_at }}</td>
                                                        </tr>
                                                    @empty
                                                        <li>{{__('locale.Nothing found')}}</li>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                    </ul>
                                </details>
                            </div>
                        </div>
                    </div>
                </div>

                @if (count($bills) > 0)
                    <button class="btn btn-sm btn-outline-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#addTransaction">
                        {{ __('locale.Add') }}
                    </button>
                @endif
                <div class="modal fade" id="addTransaction" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-lg modal-dialog-centered modal-edit-user">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                @include('utils.new_transaction_form')
                            </div>
                        </div>
                    </div>
                </div>
                @if (!$cashier->is_default)
                    <button class="btn btn-sm btn-outline-info" form="setDefaultForm">
                        {{ __('locale.Default') }}
                    </button>
                    <form id="setDefaultForm" method="POST" hidden
                        action="{{ route('cashier.setDefault', $cashier->id) }}">
                        @csrf
                    </form>
                @endif
                @if ($cashier->transactions()->count() == 0 && !$cashier->is_default)
                    <button class="btn btn-sm btn-outline-danger"
                        onclick="
                            if(confirm('{{ __('locale.Delete') }} ?')){
                                document.getElementById('deleteCashierForm').submit();
                            }
                        ">
                        {{ __('locale.Delete') }}
                    </button>
                    <form id="deleteCashierForm" method="Post" hidden
                        action="{{ route('cashier.delete', ['cashier' => $cashier->id]) }}">
                        @csrf @method('delete')
                    </form>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-1">
                <div class="card">
                    <div class="card-header">
                        <h4 class="card-title">
                            {{ __('locale.Name') }} :
                            {{ $cashier->name }}
                        </h4>
                        <div class="card-text">
                            {{ __('locale.Is default') }} :
                            {{ $cashier->is_default ? __('locale.Default') : '-' }}
                        </div>
                        <div class="card-text">
                            {{ __('locale.Total') }} :
                            {{ $cashier->total }}
                        </div>
                        <div class="card-text">
                            {{ __('locale.Created at') }}
                            {{ $cashier->created_at->diffForHumans() }}
                        </div>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm table-bordered">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>{{ __('locale.ID') }}</th>
                                    <th>{{ __('locale.On')}}</th>
                                    <th>{{ __('locale.Type') }}</th>
                                    <th>{{ __('locale.Amount') }}</th>
                                    <th>{{ __('locale.Remaining') }}</th>
                                    <th>{{ __('locale.Transfers') }}</th>
                                    <th>{{ __('locale.Created at') }}</th>
                                    <th>{{ __('locale.Options') }}</th>
                                </tr>
                            </thead>
                            <tbody class="table-hover">
                                @forelse ($cashier->transactions as $transaction)
                                    <tr>
                                        <td>{{ $loop->index + 1 }}</td>
                                        <td>{{ $transaction->id }}</td>
                                        <td>
                                            @php
                                                $name = strtolower(class_basename($transaction->belongTo_type));
                                            @endphp
                                            <a href="{{ route("$name.show",
                                             $transaction->belongTo_id) }}">
                                                {{$name}}
                                                --
                                                {{ $transaction->belongTo->name }}
                                            </a>
                                        </td>
                                        <td>{{ $transaction->getType() }}</td>
                                        <td>{{ $transaction->amount }}</td>
                                        <td>{{ $transaction->remaining }}</td>
                                        <td>
                                            {{ $transaction->transfers->count() }}
                                        </td>
                                        <td>{{ $transaction->created_at }}</td>
                                        <td>
                                            <a href="{{route('transaction.show',$transaction->id)}}">
                                                <button class="btn btn-sm text-primary">
                                                    {{__('locale.View')}}
                                                </button>
                                            </a>
                                            @if ($transaction->remaining > 0)
                                                <button class="btn btn-sm text-success" type="button"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#addTransfer{{ $transaction->id }}">
                                                    {{ __('locale.Add') }}
                                                </button>
                                                <div class="modal fade" id="addTransfer{{ $transaction->id }}"
                                                    tabindex="-1" aria-hidden="true">
                                                    <div
                                                        class="modal-dialog modal-sm modal-dialog-centered modal-edit-user">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4>Enter Transfer Amount</h4>
                                                            </div>
                                                            <div class="modal-body p-0">
                                                                <form id="transfer_form" method="POST"
                                                                    action="{{ route('cashier.transfer', $cashier->id) }}"
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
                                            <button class="btn btn-sm text-info" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#transaction{{ $transaction->id }}Transfers">
                                                {{ __('locale.Transfers') }}
                                            </button>
                                            <div class="modal fade" id="transaction{{ $transaction->id }}Transfers"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-sm modal-dialog-centered modal-edit-user">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4>
                                                                {{ __('locale.Transaction') . '-' . $transaction->id }}
                                                                {{ __('locale.Transfers') }}
                                                            </h4>
                                                        </div>
                                                        <div class="modal-body">
                                                            <div class="card">
                                                                <table class="table table-sm table-bordered">
                                                                    <thead>
                                                                        <tr>
                                                                            <th>No</th>
                                                                            <th>{{ __('locale.ID') }}</th>
                                                                            <th>{{ __('locale.Amount') }}</th>
                                                                            <th>{{ __('locale.Created at') }}</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                        @foreach ($transaction->transfers as $transfer)
                                                                            <tr>
                                                                                <td>{{ $loop->index + 1 }}</td>
                                                                                <td>{{ $transfer->id }}</td>
                                                                                <td>{{ $transfer->amount }}</td>
                                                                                <td>{{ $transfer->created_at }}</td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
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
    </section>
@endsection
