@php
    $pageConfigs = ['myLayout' => 'blank'];

    $customizerHidden = 'customizer-hide';
@endphp

@extends('layouts/layoutMaster')

@section('title', 'Verify Email Basic - Pages')

@section('page-style')
    <!-- Page -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
@endsection

@section('content')
    <div class="authentication-wrapper authentication-basic px-4">
        <div class="authentication-inner py-4">
            <!-- Verify Email -->
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
                    <h4 class="mb-1 pt-2">Verify your email ✉️</h4>
                    @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success" role="alert">
                            <div class="alert-body">
                                A new verification link has been sent to the email address you provided during registration.
                            </div>
                        </div>
                    @endif
                    <p class="text-start mb-4">
                        Account activation link sent to your email address: <span
                            class="fw-medium">{{ Auth::user()->email }}</span> Please follow the link inside to continue.
                    </p>
                    <div class="mt-4 d-flex gap-2">
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit" class="btn btn-label-secondary">click here to request another</button>
                        </form>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="btn btn-danger">Log Out</button>
                        </form>
                    </div>
                    {{-- <p class="text-start mb-4">
                        Account activation link sent to your email address: hello@example.com Please follow the link inside
                        to continue.
                    </p>
                    <a class="btn btn-primary w-100 mb-3" href="{{ url('/') }}">
                        Skip for now
                    </a>
                    <p class="text-center mb-0">Didn't get the mail?
                        <a href="javascript:void(0);">
                            Resend
                        </a>
                    </p> --}}
                </div>
            </div>
            <!-- /Verify Email -->
        </div>
    </div>
@endsection
