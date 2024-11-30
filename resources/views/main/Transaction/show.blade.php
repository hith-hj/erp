@extends('layouts/contentLayoutMaster')

@section('title')
    {{ __('locale.Transaction') }}
@endsection

@section('content')
    <section id="card-content-types">
        <div class="d-flex justify-content-between">
            <h4 class=""> {{ __('locale.Transfers') }} </h4>
            <div class="d-flex justify-content-around gap-1">
                @if ($transaction->remaining > 0)
                    <button class="btn btn-sm btn-outline-success" type="button" data-bs-toggle="modal"
                        data-bs-target="#addTransfer{{ $transaction->id }}">
                        {{ __('locale.Add').' '.__('locale.Transfer') }}
                    </button>
                    <div class="modal fade" id="addTransfer{{ $transaction->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-sm modal-dialog-centered modal-edit-user">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h4>Enter Transfer Amount</h4>
                                </div>
                                <div class="modal-body p-0">
                                    <form id="transfer_form" method="POST"
                                        action="{{ route('cashier.transfer', $transaction->cashier_id) }}"
                                        class="form form-vertical">
                                        @csrf
                                        <input type="hidden" name="transaction_id" value="{{ $transaction->id }}">
                                        <div>
                                            <div class="card mb-1">
                                                <div class="card-body p-0 px-1">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="mb-1">
                                                                <label class="form-label"
                                                                    for="amount">{{ __('locale.Amount') }}</label>
                                                                <input type="number" name="amount" min="0"
                                                                    id="amount" class="form-control">
                                                            </div>
                                                        </div>
                                                        <div class="col-12">
                                                            <button typex="submit" class="btn btn-primary">
                                                                {{ __('locale.Store') }}
                                                            </button>
                                                            <button type="reset" class="btn btn-outline-primary">
                                                                {{ __('locale.Reset') }}
                                                            </button>
                                                            <a class="btn btn-outline-dark" data-bs-dismiss="modal"
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
            </div>
        </div>
        <div class="row">
            <div class="col-12 mt-1">
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
    </section>
@endsection
