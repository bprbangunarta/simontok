@extends('layouts.app')
@section('title', 'Lihat Profile')

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
                                    <form action="{{ route('change.profile') }}" method="POST">
                                        @csrf

                                        <div class="row g-3">
                                            <div class="col-md-6">
                                                <label class="form-label">Nama Lengkap</label>
                                                <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ Auth::user()->name }}" name="name">

                                                @error('name')
                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    <div>
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Username</label>
                                                <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ Auth::user()->username }}" name="username">

                                                @error('username')
                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    <div>
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Nomor HP</label>
                                                <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ Auth::user()->phone }}" name="phone">

                                                @error('phone')
                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    <div>
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Alamat Email</label>
                                                <input type="email" class="form-control @error('email') is-invalid @enderror""
                                                        value=" {{ Auth::user()->email }}" name="email">

                                                @error('email')
                                                <div class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                                    <div>
                                                        {{ $message }}
                                                    </div>
                                                </div>
                                                @enderror
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Hak Akses</label>
                                                <input type="text" class="form-control" value="{{ Auth::user()->role }}" readonly>
                                            </div>

                                            <div class="col-md-6">
                                                <label class="form-label">Terdaftar</label>
                                                <input type="text" class="form-control" value="{{ \Carbon\Carbon::parse(Auth::user()->created_at)->locale('id')->isoFormat('D MMMM Y') }}" readonly>
                                            </div>
                                        </div>

                                        <div class="pt-4">
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