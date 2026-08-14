@if($errors -> any())
    @foreach($errors -> all() as $error)
        <div class="alert alert-danger d-flex align-items-center" role="alert">
            <span class="alert-icon text-danger me-2"><i class="ti ti-ban ti-xs"></i></span>
            {{ $error }}
        </div>
    @endforeach
@endif

@if(session () -> has ('error'))
    <div class="alert alert-danger d-flex align-items-center" role="alert">
        <span class="alert-icon text-danger me-2"><i class="ti ti-ban ti-xs"></i></span>
        {!! session ('error') !!}
    </div>
@endif

@if(session () -> has ('success'))
    <div class="alert alert-success d-flex align-items-center" role="alert">
        <span class="alert-icon text-success me-2"><i class="ti ti-check ti-xs"></i></span>
        {!! session ('success') !!}
    </div>
@endif
