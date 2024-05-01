@extends('layouts.app')
@section('title', 'Tambah Prospek')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <div class="col-xl-4 mb-4 col-lg-5 col-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-12">
                        <div class="card-body text-nowrap">

                            <div class="mb-3">
                                <label class="form-label">Petugas</label>
                                <input type="text" class="form-control" value="{{ Auth::user()->name; }}" readonly>
                            </div>

                            <div class="mb-3">
                                <img class="img-fluid rounded-3" src="{{ url($image) }}">
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-8 mb-4 col-lg-7 col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{ route('prospek.store') }}" method="POST">
                        @csrf

                        <div class="row" style="margin-top: -10px;">
                            <div class="col-md-6 mt-2">
                                <label class="form-label">Jenis</label>
                                <select class="select2 form-select @error('jenis') is-invalid @enderror" data-allow-clear="true" name="jenis">
                                    <option value="">Select</option>
                                    @foreach ($jenis as $item)
                                    <option value="{{ $item['jenis'] }}" {{ old('jenis') == $item['jenis'] ? 'selected' : '' }}>
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
                                    <option value="{{ $item['id'] }}" {{ old('status') == $item['id'] ? 'selected' : '' }}>
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
                                <input type="text" class="form-control @error('calon_debitur') is-invalid @enderror" name="calon_debitur" value="{{ old('calon_debitur') }}">

                                @error('calon_debitur')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-6 mt-2">
                                <label class="form-label">Nomor Telp</label>
                                <input type="text" class="form-control @error('nohp') is-invalid @enderror" name="nohp" value="{{ old('nohp') }}">

                                @error('nohp')
                                <div class="mt-1">
                                    <small class="text-danger">{{ $message }}</small>
                                </div>
                                @enderror
                            </div>

                            <div class="col-md-12 mt-2">
                                <label class="form-label">Keterangan</label>
                                <textarea class="form-control @error('keterangan') is-invalid @enderror" name="keterangan" rows="4">{{ old('keterangan') }}</textarea>

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
                            <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Tambah</button>
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