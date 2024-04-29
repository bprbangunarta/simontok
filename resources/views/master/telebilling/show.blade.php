@extends('layouts.app')
@section('title', 'Detail Kredit')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <div class="col-xl-5 col-lg-5 col-12 mb-3">
            <div class="card">
                <div class="card-body text-nowrap">
                    <form action="{{ route('telebilling.store') }}" method="POST">
                        @csrf
                        <div class="mb-2">
                            <label class="form-label">Nama Debitur</label>
                            <input type="text" class="form-control" name="nokredit" value="{{ $kredit->nokredit }}" hidden>
                            <input type="text" class="form-control" value="{{ $kredit->nama_debitur }}" readonly>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Nomor HP</label>
                            <input type="text" class="form-control" value="{{ $cif->nohp }}" readonly>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Tunggakan</label>
                            <input type="text" class="form-control" value="{{ $kredit->total }}" readonly>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Hasil</label>
                            <select class="select2 form-select" data-allow-clear="true" name="hasil" required>
                                <option value="">Select</option>
                                @foreach ($hasil as $item)
                                <option value="{{ $item['hasil'] }}" {{ old('hasil') == $item['hasil'] ? 'selected' : '' }}>
                                    {{ $item['hasil'] }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-2">
                            <label class="form-label">Keterangan</label>
                            <textarea class="form-control @error('ket_hasil') is-invalid @enderror" rows="3" name="ket_hasil">{{ old('ket_hasil') }}</textarea>

                            @error('ket_hasil')
                            <div class="mt-1">
                                <small class="text-danger">{{ $message }}</small>
                            </div>
                            @enderror
                        </div>
                        @can('Telebilling Create')
                        <div class="mb-3">
                            <label class="form-label">Janji Bayar</label>
                            <input type="date" class="form-control" name="janji_bayar" value="{{ old('janji_bayar') }}">
                        </div>

                        <a href="#" onclick="history.back()" class="btn btn-label-secondary waves-effect">Kembali</a>

                        <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">
                            Telebilling
                        </button>
                        @endcan
                    </form>
                </div>
            </div>
        </div>

        <div class="col-xl-7 col-lg-7 col-12 mb-3">
            <div class="nav-align-top nav-tabs-shadow ">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link active" role="tab" data-bs-toggle="tab" data-bs-target="#tabKredit" aria-controls="tabKredit" aria-selected="true">Kredit</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tabAgunan" aria-controls="tabAgunan" aria-selected="false" tabindex="-1">Agunan</button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button type="button" class="nav-link" role="tab" data-bs-toggle="tab" data-bs-target="#tabPenanganan" aria-controls="tabPenanganan" aria-selected="false" tabindex="-1">Penanganan</button>
                    </li>
                </ul>

                <div class="tab-content">
                    <div class="tab-pane fade active show" id="tabKredit" role="tabpanel">
                        <div class="row" style="margin-top: -15px;">
                            <div class="col-md-6 mt-2">
                                <label class="form-label">No. CIF</label>
                                <input type="text" class="form-control" value="{{ $kredit->nocif }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">No. SPK</label>
                                <input type="text" class="form-control" value="{{ $kredit->nospk }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">No. Kredit</label>
                                <input type="text" class="form-control" value="{{ $kredit->nokredit }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">No. Tabungan</label>
                                <input type="text" class="form-control" value="{{ $kredit->notabungan }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Plafon</label>
                                <input type="text" class="form-control" value="{{ $kredit->plafon }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Baki Debet</label>
                                <input type="text" class="form-control" value="{{ $kredit->baki_debet }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Jangka Waktu</label>
                                <input type="text" class="form-control" value="{{ $kredit->jangka_waktu }} Bulan" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Rate Bunga</label>
                                <input type="text" class="form-control" value="{{ $kredit->rate_bunga }}%" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Metode RPS</label>
                                <input type="text" class="form-control" value="{{ $kredit->metode_rps }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">kolektibilitas</label>
                                <input type="text" class="form-control" value="Coll {{ $kredit->kolektibilitas }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Realisasi</label>
                                <input type="text" class="form-control" value="{{ $kredit->tgl_realisasi }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Jth. Tempo</label>
                                <input type="text" class="form-control" value="{{ $kredit->tgl_jatuh_tempo }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Tunggakan Pokok</label>
                                <input type="text" class="form-control" value="{{ $kredit->tunggakan_pokok }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Tunggakan Bunga</label>
                                <input type="text" class="form-control" value="{{ $kredit->tunggakan_bunga }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Tunggakan Denda</label>
                                <input type="text" class="form-control" value="{{ $kredit->tunggakan_denda }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Tunggakan Hari</label>
                                <input type="text" class="form-control" value="{{ $kredit->hari_tunggakan }} Hari" readonly>
                            </div>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tabAgunan" role="tabpanel">
                        <div class="row" style="margin-top: -10px;">
                            <table class="table">
                                <tbody>
                                    @forelse ($agunan as $item)
                                    <tr>
                                        <td>{{ $item->agunan }}</td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="2" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="tabPenanganan" role="tabpanel">
                        <div class="accordion accordion-bordered" id="riwayatTugas">
                            @php
                            $firstItem = true;
                            @endphp
                            @forelse ($tugas->take(5) as $index => $item)
                            <div class="accordion-item card">
                                <h2 class="accordion-header">
                                    <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#riwayatTugas-{{ $item->notugas }}" aria-expanded="false">
                                        {{ $item->tanggal }}
                                    </button>
                                </h2>

                                <div id="riwayatTugas-{{ $item->notugas }}" class="accordion-collapse collapse {{ $firstItem ? ' show' : '' }}" data-bs-parent="#riwayatTugas">
                                    <div class="accordion-body">
                                        {{ $item->petugas->name }} melakukan {{ $item->jenis }} | <a href="#" data-bs-toggle="modal" data-bs-target="#fotoPenanganan-{{ $item->notugas }}"><strong>Lihat Foto</strong></a>

                                        <p></p>
                                        <strong>Pelaksanaan</strong> <br>
                                        {{ $item->pelaksanaan }}

                                        <p></p>
                                        <strong>Hasil {{ $item->jenis }}</strong> <br>
                                        {{ $item->hasil }}

                                        <p></p>
                                        <strong>Catatan Leader</strong> <br>
                                        {{ $item->catatan_leader }}

                                        <p></p>
                                        <table class="table border-top">
                                            <tr>
                                                <td>Pokok</td>
                                                <td>Bunga</td>
                                                <td>Denda</td>
                                                <td>Total</td>
                                            </tr>
                                            <tr>
                                                <td>{{ number_format($item->tunggakan_pokok, 0, ',', '.') }}</td>
                                                <td>{{ number_format($item->tunggakan_bunga, 0, ',', '.') }}</td>
                                                <td>{{ number_format($item->tunggakan_denda, 0, ',', '.') }}</td>
                                                <td>{{ number_format($item->tunggakan_pokok + $item->tunggakan_bunga + $item->tunggakan_denda, 0, ',', '.') }}</td>
                                            </tr>

                                        </table>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal -->
                            <div class="modal fade" id="fotoPenanganan-{{ $item->notugas }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header mb-3">
                                            <h5 class="modal-title" id="exampleModalLabel1">Foto {{ $item->jenis }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <img src="/{{ $item->foto_pelaksanaan }}">
                                    </div>
                                </div>
                            </div>
                            @php
                            $firstItem = false;
                            @endphp
                            @empty
                            <div class="accordion-item card">
                                <h2 class="accordion-header">
                                    <button type="button" class="accordion-button collapsed">
                                        Tidak ada riwayat penanganan
                                    </button>
                                </h2>
                            </div>
                            @endforelse
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
<script>
    $(function() {
        const select2 = $('.select2');

        if (select2.length) {
            select2.each(function() {
                var $this = $(this);
                $this.wrap('<div class="position-relative"></div>').select2({
                    placeholder: 'Select Value',
                    dropdownParent: $this.parent()
                });
            });
        }
    });
</script>
@endpush