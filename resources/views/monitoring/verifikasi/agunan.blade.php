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
                                    <img class="img-fluid rounded-3" src="/images/tugas/{{ $tugas->foto_pelaksanaan }}">
                                </div>
                                @else
                                <div class="mb-3">
                                    <img class="img-fluid rounded-3" src="/images/tugas/{{ $tugas->foto_pelaksanaan }}">
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
                                <div class="row" style="margin-top: -10px;">
                                    <table class="table border-top">
                                        <thead>
                                            <tr>
                                                <td>Noreg</td>
                                                <td>Agunan</td>
                                                <td style="width: 10%;">Aksi</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse ($agunan as $item)
                                            <tr class="{{ $item->tableColor }}">
                                                <td>{{ $item->noreg }}</td>
                                                <td>{{ $item->agunan }}</td>

                                                @if (is_null($item->verifikasi))
                                                <td class="text-center">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#addAgunan-{{ $item->noreg }}">
                                                        <span class="badge badge-center {{ $item->btnColor }} w-px-30 h-px-30">
                                                            <i class="ti ti-clipboard-check ti-sm"></i>
                                                        </span>
                                                    </a>
                                                </td>
                                                @else
                                                <td class="text-center">
                                                    <a href="#" data-bs-toggle="modal" data-bs-target="#verifAgunan-{{ $item->noreg }}">
                                                        <span class="badge badge-center {{ $item->btnColor }} w-px-30 h-px-30">
                                                            <i class="ti ti-clipboard-check ti-sm"></i>
                                                        </span>
                                                    </a>
                                                </td>
                                                @endif
                                            </tr>

                                            @if (is_null($item->verifikasi))
                                            <!-- Modal Add-->
                                            <div class="modal fade" id="addAgunan-{{ $item->noreg }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header mb-3">
                                                            <h5 class="modal-title" id="exampleModalLabel1">Verifikasi Agunan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <form action="{{ route('verifikasi.agunan', $item->noreg) }}" method="POST">
                                                            @csrf

                                                            <div class="modal-body" style="margin-top: -20px;">
                                                                <input class="form-control mb-2" type="text" name="notugas" value="{{ $tugas->notugas }}" hidden>
                                                                <input class="form-control mb-2" type="text" name="agunan" value="{{ $item->agunan }}" hidden>

                                                                <div class="row">
                                                                    <div class="d-flex justify-content-between">
                                                                        <label class="form-label">Kondisi Agunan</label>
                                                                    </div>
                                                                    <div class="col">
                                                                        <textarea class="form-control" name="kondisi" rows="3" required {{ $tugas->aksesLaporan }}></textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="d-flex justify-content-between">
                                                                        <label class="form-label">Penguasaan Agunan</label>
                                                                    </div>
                                                                    <div class="col">
                                                                        <textarea class="form-control" name="penguasaan" rows="3" required {{ $tugas->aksesLaporan }}></textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary" {{ $tugas->btnVerifikasi }}>Verifikasi</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>

                                            @else
                                            <!-- Modal Update -->
                                            <div class="modal fade" id="verifAgunan-{{ $item->noreg }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header mb-3">
                                                            <h5 class="modal-title" id="exampleModalLabel1">Verifikasi Agunan</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                        </div>

                                                        <form action="{{ route('verifikasi.agunan', $item->noreg) }}" method="POST">
                                                            @method('PUT')
                                                            @csrf

                                                            <div class="modal-body" style="margin-top: -20px;">
                                                                <div class="row">
                                                                    <div class="d-flex justify-content-between">
                                                                        <label class="form-label">Kondisi Agunan</label>
                                                                    </div>
                                                                    <div class="col">
                                                                        <textarea class="form-control" name="kondisi" rows="3" required {{ $tugas->aksesLaporan }}>{{ $item->verifikasi->kondisi }}</textarea>
                                                                    </div>
                                                                </div>

                                                                <div class="row mt-3">
                                                                    <div class="d-flex justify-content-between">
                                                                        <label class="form-label">Penguasaan Agunan</label>
                                                                    </div>
                                                                    <div class="col">
                                                                        <textarea class="form-control" name="penguasaan" rows="3" required {{ $tugas->aksesLaporan }}>{{ $item->verifikasi->penguasaan }}</textarea>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">Tutup</button>
                                                                <button type="submit" class="btn btn-primary" {{ $tugas->btnVerifikasi }}>Verifikasi</button>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif

                                            @empty
                                            <tr>
                                                <td colspan="2" class="text-center">Data tidak ditemukan</td>
                                            </tr>
                                            @endforelse
                                        </tbody>
                                    </table>
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