@extends('layouts.app')
@section('title', 'Detail Prospek')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <div class="col-xl-4 mb-4 col-lg-5 col-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-12">
                        <div class="card-body text-nowrap">

                            <form action="{{ route('prospek.upload') }}" method="POST" enctype="multipart/form-data">
                                @csrf

                                <input type="text" class="form-control" name="id" value="{{ $prospek->id }}" hidden>

                                <div class="mb-3">
                                    <label class="form-label">Petugas</label>
                                    <input type="text" class="form-control" value="{{ $prospek->petugas->name }}" readonly>
                                </div>

                                @if ($prospek->aksesForm == 'disabled')
                                <div class="mb-0">
                                    <img class="img-fluid rounded-3" src="{{ url($prospek->foto_pelaksanaan) }}">
                                </div>
                                @else
                                <div class="mb-3">
                                    <img class="img-fluid rounded-3" src="{{ url($prospek->foto_pelaksanaan) }}">
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

                    <form action="{{ route('prospek.update', $prospek->id) }}" method="POST">
                        @method('PUT')
                        @csrf

                        <div class="row" style="margin-top: -10px;">
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Jenis</label>
                                <select class="select2 form-select @error('jenis') is-invalid @enderror" data-allow-clear="true" name="jenis">
                                    <option value="">Select</option>
                                    @foreach ($jenis as $item)
                                    <option value="{{ $item['jenis'] }}" {{ $prospek->jenis == $item['jenis'] ? 'selected' : '' }}>
                                        {{ $item['jenis'] }}
                                    </option>
                                    @endforeach
                                </select>

                                @error('jenis')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Status</label>
                                <select class="select2 form-select @error('status') is-invalid @enderror" data-allow-clear="true" name="status">
                                    <option value="">Select</option>
                                    @foreach ($status as $item)
                                    <option value="{{ $item['id'] }}" {{ $prospek->status == $item['id'] ? 'selected' : '' }}>
                                        {{ $item['status'] }}
                                    </option>
                                    @endforeach
                                </select>

                                @error('status')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Calon Debitur</label>
                                <input type="text" class="form-control @error('calon_debitur') is-invalid @enderror" name="calon_debitur" value="{{ $prospek->calon_debitur }}">

                                @error('calon_debitur')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Nomor Telp</label>
                                <input type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp" value="{{ $prospek->nohp }}">

                                @error('nohp')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="4">{{ $prospek->keterangan }}</textarea>

                                @error('keterangan')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>
                        </div>

                        <hr>
                        <div>
                            <a href="{{ route('prospek.index') }}" class="btn btn-label-secondary waves-effect">Kembali</a>
                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;" {{ $prospek->aksesForm }}>Simpan</button>
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
@endpush