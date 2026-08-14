<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')
        <div class="card">
            <div class="card-header border-bottom pt-3 pb-3">
                <h5 class="card-title mb-0">{{ $title }}</h5>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-users table" id="datatable">
                    <thead class="border-top">
                        <tr>
                            <th>Cheque #</th>
                            <th>Date</th>
                            <th>Client</th>
                            <th>Payee</th>
                            <th>Bank</th>
                            <th>Amount</th>
                            <th>Memo</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($cheques as $cheque)
                            <tr>
                                <td>{{ $cheque->cheque_number }}</td>
                                <td>{{ $cheque->cheque_date->format('m/d/Y') }}</td>
                                <td>{{ $cheque->client?->company_name }}</td>
                                <td>{{ $cheque->client?->payee_name }}</td>
                                <td>{{ $cheque->bank?->bank_name }}</td>
                                <td>${{ number_format((float) $cheque->amount, 2) }}</td>
                                <td>{{ $cheque->memo }}</td>
                                <td>
                                    <div class="d-flex align-items-center" style="min-width: 100px">
                                        <a href="{{ route ('cheques.pdf', ['cheque' => $cheque]) }}"
                                            target="_blank"
                                            class="text-body" data-bs-toggle="tooltip"
                                            data-bs-placement="top"
                                            data-bs-custom-class="tooltip-primary"
                                            title="Download PDF">
                                            <i class="ti ti-printer ti-sm me-2"></i>
                                        </a>
                                        <form method="post" id="delete-record-form-{{ $cheque -> id }}"
                                            action="{{ route ('cheques.destroy', ['cheque' => $cheque]) }}">
                                            @method('DELETE')
                                            @csrf
                                            <button type="button" data-bs-toggle="tooltip"
                                                    data-bs-placement="top"
                                                    data-bs-custom-class="tooltip-danger"
                                                    title="Delete"
                                                    class="text-body delete-record bg-transparent border-0 p-0"
                                                    onclick="delete_confirmation({{ $cheque -> id }})">
                                                <i class="ti ti-trash ti-sm mx-2"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- / Content -->
    @push('scripts')
        <script type="text/javascript">
            init_datatable ( '{{ route ('cheques.create') }}' )
        </script>
    @endpush
</x-dashboard>
