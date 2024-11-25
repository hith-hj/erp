<form id="transaction_form" method="POST" action="{{ route('cashier.transaction',$cashier->id) }}"
     class="form form-vertical">
    @csrf
    <input type="hidden" name="cashier_id" value="{{$cashier->id}}">
    <div>
        <div class="card mb-1">
            <div class="card-header p-1">
                <h4>
                    {{ __('locale.Basic info') }}
                </h4>
            </div>
            <div class="card-body p-0 px-1">
                <div class="row">
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label" for="bill_id">{{ __('locale.Bill') }}</label>
                            <select id="bill_id" name="bill_id" class="form-select"
                                @error('bill_id') border-danger @enderror >
                                <option value="">{{ __('locale.Chose') }}</option>
                                @forelse ($bills as $bill)
                                    <option value="{{$bill->id}}">
                                        {{$bill->getType.' - '.$bill->serial. ' - '.$bill->item->total()}}
                                    </option>
                                @empty
                                    <option value="">{{__('locale.None')}}</option>
                                @endforelse
                            </select>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-1">
                            <label class="form-label" for="amount">{{ __('locale.Amount') }}</label>
                            <input type="number" name="amount" min="0" id="aamount" class="form-control">
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card m-0">
            <div class="card-body p-1">
                <div class="row">
                    {{-- <div class="col-6">
                        <button type="button" class="btn btn-primary w-100" data-repeater-create>
                            {{ __('locale.Add') }}
                        </button>
                    </div> --}}
                    <div class="col-12">
                        <button typex="submit" class="btn btn-primary">
                            {{ __('locale.Store') }}
                        </button>
                        <button type="reset" class="btn btn-outline-primary">
                            {{ __('locale.Reset') }}
                        </button>
                        <a class="btn btn-outline-dark" data-bs-dismiss="modal" aria-label="Close">
                            {{ __('locale.Cancel') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
