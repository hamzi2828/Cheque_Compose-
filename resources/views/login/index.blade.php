@php
    $siteTitle  = $settings['title'] ?? null ?: config('app.name');
    $logo       = $settings['logo'] ?? null;
    $loginImage = $settings['login_image'] ?? null;
@endphp

<x-login :title="$title">
    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
            <!-- Left Illustration -->
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    @if($loginImage)
                        <img
                            src="{{ asset($loginImage) }}"
                            alt="auth-login-cover"
                            class="img-fluid my-5 auth-illustration" />
                    @else
                        <img
                            src="{{ asset('/assets/img/illustrations/auth-login-illustration-light.png') }}"
                            alt="auth-login-cover"
                            class="img-fluid my-5 auth-illustration"
                            data-app-light-img="illustrations/auth-login-illustration-light.png"
                            data-app-dark-img="illustrations/auth-login-illustration-dark.png" />
                    @endif

                    <img
                        src="{{ asset('/assets/img/illustrations/bg-shape-image-light.png') }}"
                        alt="auth-login-cover"
                        class="platform-bg"
                        data-app-light-img="illustrations/bg-shape-image-light.png"
                        data-app-dark-img="illustrations/bg-shape-image-dark.png" />
                </div>
            </div>
            <!-- /Left Illustration -->

            <!-- Login -->
            <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <!-- Logo -->
                    <div class="app-brand mb-4">
                        @if($logo)
                            <img src="{{ asset($logo) }}" alt="Logo" class="img-fluid" style="max-height: 100px;" />
                        @else
                            <span class="app-brand-text fw-bold" style="font-size: 1.5rem;">{{ $siteTitle }}</span>
                        @endif
                    </div>
                    <!-- /Logo -->
                    <h3 class="mb-1">Welcome to {{ $siteTitle }}! 🖋️</h3>
                    <p class="mb-4">Please sign-in to your account</p>

                    @include('_partials.errors.validation-errors')

                    <form id="formAuthentication" class="mb-3" action="{{ route ('authenticate') }}" method="post">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email"
                                   placeholder="Enter your email address" value="{{ old ('email') }}"
                                   autofocus="autofocus" />
                        </div>
                        <div class="mb-3 form-password-toggle">
                            <label class="form-label" for="password">Password</label>
                            <div class="input-group input-group-merge">
                                <input type="password" id="password" class="form-control" name="password"
                                       placeholder="Password" aria-describedby="password" />
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="remember-me" name="remember" value="1" />
                                <label class="form-check-label" for="remember-me"> Remember Me </label>
                            </div>
                        </div>

                        <button class="btn btn-primary d-grid w-100">Sign in</button>
                    </form>
                </div>
            </div>
            <!-- /Login -->
        </div>
    </div>
</x-login>
