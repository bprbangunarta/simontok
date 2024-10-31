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
                            <div class="mb-3">
                                <label class="form-label">No. Kredit</label>
                                <input type="text" class="form-control" value="{{ $kredit->nokredit }}" readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Debitur</label>
                                <input type="text" class="form-control" value="{{ $kredit->nama_debitur }}" readonly>
                            </div>

                            <div class="mb-3">
                                <img class="img-fluid rounded-3" src="{{ Storage::url('uploads/tugas/' . 'default.png') }}">
                            </div>

                            <div class="mb-3">
                                <input type="file" class="form-control" name="foto_pelaksanaan" accept=".heic, .jpg, .jpeg, .png">
                            </div>

                            <div class="mb-0">
                                <button type="submit" class="btn btn-primary waves-effect waves-light w-100">Upload</button>
                            </div>
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
                                    <a href="{{ route('postra.create', $kredit->nokredit) }}" class="nav-link {{ Request::query('data') == null ? 'active' : '' }}">Verifikasi Kredit</a>
                                </li>

                                <li class="nav-item">
                                    <a href="#" class="nav-link">Verifikasi Agunan</a>
                                </li>
                            </ul>
                        </div>

                        <div class="tab-content">
                            <div class="tab-pane fade active show">
                                <form action="{{ route('postra.store', $kredit->nokredit) }}" method="POST">
                                    @csrf
                                    <div class="row" style="margin-top: -10px;">
                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Pengguna Kredit</label>
                                            <input type="text" class="form-control" name="pengguna_kredit" value="{{ old('pengguna_kredit') ?? $kredit->nama_debitur }}">

                                            @error('pengguna_kredit')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Penggunaan Kredit</label>
                                            <input type="text" class="form-control" name="penggunaan_kredit" value="{{ old('penggunaan_kredit') }}">


                                            @error('penggunaan_kredit')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Alamat Debitur</label>
                                            <textarea class="form-control" name="alamat_rumah" rows="4">{{ old('alamat_rumah') ?? $kredit->alamat }}</textarea>

                                            @error('alamat_rumah')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Cara Pembayaran</label>
                                            <textarea class="form-control" name="cara_pembayaran" rows="4">{{ old('cara_pembayaran') }}</textarea>

                                            @error('cara_pembayaran')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Pekerjaan Debitur</label>
                                            <textarea class="form-control" name="usaha_debitur" rows="4">{{ old('usaha_debitur') }}</textarea>

                                            @error('usaha_debitur')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Karakter / Kondisi Debitur</label>
                                            <textarea class="form-control" name="karakter_debitur" rows="4">{{ old('karakter_debitur') }}</textarea>

                                            @error('karakter_debitur')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Nomor Debitur</label>
                                            <input class="form-control" type="number" name="nomor_debitur" value="{{ old('nomor_debitur') ?? trim($nasabah->nohp) }}">

                                            @error('nomor_debitur')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>

                                        <div class="col-md-6 mt-2">
                                            <label class="form-label">Nomor Pendamping</label>
                                            <input class="form-control" type="number" name="nomor_pendamping" value="{{ old('nomor_pendamping') ?? trim($nasabah->nofax) }}">

                                            @error('nomor_pendamping')
                                            <small class="text-danger">{{ $message }}</small>
                                            @enderror
                                        </div>
                                    </div>

                                    <hr>
                                    <div>
                                        <a href="{{ route('postra.index') }}" class="btn btn-label-secondary waves-effect">Kembali</a>
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