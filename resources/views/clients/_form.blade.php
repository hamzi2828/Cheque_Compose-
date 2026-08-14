@php
    /** @var \App\Models\Client|null $client */
    $client = $client ?? null;
@endphp

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="company_name">Company Name <span class="text-danger">*</span></label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="company_name" name="company_name"
               value="{{ old('company_name', $client->company_name ?? '') }}" required />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="contact_no">Contact No.</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="contact_no" name="contact_no"
               value="{{ old('contact_no', $client->contact_no ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="address_1">Address 1</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="address_1" name="address_1"
               value="{{ old('address_1', $client->address_1 ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="address_2">Address 2</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="address_2" name="address_2"
               value="{{ old('address_2', $client->address_2 ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="city">City</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="city" name="city"
               value="{{ old('city', $client->city ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="state">State</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="state" name="state"
               value="{{ old('state', $client->state ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="zip_code">Zip Code</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="zip_code" name="zip_code"
               value="{{ old('zip_code', $client->zip_code ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="phone">Phone Number</label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="phone" name="phone"
               value="{{ old('phone', $client->phone ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="email">Email</label>
    <div class="col-sm-10">
        <input type="email" class="form-control" id="email" name="email"
               value="{{ old('email', $client->email ?? '') }}" />
    </div>
</div>

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="notes">Notes</label>
    <div class="col-sm-10">
        <textarea class="form-control" id="notes" name="notes" rows="3">{{ old('notes', $client->notes ?? '') }}</textarea>
    </div>
</div>

@php
    $selectedBankIds = collect(old('bank_ids', $client?->banks->pluck('id')->all() ?? []))
        ->map(fn ($id) => (string) $id)
        ->all();
@endphp

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="bank_ids">Bank</label>
    <div class="col-sm-10">
        <select class="select2 form-select" id="bank_ids" name="bank_ids[]" multiple>
            @foreach($banks as $bank)
                <option value="{{ $bank->id }}"
                        {{ in_array((string) $bank->id, $selectedBankIds, true) ? 'selected' : '' }}>
                    {{ $bank->bank_name }}
                </option>
            @endforeach
        </select>
        <small class="text-muted">The banks selected here become available when composing a cheque for this company.</small>
    </div>
</div>
