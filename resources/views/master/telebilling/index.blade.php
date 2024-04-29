@extends('layouts.app')
@section('title', 'Telebilling')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">

    <div class="card">
        <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer border-bottom">
            <div class="row mx-1">
                <div class="col-sm-12 col-md-6">
                    <div class="dataTables_length">
                        <button type="button" class="btn btn-outline-primary waves-effect">Telebilling</button>
                    </div>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1">
                        <div>
                            <form action="{{ route('telebilling.index') }}" method="GET">
                                <div class="dataTables_filter">
                                    <label>Pencarian
                                        <input type="search" class="form-control" name="search" value="{{ request('search') }}">
                                    </label>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="card-body" style="margin-top: -20px;">
            <div class="table-responsive text-nowrap mb-3">
                <table class="table" style="font-size: 13px;">
                    <thead class="fw-bold">
                        <tr>
                            <td style="width:10%;">Tabungan</td>
                            <td>Nama</td>
                            <td>Tunggakan</td>
                            <td>Hari</td>
                            <td>Wilayah</td>
                            <td>Petugas</td>
                            <td class="text-center" style="width:10%;">Aksi</td>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kredit as $index => $item)
                        @php
                        $pokok = $item->tunggakan->tunggakan_pokok;
                        $bunga = $item->tunggakan->tunggakan_bunga;
                        $denda = $item->tunggakan->tunggakan_denda;
                        $total = $pokok + $bunga + $denda;
                        @endphp
                        <tr>
                            <td>{{ $item->notabungan }}</td>
                            <td>{{ $item->nama_debitur }}</td>
                            <td>Rp {{ number_format($total, 0, ',', '.') }}</td>
                            <td>{{ $item->hari_tunggakan }} Hari</td>
                            <td>
                                <a href="{{ route('telebilling.index') }}?search={{ $item->wilayah }}" class="text-primary">
                                    {{ $item->wilayah }}
                                </a>
                            </td>
                            <td class="text-uppercase">
                                @if ($item->petugas)
                                <a href="{{ route('kredit.index') }}?search={{ $item->petugas->name }}" class="text-primary">
                                    {{ $item->petugas->username }}
                                </a>
                                @else
                                <a href="{{ route('kredit.index') }}?search={{ $item->kode_petugas }}" class="text-danger">
                                    {{ $item->kode_petugas }}
                                </a>
                                @endif
                            </td>
                            <td class="text-center">
                                <a href="{{ route('telebilling.show', $item->nokredit) }}">
                                    <span class="badge badge-center bg-warning w-px-30 h-px-30">
                                        <i class="ti ti-file-text ti-sm"></i>
                                    </span>
                                </a>
                                @can('Telebilling Create')
                                <a href="{{ $item->whatsapp }}" target="_blank">
                                    <span class="badge badge-center bg-success w-px-30 h-px-30">
                                        <i class="ti ti-brand-whatsapp ti-sm"></i>
                                    </span>
                                </a>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" class="text-center">Data tidak ditemukan</td>
                        </tr>
                        @endforelse
                    </tbody>

                </table>
            </div>

            <div class="row" style="margin-bottom: -30px;">
                <div class="col-sm-12 col-md-12">
                    <div>
                        <nav aria-label="Page navigation">
                            {{ $kredit->withQueryString()->onEachSide(0)->links('helper.pagination') }}
                        </nav>
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