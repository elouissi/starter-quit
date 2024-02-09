@php
    $pageConfigs = ['myLayout' => 'blank'];

    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Register Basic - Pages')

@section('vendor-style')
    <!-- Vendor -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/@form-validation/umd/styles/index.min.css') }}" />
@endsection

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('vendor-script')
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/bundle/popular.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-bootstrap5/index.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/libs/@form-validation/umd/plugin-auto-focus/index.min.js') }}"></script>
@endsection

@section('page-script')
    <script src="{{ asset('assets/js/pages-auth.js') }}"></script>
@endsection

@section('content')
    <div class="container-xxl">
        <div class="authentication-wrapper authentication-basic container-p-y">
            <div class="authentication-inner py-4">

                <!-- Register Card -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20, 'withbg' => 'fill: #fff;'])</span>
                                <span
                                    class="app-brand-text demo text-body fw-bold ms-1">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">L'aventure commence ici 🚀</h4>
                        <p class="mb-4">Facilitez-vous la gestion de votre application et amusez-vous !</p>


                        <form id="formAuthentication" class="mb-3" action="{{ route('register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="username" class="form-label">Nom d'utilisateur</label> <input type="text"
                                    class="form-control @error('name') is-invalid @enderror" id="username" name="name"
                                    placeholder="johndoe" autofocus value="{{ old('name') }}" />
                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <span class="fw-medium">{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="john@example.com"
                                    value="{{ old('email') }}" />
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <span class="fw-medium">{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>
                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password">Mot de passe</label>
                                <div class="input-group input-group-merge @error('password') is-invalid @enderror">
                                    <input type="password" id="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer">
                                        <i class="ti ti-eye-off"></i>
                                    </span>
                                </div>
                                @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <span class="fw-medium">{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>

                            <div class="mb-3 form-password-toggle">
                                <label class="form-label" for="password-confirm">Confirmer le mot de passe</label>
                                <div class="input-group input-group-merge">
                                    <input type="password" id="password-confirm" class="form-control"
                                        name="password_confirmation"
                                        placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                        aria-describedby="password" />
                                    <span class="input-group-text cursor-pointer">
                                        <i class="ti ti-eye-off"></i>
                                    </span>
                                </div>
                            </div>
                            @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                                <div class="mb-3">
                                    <div class="form-check @error('terms') is-invalid @enderror">
                                        <input class="form-check-input @error('terms') is-invalid @enderror" type="checkbox"
                                            id="terms" name="terms" />
                                        <label class="form-check-label" for="terms">
                                            J'accepte la
                                            <a href="{{ route('policy.show') }}" target="_blank">politique de
                                                confidentialité</a> et les
                                            <a href="{{ route('terms.show') }}" target="_blank">conditions
                                                d'utilisation</a>
                                        </label>

                                    </div>
                                    @error('terms')
                                        <div class="invalid-feedback" role="alert">
                                            <span class="fw-medium">{{ $message }}</span>
                                        </div>
                                    @enderror
                                </div>
                            @endif
                            <button type="submit" class="btn btn-primary d-grid w-100">Sign up</button>
                        </form>

                        <p class="text-center mt-2">
                            <span>Vous avez déjà un compte ?</span>
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}">
                                    <span>Connectez-vous plutôt</span>
                                </a>
                            @endif
                        </p>


                        {{-- <div class="divider my-4">
                            <div class="divider-text">or</div>
                        </div>

                        <div class="d-flex justify-content-center">
                            <a href="javascript:;" class="btn btn-icon btn-label-facebook me-3">
                                <i class="tf-icons fa-brands fa-facebook-f fs-5"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-icon btn-label-google-plus me-3">
                                <i class="tf-icons fa-brands fa-google fs-5"></i>
                            </a>

                            <a href="javascript:;" class="btn btn-icon btn-label-twitter">
                                <i class="tf-icons fa-brands fa-twitter fs-5"></i>
                            </a>
                        </div> --}}
                    </div>
                </div>
                <!-- Register Card -->
            </div>
        </div>
    </div>
@endsection
