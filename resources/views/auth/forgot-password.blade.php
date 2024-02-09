@php
    $pageConfigs = ['myLayout' => 'blank'];

    $customizerHidden = 'customizer-hide';
@endphp
@extends('layouts/layoutMaster')

@section('title', 'Forgot Password Basic - Pages')

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
                <!-- Forgot Password -->
                <div class="card">
                    <div class="card-body">
                        <!-- Logo -->
                        <div class="app-brand justify-content-center mb-4 mt-2">
                            <a href="{{ url('/') }}" class="app-brand-link gap-2">
                                <span class="app-brand-logo demo">@include('_partials.macros', ['height' => 20, 'withbg' => 'fill: #fff;'])</span>
                                <span
                                    class="app-brand-text demo text-body fw-bold">{{ config('variables.templateName') }}</span>
                            </a>
                        </div>
                        <!-- /Logo -->
                        <h4 class="mb-1 pt-2">Mot de passe oublié ? 🔒</h4>
                        <p class="mb-4">Entrez votre adresse e-mail et nous vous enverrons des instructions pour
                            réinitialiser votre mot de passe</p>

                        <form id="formAuthentication" class="mb-3" action="{{ route('password.email') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="text" class="form-control @error('email') is-invalid @enderror"
                                    id="email" name="email" placeholder="john@example.com" autofocus>
                                @error('email')
                                    <span class="invalid-feedback" role="alert">
                                        <span class="fw-medium">{{ $message }}</span>
                                    </span>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-primary d-grid w-100">Envoyer le lien de
                                réinitialisation</button>
                        </form>
                        <div class="text-center">
                            @if (Route::has('login'))
                                <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
                                    <i class="ti ti-chevron-left scaleX-n1-rtl"></i>
                                    Retour à la connexion
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                <!-- /Forgot Password -->
            </div>
        </div>
    </div>
@endsection
