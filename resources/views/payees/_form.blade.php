@php
    /** @var \App\Models\Payee|null $payee */
    $payee = $payee ?? null;
@endphp

<div class="row mb-3">
    <label class="col-sm-2 col-form-label" for="name">Payee Name <span class="text-danger">*</span></label>
    <div class="col-sm-10">
        <input type="text" class="form-control" id="name" name="name"
               value="{{ old('name', $payee->name ?? '') }}" required />
    </div>
</div>
