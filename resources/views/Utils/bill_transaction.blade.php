<a class='dropdown-itemx' href='/{{$type}}/show/{{$bill->billable_id}}'>
    <i data-feather='edit-2' class='me-50'></i>
    <span>{{__('locale.View')}}</span>
</a>
@if(!$bill->transaction()->exists())
    <a class='dropdown-itemx' href='#' data-bs-toggle='modal' data-bs-target='#billTransfer{{$bill->id}}'>
        <i data-feather='edit-2' class='me-50'></i>
        <span>{{__('locale.Add').' '.__('locale.Transaction') }}</span>
    </a>

    <div class='modal fade' id='billTransfer{{$bill->id}}' tabindex='-1' aria-hidden='true'>
        <div class='modal-dialog modal-sm modal-dialog-centered modal-edit-user'>
            <div class='modal-content'>
                <div class='modal-header'>
                    <h4>Enter Transfer Amount</h4>
                </div>
                <div class='modal-body p-0'>
                    <form id='transfer_form' method='POST' action='{{ route('cashier.billTransaction') }}'
                        class='form form-vertical'>
                        @csrf
                        <input type='hidden' name='bill_id' value='{{ $bill->id }}'>
                        <div>
                            <div class='card mb-1'>
                                <div class='card-body p-0 px-1'>
                                    <div class='row'>
                                        <div class='col-6'>
                                            <div class='mb-1'>
                                                <label class='form-label' for='amount'>{{__('locale.Cashier')}}</label>
                                                <select name="cashier_id" id="" class="form-select">
                                                    @foreach ($cashiers as $cashier)
                                                        <option value="{{$cashier->id}}" {{$cashier->is_default ? 'selected' : ''}}  >
                                                            {{$cashier->name}}
                                                        </option>
                                                    @endforeach
                                                </select>                                            
                                            </div>
                                        </div>
                                        <div class='col-6'>
                                            <div class='mb-1'>
                                                <label class='form-label' for='amount'>{{__('locale.Amount')}}</label>
                                                <input type='number' name='amount' min='0' id='amount'
                                                    class='form-control'>
                                            </div>
                                        </div>
                                        <div class='col-12'>
                                            <button typex='submit' class='btn btn-primary'>
                                                {{__('locale.Store')}}
                                            </button>
                                            <button type='reset' class='btn btn-outline-primary'>
                                                {{__('locale.Reset')}}
                                            </button>
                                            <a class='btn btn-outline-dark' data-bs-dismiss='modal' aria-label='Close'>
                                                {{__('locale.Cancel')}}
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
@else
    <a class='dropdown-itemx' href='{{route('transaction.show',$bill->transaction->id)}} '>
        <i data-feather='edit-2' class='me-50'></i>
        <span>{{__('locale.Transaction') }}</span>
    </a>
@endif