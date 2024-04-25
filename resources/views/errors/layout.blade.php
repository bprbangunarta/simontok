@extends('layouts.auth')

@section('content')
<div class="authentication-wrapper authentication-basic px-4">
    <div class="authentication-inner py-4">

        <div class="card">
            <div class="card-body">
                <div class="app-brand justify-content-center mb-4 mt-2">
                    <a href="/" class="app-brand-link">
                        <span class="app-brand-logo demo" style="height: unset">
                            <img style="height: 30px" src="{{ asset('favicon.png') }}">
                        </span>
                        <span class="app-brand-text demo menu-text fw-bold" style="color: #034871;">{{ ENV('APP_NAME') }}</span>
                    </a>
                </div>
                <!-- /Logo -->
                <h4 class="mb-1 pt-2">@yield('error_code')</h4>
                <p class="text-start mb-4">
                    @yield('error_message')
                </p>
                <button class="btn btn-primary w-100 mb-3" onclick="history.back()">Kembali</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('style')
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}" />
@endpush