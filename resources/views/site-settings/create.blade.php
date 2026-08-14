<x-dashboard :title="$title">
    <!-- Content -->
    <div class="container-p-x flex-grow-1 container-p-y">
        @include('_partials.errors.validation-errors')

        <div class="card mb-4">
            <div class="card-header d-flex align-items-center justify-content-between">
                <h5 class="mb-0">{{ $title }}</h5>
            </div>
            <div class="card-body">
                <form method="post" action="{{ route('settings.store') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="title">Site Title</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="title" name="title"
                                   value="{{ old('title', $settings['title'] ?? '') }}"
                                   placeholder="{{ config('app.name') }}" />
                            <small class="text-muted">Shown on the login page. Leave empty to use the default app name.</small>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="logo">Logo</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="logo" name="logo" accept="image/*" />
                            <small class="text-muted">Shown at the top of the login card in place of the text brand.</small>
                            @if(!empty($settings['logo']))
                                <div class="mt-2">
                                    <img src="{{ asset($settings['logo']) }}" alt="Current logo"
                                         class="img-thumbnail" style="max-height: 80px;" />
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label class="col-sm-2 col-form-label" for="login_image">Login Image</label>
                        <div class="col-sm-10">
                            <input type="file" class="form-control" id="login_image" name="login_image" accept="image/*" />
                            <small class="text-muted">The illustration shown on the left side of the login page.</small>
                            @if(!empty($settings['login_image']))
                                <div class="mt-2">
                                    <img src="{{ asset($settings['login_image']) }}" alt="Current login image"
                                         class="img-thumbnail" style="max-height: 160px;" />
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="row justify-content-end mt-4">
                        <div class="col-sm-10">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- / Content -->
</x-dashboard>
