@extends('layouts.app')
@section('title', 'Verifikasi Kredit')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <div class="col-xl-4 mb-4 col-lg-5 col-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-12">
                        <div class="card-body text-nowrap">

                            <form action="{{ route('tugas.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="notugas" value="{{ $tugas->notugas }}">

                                <div class="mb-3">
                                    <label class="form-label">No. Kredit</label>
                                    <input type="text" class="form-control" name="nokredit" value="{{ $tugas->kredit->nokredit }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Debitur</label>
                                    <input type="text" class="form-control" name="nama_debitur" value="{{ $tugas->kredit->nama_debitur }}" readonly>
                                </div>

                                @if ($tugas->aksesUpload == 'disabled')
                                <div class="mb-0">
                                    <img class="img-fluid rounded-3" src="{{ url($tugas->foto_pelaksanaan) }}">
                                </div>
                                @else
                                <div class="mb-3">
                                    <img class="img-fluid rounded-3" src="{{ url($tugas->foto_pelaksanaan) }}">
                                </div>

                                <div class="mb-3">
                                    <input type="file" class="form-control" name="foto_pelaksanaan" accept=".heic, .jpg, .jpeg, .png">
                                </div>

                                <div class="mb-0">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light w-100">Upload</button>
                                </div>
                                @endif
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 mb-4 col-lg-7 col-12">
            <div class="row">
                <div class="col">
                    <div class="card mb-3">

                        <div class="card-header pt-2">
                            <ul class="nav nav-tabs card-header-tabs">
                                <li class="nav-item">
                                    <a href="{{ route('verifikasi.show', $tugas->notugas) }}" class="nav-link {{ Request::is('verifikasi/kredit/*') ? 'active' : '' }}">Verifikasi Kredit</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('verifikasi.agunan', $tugas->notugas) }}" class="nav-link {{ Request::is('verifikasi/agunan/*') ? 'active' : '' }}">Verifikasi Agunan</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade active show">
                                <form action="{{ route('verifikasi.update', $tugas->notugas) }}" method="POST">
                                    @method('PUT')
                                    @csrf

                                    <div class="row" style="margin-top: -10px;">
                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Pengguna Kredit</label>
                                            <input type="text" class="form-control" name="pengguna_kredit" value="{{ $tugas->verifikasi->pengguna_kredit }}" {{ $tugas->aksesLaporan }}>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Penggunaan Kredit</label>
                                            <input type="text" class="form-control" name="penggunaan_kredit" value="{{ $tugas->verifikasi->penggunaan_kredit }}" {{ $tugas->aksesLaporan }}>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Alamat Debitur</label>
                                            <textarea class="form-control" name="alamat_rumah" rows="3" {{ $tugas->aksesLaporan }}>{{ $tugas->verifikasi->alamat_rumah }}</textarea>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Cara Pembayaran</label>
                                            <textarea class="form-control" name="cara_pembayaran" rows="3" {{ $tugas->aksesLaporan }}>{{ $tugas->verifikasi->cara_pembayaran }}</textarea>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">{{ $tugas->verifikasi->usaha }}</label>
                                            <textarea class="form-control" name="usaha_debitur" rows="3" {{ $tugas->aksesLaporan }}>{{ $tugas->verifikasi->usaha_debitur }}</textarea>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Karakter / Kondisi Debitur</label>
                                            <textarea class="form-control" name="karakter_debitur" rows="3" {{ $tugas->aksesLaporan }}>{{ $tugas->verifikasi->karakter_debitur }}</textarea>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Nomor Debitur</label>
                                            <input class="form-control" type="number" name="nomor_debitur" value="{{ $tugas->verifikasi->nomor_debitur }}" {{ $tugas->aksesLaporan }}>
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">{{ $tugas->verifikasi->pendamping }}</label>
                                            <input class="form-control" type="number" name="nomor_pendamping" value="{{ $tugas->verifikasi->nomor_pendamping }}" {{ $tugas->aksesLaporan }}>
                                        </div>

                                        <div class="col-md-12 mt-2">
                                            <label class="form-label">Catatan Leader</label>
                                            <textarea class="form-control" name="catatan_leader" rows="2" {{ $tugas->aksesCatatan }}>{{ $tugas->catatan_leader }}</textarea>
                                        </div>
                                    </div>

                                    <hr>
                                    <div>
                                        <a href="{{ route('kredit.index') }}" class="btn btn-label-secondary waves-effect">Kembali</a>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Simpan</button>
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
@endsection

@push('style')
@endpush

@push('script')
@endpush