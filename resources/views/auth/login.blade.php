@extends('layouts.auth')
@section('title', 'Sign In')

@section('content')
    <div class="authentication-wrapper authentication-cover authentication-bg">
        <div class="authentication-inner row">
            <div class="d-none d-lg-flex col-lg-7 p-0">
                <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
                    <img src="{{ asset('assets/img/illustrations/auth-login-illustration-light.png') }}"
                        alt="auth-login-cover" class="img-fluid my-5 auth-illustration"
                        data-app-light-img="illustrations/auth-login-illustration-light.png"
                        data-app-dark-img="illustrations/auth-login-illustration-dark.png" />

                    <img src="{{ asset('assets/img/illustrations/bg-shape-image-light.png') }}" alt="auth-login-cover"
                        class="platform-bg" data-app-light-img="illustrations/bg-shape-image-light.png"
                        data-app-dark-img="illustrations/bg-shape-image-dark.png" />
                </div>
            </div>

            <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
                <div class="w-px-400 mx-auto">
                    <h3 class="mb-1">Welcome to {{ ENV('APP_NAME') }}! 👋</h3>
                    <p class="mb-4">Silakan masuk ke akun Anda dan mulai petualangan</p>

                    <form id="formAuthentication" class="mb-3 fv-plugins-bootstrap5 fv-plugins-framework" action="/login"
                        method="POST" novalidate="novalidate">
                        @csrf

                        <div class="mb-3 fv-plugins-icon-container fv-plugins-bootstrap5-row-invalid">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control @error('username') is-invalid @enderror"
                                name="username" value="{{ old('username') }}" placeholder="Masukkan username">
                            @error('username')
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    <div data-field="username" data-validator="notEmpty">{{ $message }}</div>
                                </div>
                            @enderror
                        </div>

                        <div
                            class="mb-3 form-password-toggle fv-plugins-icon-container @error('password') fv-plugins-bootstrap5-row-invalid @enderror">
                            <div class="d-flex justify-content-between">
                                <label class="form-label" for="password">Kata Sandi</label>
                                <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalForgot">
                                    <small>Lupa Sandi?</small>
                                </a>
                            </div>
                            <div class="input-group input-group-merge has-validation">
                                <input type="password" id="password"
                                    class="form-control @error('password') is-invalid @enderror" name="password"
                                    placeholder="Masukkan kata sandi" aria-describedby="password">
                                <span class="input-group-text cursor-pointer"><i class="ti ti-eye-off"></i></span>
                            </div>
                            @error('password')
                                <div
                                    class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                    <div data-field="email" data-validator="notEmpty">{{ $message }}</div>
                                </div>
                            @enderror
                        </div>

                        <button class="btn btn-primary d-grid w-100 waves-effect waves-light">Masuk</button>
                        <input type="hidden">
                    </form>

                    <p>
                        <span>Baru di platform kami?</span>
                        <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modalRegister">
                            <span>Buat sebuah akun</span>
                        </a>
                    </p>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('style')
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
@endpush

@push('script')
    {{-- <script src="{{ asset('assets/js/pages-auth.js') }}"></script> --}}
@endpush
