@extends('layouts.app')
@section('title', 'Data Postra')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <div class="col-xl-4 mb-4 col-lg-5 col-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-12">
                        <div class="card-body text-nowrap">

                            <form action="{{ route('postra.update.photo', $tugas->notugas) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label class="form-label">No. Kredit</label>
                                    <input type="text" class="form-control" value="{{ $tugas->kredit->nokredit }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Debitur</label>
                                    <input type="text" class="form-control" value="{{ $tugas->kredit->nama_debitur }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <img class="img-fluid rounded-3" src="{{ $tugas->foto_pelaksanaan }}">
                                </div>

                                <div class="mb-3">
                                    <input type="file" class="form-control" name="foto_pelaksanaan" accept=".heic, .jpg, .jpeg, .png">
                                </div>

                                <div class="mb-0">
                                    <button type="submit" class="btn btn-primary waves-effect waves-light w-100">Upload</button>
                                </div>
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
                                    <a href="{{ route('postra.edit', $tugas->notugas) }}" class="nav-link {{ Request::query('data') == null ? 'active' : '' }}">Verifikasi Kredit</a>
                                </li>

                                <li class="nav-item">
                                    <a href="{{ route('postra.edit', $tugas->notugas) }}?data=agunan" class="nav-link {{ Request::query('data') == 'agunan' ? 'active' : '' }}">Verifikasi Agunan</a>
                                </li>
                            </ul>
                        </div>

                        @if (Request::query('data') == null)
                        <div class="tab-content">
                            <div class="tab-pane fade active show">
                                <form action="{{ route('postra.update', $tugas->notugas) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row" style="margin-top: -10px;">
                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Pengguna Kredit</label>
                                            <input type="text" class="form-control" name="pengguna_kredit" value="{{ $tugas->verifikasi->pengguna_kredit ?? $tugas->kredit->nama_debitur }}">

                                            @error('pengguna_kredit')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Penggunaan Kredit</label>
                                            <input type="text" class="form-control" name="penggunaan_kredit" value="{{ $tugas->verifikasi->penggunaan_kredit }}">


                                            @error('penggunaan_kredit')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Alamat Debitur</label>
                                            <textarea class="form-control" name="alamat_rumah" rows="4">{{ $tugas->verifikasi->alamat_rumah ?? $tugas->kredit->alamat }}</textarea>

                                            @error('alamat_rumah')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Cara Pembayaran</label>
                                            <textarea class="form-control" name="cara_pembayaran" rows="4">{{ $tugas->verifikasi->cara_pembayaran }}</textarea>

                                            @error('cara_pembayaran')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Pekerjaan Debitur</label>
                                            <textarea class="form-control" name="usaha_debitur" rows="4">{{ $tugas->verifikasi->usaha_debitur }}</textarea>

                                            @error('usaha_debitur')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Karakter / Kondisi Debitur</label>
                                            <textarea class="form-control" name="karakter_debitur" rows="4">{{ $tugas->verifikasi->karakter_debitur }}</textarea>

                                            @error('karakter_debitur')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Nomor Debitur</label>
                                            <input class="form-control" type="number" name="nomor_debitur" value="{{ $tugas->verifikasi->nomor_debitur ?? trim($nasabah->nohp) }}">

                                            @error('nomor_debitur')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Nomor Pendamping</label>
                                            <input class="form-control" type="number" name="nomor_pendamping" value="{{ $tugas->verifikasi->nomor_pendamping ?? trim($nasabah->nofax) }}">

                                            @error('nomor_pendamping')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr>
                                    <div>
                                        <a href="{{ route('postra.index') }}" class="btn btn-label-secondary waves-effect">Kembali</a>
                                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Update</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        @elseif (Request::query('data') == 'agunan')
                        <div class="tab-content">
                            <div class="tab-pane fade active show">
                                <div class="row" style="margin-top: -10px;">
                                    <table class="table border-top">
                                        <thead>
                                            <tr>
                                                <td>Noreg</td>
                                                <td>Agunan</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($agunan as $item)
                                            <tr>
                                                <td>{{ $item->noreg }}</td>
                                                <td>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal" data-bs-target="#modal{{ $item->noreg }}">
                                                        {{ $item->catatan }}
                                                    </a>
                                                </td>
                                            </tr>

                                            <div class="modal fade" id="modal{{ $item->noreg }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header mb-3">
                                                            <h5 class="modal-title" id="exampleModalLabel1">Verifikasi Agunan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <form action="{{ route('verifikasi.agunan', $item->noreg) }}" method="POST">
                                                            @csrf

                                                            <div class="modal-body" style="margin-top: -20px;">
                                                                <div class="row">
                                                                    <div class="d-flex justify-content-between">
                                                                        <label class="form-label">Kondisi Agunan</label>
                                                                    </div>
                                                                    <div class="col">
                                                                        <textarea class="form-control" name="kondisi" rows="3" required></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="d-flex justify-content-between">
                                                                        <label class="form-label">Penguasaan Agunan</label>
                                                                    </div>
                                                                    <div class="col">
                                                                        <textarea class="form-control" name="penguasaan" rows="3" required></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary">Update</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @empty
                                            <tr>
                                                <td colspan=" 2" class="text-center">Data tidak ditemukan
                                                </td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <br>
                                <div>
                                    <a href="{{ route('postra.edit', $tugas->notugas) }}" class="btn btn-label-secondary waves-effect">Kembali</a>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection