@extends('layouts.app')
@section('title', 'Edit User')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="card">
        <div class="card-body">
            <form action="{{ route('user.update', $user->id) }}" method="POST">
                @method('PUT')
                @csrf

                <div class="row" style="margin-top: -15px;">
                    <div class="col-md-6 mt-2">
                        <label class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('name') is-invalid @enderror" value="{{ $user->name }}" name="name">

                        @error('name')
                        <div class="mt-1">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-2">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control @error('username') is-invalid @enderror" value="{{ $user->username }}" name="username">

                        @error('username')
                        <div class="mt-1">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-2">
                        <label class="form-label">Nomor HP</label>
                        <input type="text" class="form-control @error('phone') is-invalid @enderror" value="{{ $user->phone }}" name="phone">

                        @error('phone')
                        <div class="mt-1">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-2">
                        <label class="form-label">Alamat Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror""
                                value=" {{ $user->email }}" name="email">

                        @error('email')
                        <div class="mt-1">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-3 mt-2">
                        <label class="form-label">Wilayah</label>
                        <select class="select2 form-select @error('kantor_id') is-invalid @enderror" data-allow-clear="true" name="kantor_id">
                            <option value="">Select</option>
                            @foreach ($kantor as $item)
                            <option value="{{ $item->id }}" {{ $user->kantor_id == $item->id ? 'selected' : '' }}>
                                {{ $item->nama }}
                            </option>
                            @endforeach
                        </select>

                        @error('kantor_id')
                        <div class="mt-1">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-3 mt-2">
                        <div>
                            <label class="form-label">Kode Petugas</label>
                            <div class="input-group input-group-merge">
                                <input type="text" class="form-control cvv-code-mask @error('kode') is-invalid @enderror" value="{{ $user->kode }}" name="kode">
                                <span class="input-group-text cursor-pointer">
                                    <i class="ti ti-help text-muted" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-original-title="Kode diberikan oleh direksi"></i>
                                </span>
                            </div>
                        </div>

                        @error('kode')
                        <div class="mt-1">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-2">
                        <label class="form-label">Kode Kolektor</label>
                        <select class="select2 form-select @error('kode_kolektor') is-invalid @enderror" data-allow-clear="true" name="kode_kolektor">
                            <option value="">Select</option>
                            @foreach ($kolektor as $item)
                            <option value="{{ $item->kodeao }}" {{ $user->kode_kolektor == $item->kodeao ? 'selected' : '' }}>
                                {{ $item->kodeao }} {{ $item->ket }}
                            </option>
                            @endforeach
                        </select>

                        @error('kode_kolektor')
                        <div class="mt-1">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-2">
                        <label class="form-label">Role</label>
                        <select class="select2 form-select @error('role') is-invalid @enderror" data-allow-clear="true" name="role">
                            <option value="">Select</option>
                            @foreach ($roles as $item)
                            <option value="{{ $item->name }}" {{ $user->role == $item->name ? 'selected' : '' }}>
                                {{ $item->name }}
                            </option>
                            @endforeach
                        </select>

                        @error('role')
                        <div class="mt-1">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>

                    <div class="col-md-6 mt-2">
                        <label class="form-label">Status</label>
                        <select class="select2 form-select @error('is_active') is-invalid @enderror" data-allow-clear="true" name="is_active">
                            <option value="">Select</option>
                            @foreach ($status as $item)
                            <option value="{{ $item['id'] }}" {{ $user->is_active == $item['id'] ? 'selected' : '' }}>
                                {{ $item['name'] }}
                            </option>
                            @endforeach
                        </select>

                        @error('is_active')
                        <div class="mt-1">
                            <small class="text-danger">{{ $message }}</small>
                        </div>
                        @enderror
                    </div>
                </div>

                <div class="pt-4">
                    <a href="{{ route('user.index') }}" class="btn btn-label-secondary waves-effect">Kembali</a>
                    <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Ubah</button>
                    <button type="reset" class="btn btn-label-secondary waves-effect me-2" style="float: right;">Reset</button>
                </div>
            </form>
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
                    placeholder: 'Pilih Role',
                    dropdownParent: $this.parent()
                });
            });
        }
    });
</script>
@endpush