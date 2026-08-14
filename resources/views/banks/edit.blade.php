<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $title }} - {{ $bank->bank_name }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('banks.update', ['bank' => $bank]) }}">
                    @csrf
                    @method('PUT')

                    @include('banks._form', ['bank' => $bank])

                    <div class="row justify-content-end mt-4">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Update</button>
                            <a href="{{ route('banks.index') }}" class="btn btn-secondary">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Content -->
</x-dashboard>
