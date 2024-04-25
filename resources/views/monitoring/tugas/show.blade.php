@extends('layouts.app')
@section('title', 'Surat Tugas')

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
                                    <input type="text" class="form-control" name="nokredit" value="{{ $tugas->nokredit }}" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Nama Debitur</label>
                                    <input type="text" class="form-control" name="nama_debitur" value="{{ $tugas->nama_debitur }}" readonly>
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
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('tugas.update', $tugas->notugas) }}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="row" style="margin-top: -10px;">
                            @if ($tugas->aksesUpload == 'disabled')
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Pelaksanaan</label>
                                <input type="text" class="form-control" name="pelaksanaan" value="{{ $tugas->pelaksanaan }}" readonly>
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Hasil Penanganan</label>
                                <input type="text" class="form-control" name="hasil" value="{{ $tugas->hasil }}" readonly>
                            </div>
                            @else
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Pelaksanaan</label>
                                <select class="select2 form-select @error('pelaksanaan') is-invalid @enderror" data-allow-clear="true" name="pelaksanaan">
                                    <option value="">Select</option>
                                    @foreach ($pelaksanaan as $item)
                                    <option value="{{ $item['detail'] }}" {{ $tugas->jenis == $item['pelaksanaan'] ? 'selected' : '' }}>
                                        {{ $item['detail'] }}
                                    </option>
                                    @endforeach
                                </select>

                                @error('pelaksanaan')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Hasil Penanganan</label>
                                <select class="select2 form-select @error('hasil') is-invalid @enderror" data-allow-clear="true" name="hasil">
                                    <option value="">Select</option>
                                    @foreach ($hasil as $item)
                                    <option value="{{ $item['hasil'] }}" {{ $tugas->hasil == $item['hasil'] ? 'selected' : '' }}>
                                        {{ $item['hasil'] }}
                                    </option>
                                    @endforeach
                                </select>

                                @error('hasil')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>
                            @endif

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Ket. Penanganan</label>
                                <textarea class="form-control @error('ket_pelaksanaan') is-invalid @enderror" name="ket_pelaksanaan" rows="5" {{ $tugas->aksesLaporan }}>{{ $tugas->ket_pelaksanaan }}</textarea>

                                @error('ket_pelaksanaan')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Ket. Hasil</label>
                                <textarea class="form-control @error('ket_hasil') is-invalid @enderror" name="ket_hasil" rows="5" {{ $tugas->aksesLaporan }}>{{ $tugas->ket_hasil }}</textarea>

                                @error('ket_hasil')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="form-label">Catatan Leader</label>
                                <textarea class="form-control @error('catatan_leader') is-invalid @enderror" name="catatan_leader" rows="3" {{ $tugas->aksesCatatan }}>{{ $tugas->catatan_leader }}</textarea>

                                @error('catatan_leader')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div>
                            <a href="{{ route('tugas.index') }}" class="btn btn-label-secondary waves-effect">Kembali</a>
                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Simpan</button>
                        </div>
                    </form>


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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        var select = document.getElementById('pelaksanaan');
        select.addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            for (var i = 0; i < this.options.length; i++) {
                if (this.options[i] !== selectedOption) {
                    this.options[i].disabled = true;
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        var select = document.getElementById('hasil');
        select.addEventListener('change', function() {
            var selectedOption = this.options[this.selectedIndex];
            for (var i = 0; i < this.options.length; i++) {
                if (this.options[i] !== selectedOption) {
                    this.options[i].disabled = true;
                }
            }
        });
    });
</script>
@endpush