<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $title }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('cheques.store') }}">
                    @csrf

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="client_id">Client <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select class="select2 form-select" id="client_id" name="client_id" required>
                                <option value="">Select Client</option>
                                @foreach($clients as $client)
                                    <option value="{{ $client->id }}"
                                            {{ (string) old('client_id') === (string) $client->id ? 'selected' : '' }}>
                                        {{ $client->company_name }} ({{ $client->payee_name }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="bank_id">Bank <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <select class="select2 form-select" id="bank_id" name="bank_id" required>
                                <option value="">Select Bank</option>
                                @foreach($banks as $bank)
                                    <option value="{{ $bank->id }}"
                                            data-next-url="{{ route('banks.next-cheque-number', ['bank' => $bank]) }}"
                                            {{ (string) old('bank_id') === (string) $bank->id ? 'selected' : '' }}>
                                        {{ $bank->bank_name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="cheque_number_display">Cheque No.</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="cheque_number_display"
                                   value="" placeholder="Auto — select a bank" readonly />
                            <small class="text-muted">Assigned automatically from the bank's active cheque sequence.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="cheque_date">Cheque Date <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control flatpickr-basic" id="cheque_date" name="cheque_date"
                                   value="{{ old('cheque_date') }}" placeholder="YYYY-MM-DD" required />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="memo">Memo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="memo" name="memo" value="{{ old('memo') }}" />
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="amount">Amount <span class="text-danger">*</span></label>
                        <div class="col-sm-10">
                            <input type="number" step="0.01" min="0.01" class="form-control" id="amount" name="amount"
                                   value="{{ old('amount') }}" required />
                        </div>
                    </div>

                    <div class="row justify-content-end mt-4">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Submit</button>
                            <a href="{{ route('cheques.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Content -->

    @push('scripts')
        <script type="text/javascript">
            // Show the auto-picked next cheque number when a bank is selected.
            function refresh_next_cheque_number () {
                var option = $ ( '#bank_id' ).find ( ':selected' );
                var url    = option.data ( 'next-url' );

                if ( ! url ) {
                    $ ( '#cheque_number_display' ).val ( '' ).attr ( 'placeholder', 'Auto — select a bank' );
                    return;
                }

                $.get ( url, function ( data ) {
                    if ( data.next_number ) {
                        $ ( '#cheque_number_display' ).val ( data.next_number );
                    } else {
                        $ ( '#cheque_number_display' ).val ( '' )
                            .attr ( 'placeholder', 'No cheque numbers available for this bank' );
                        toastr.error ( 'No cheque numbers are available for this bank. Add or activate a cheque sequence first.' );
                    }
                } );
            }

            $ ( '#bank_id' ).on ( 'change', refresh_next_cheque_number );
            $ ( refresh_next_cheque_number );
        </script>
    @endpush
</x-dashboard>
