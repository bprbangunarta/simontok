@extends('layouts.app')
@section('title', 'Ubah Sandi')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-xl-12 mb-4 col-lg-7 col-12">
            <div class="card-body">

                <div class="row">
                    <div class="col">
                        <div class="card mb-3">
                            <div class="card-header pt-2">
                                <ul class="nav nav-tabs card-header-tabs">
                                    <li class="nav-item">
                                        <a href="{{ route('profile') }}" class="nav-link {{ Request::is('profile') ? 'active' : '' }}">Lihat
                                            Profil</a>
                                    </li>

                                    <li class="nav-item">
                                        <a href="{{ route('password') }}" class="nav-link {{ Request::is('password') ? 'active' : '' }}">Ubah
                                            Sandi</a>
                                    </li>
                                </ul>
                            </div>

                            <div class="tab-content">
                                <div class="tab-pane fade active show">
                                    <form action="{{ route('change.password') }}" method="POST">
                                        @csrf

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Kata Sandi</label>
                                                <input type="password" class="form-control @error('current_password') is-invalid @enderror" name="current_password">

                                                @error('current_password')
                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    <div>
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="row g-3 mt-0">
                                            <div class="col-md-6">
                                                <label class="form-label">Kata Sandi Baru</label>
                                                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password">

                                                @error('password')
                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    <div>
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Konfirmasi Sandi Baru</label>
                                                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation">

                                                @error('password_confirmation')
                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    <div>
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="col-12 mb-3 mt-3">
                                            <ul class="ps-3 mb-0">
                                                <li class="mb-1">Setidaknya satu karakter huruf kecil</li>
                                                <li class="mb-1">Setidaknya satu angka, simbol, atau karakter spasi
                                                </li>
                                                <li>Panjang minimal 6 karakter - semakin banyak, semakin baik</li>
                                            </ul>
                                        </div>

                                        <div>
                                            <a href="#" onclick="history.back()" class="btn btn-label-secondary waves-effect">Kembali</a>
                                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Ubah</button>
                                            <button type="reset" class="btn btn-label-secondary waves-effect me-2" style="float: right;">Reset</button>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

            </div>
        </div>

    </div>
</div>
@endsection

@push('style')
@endpush

@push('script')
@endpush