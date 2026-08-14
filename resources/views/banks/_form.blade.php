@php
    /** @var \App\Models\Bank|null $bank */
    $bank = $bank ?? null;

    // Build the sequence rows: old input wins, then existing sequences, padded to 5 blank rows.
    $rows = [];
    if (old('seq_start') !== null) {
        foreach (old('seq_start', []) as $i => $start) {
            $rows[] = [
                'id'     => old('seq_id')[$i] ?? '',
                'start'  => $start,
                'end'    => old('seq_end')[$i] ?? '',
                'active' => (string) old('active_sequence') === (string) $i,
                'used'   => false,
            ];
        }
    } elseif ($bank) {
        foreach ($bank->sequences as $sequence) {
            $rows[] = [
                'id'     => $sequence->id,
                'start'  => $sequence->start_number,
                'end'    => $sequence->end_number,
                'active' => $sequence->is_active,
                'used'   => $sequence->next_number > $sequence->start_number,
            ];
        }
    }
    while (count($rows) < 5) {
        $rows[] = ['id' => '', 'start' => '', 'end' => '', 'active' => false, 'used' => false];
    }
@endphp

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="bank_name">Bank Name <span class="text-danger">*</span></label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="bank_name" name="bank_name"
               value="{{ old('bank_name', $bank->bank_name ?? '') }}" required />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="address_1">Address 1</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="address_1" name="address_1"
               value="{{ old('address_1', $bank->address_1 ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="address_2">Address 2</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="address_2" name="address_2"
               value="{{ old('address_2', $bank->address_2 ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="city">City</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="city" name="city"
               value="{{ old('city', $bank->city ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="state">State</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="state" name="state"
               value="{{ old('state', $bank->state ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="zip_code">Zip Code</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="zip_code" name="zip_code"
               value="{{ old('zip_code', $bank->zip_code ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="phone">Phone Number</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="phone" name="phone"
               value="{{ old('phone', $bank->phone ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="routing_number">Routing Number <span class="text-danger">*</span></label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="routing_number" name="routing_number"
               value="{{ old('routing_number', $bank->routing_number ?? '') }}" required />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="bank_account_number">Bank Account Number</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="bank_account_number" name="bank_account_number"
               value="{{ old('bank_account_number', $bank->bank_account_number ?? '') }}" />
    </div>
</div>

<hr class="my-4" />

<div class="d-flex align-items-center justify-content-between mb-3">
    <h6 class="mb-0">Cheque Sequences</h6>
    <button type="button" class="btn btn-sm btn-label-primary" id="add-sequence-row">
        <i class="ti ti-plus ti-xs me-1"></i>Add More
    </button>
</div>
<p class="text-muted small">
    Only one sequence can be active at a time — the ticked sequence is used for automatic cheque numbering.
    A blank row cannot be ticked.
</p>

<div id="sequence-rows">
    @foreach($rows as $i => $row)
        <div class="row mb-2 align-items-center sequence-row">
            <div class="col-sm-2 d-none d-sm-block text-muted small">
                @if($loop->first) Sequence Rows @endif
            </div>
            <div class="col-5 col-sm-4">
                <input type="hidden" name="seq_id[]" value="{{ $row['id'] }}" />
                <input type="number" min="1" class="form-control seq-start" name="seq_start[]"
                       placeholder="Cheque Sequence (Start)" value="{{ $row['start'] }}"
                       @if($row['used']) title="Cheques have already been issued from this sequence" @endif />
            </div>
            <div class="col-5 col-sm-4">
                <input type="number" min="1" class="form-control seq-end" name="seq_end[]"
                       placeholder="Cheque Sequence (End)" value="{{ $row['end'] }}" />
            </div>
            <div class="col-2 col-sm-2">
                <div class="form-check">
                    <input class="form-check-input seq-active" type="radio" name="active_sequence"
                           value="{{ $i }}" {{ $row['active'] ? 'checked' : '' }} />
                    <label class="form-check-label">Active</label>
                </div>
            </div>
        </div>
    @endforeach
</div>

@push('scripts')
    <script type="text/javascript">
        // A blank sequence row cannot be ticked active.
        $ ( document ).on ( 'click', '.seq-active', function ( e ) {
            var row   = $ ( this ).closest ( '.sequence-row' );
            var start = row.find ( '.seq-start' ).val ().trim ();
            var end   = row.find ( '.seq-end' ).val ().trim ();

            if ( start === '' || end === '' ) {
                e.preventDefault ();
                this.checked = false;
                toastr.error ( 'Enter the start and end numbers before marking this sequence as active.' );
            }
        } );

        $ ( '#add-sequence-row' ).on ( 'click', function () {
            var index = $ ( '#sequence-rows .sequence-row' ).length;
            var html  =
                '<div class="row mb-2 align-items-center sequence-row">' +
                '    <div class="col-sm-2 d-none d-sm-block"></div>' +
                '    <div class="col-5 col-sm-4">' +
                '        <input type="hidden" name="seq_id[]" value="" />' +
                '        <input type="number" min="1" class="form-control seq-start" name="seq_start[]" placeholder="Cheque Sequence (Start)" />' +
                '    </div>' +
                '    <div class="col-5 col-sm-4">' +
                '        <input type="number" min="1" class="form-control seq-end" name="seq_end[]" placeholder="Cheque Sequence (End)" />' +
                '    </div>' +
                '    <div class="col-2 col-sm-2">' +
                '        <div class="form-check">' +
                '            <input class="form-check-input seq-active" type="radio" name="active_sequence" value="' + index + '" />' +
                '            <label class="form-check-label">Active</label>' +
                '        </div>' +
                '    </div>' +
                '</div>';
            $ ( '#sequence-rows' ).append ( html );
        } );
    </script>
@endpush
