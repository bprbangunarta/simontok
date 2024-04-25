@extends('layouts.app')
@section('title', 'Hak Akses')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">

        <!-- Add Role -->
        <div class="col-xl-4 mb-4 col-lg-5 col-12">
            <div class="card">
                <div class="d-flex align-items-end row">
                    <div class="col-12">
                        <div class="card-body text-nowrap">
                            <div class="mb-3">
                                <label class="form-label">Role Name</label>
                                <input type="text" class="form-control" value="{{ $user->roles->pluck('name')[0] ?? '' }}" readonly>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">User Name</label>
                                <input type="text" class="form-control" value="{{ $user->name  }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add Role -->

        <!-- Role List -->
        <div class="col-xl-8 mb-4 col-lg-7 col-12">
            <div class="card">
                <div class="card-body">

                    <div class="table-responsive text-nowrap">
                        <form action="{{ route('access.update', $user->id) }}" method="POST">
                            @csrf

                            <input type="text" class="form-control" value="{{ $user->id }}" hidden>
                            <table class="table">
                                <thead class="fw-bold">
                                    <tr class="text-danger">
                                        <td class="text-center">Permission</td>
                                        <td class="text-center" colspan="4" width="10%">Hak Akses</td>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="fw-bold" colspan="5">Data Master</td>
                                    </tr>
                                    <tr>
                                        <td>Data Petugas</td>
                                        @foreach($petugas as $item)
                                        @php
                                        $nameParts = explode(' ', $item->name);
                                        $permission = $nameParts[1];
                                        @endphp
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $item->name }}" {{ $user->permissions()->find($item->id) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $permission }}
                                            </label>
                                        </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td>Telebilling</td>
                                        @foreach($tebil as $item)
                                        @php
                                        $nameParts = explode(' ', $item->name);
                                        $permission = $nameParts[1];
                                        @endphp
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $item->name }}" {{ $user->permissions()->find($item->id) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $permission }}
                                            </label>
                                        </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td>Data Kredit</td>
                                        @foreach($kredit as $item)
                                        @php
                                        $nameParts = explode(' ', $item->name);
                                        $permission = $nameParts[1];
                                        @endphp
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $item->name }}" {{ $user->permissions()->find($item->id) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $permission }}
                                            </label>
                                        </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td>Data Writeoff</td>
                                        @foreach($writeoff as $item)
                                        @php
                                        $nameParts = explode(' ', $item->name);
                                        $permission = $nameParts[1];
                                        @endphp
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $item->name }}" {{ $user->permissions()->find($item->id) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $permission }}
                                            </label>
                                        </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td>Data Agunan</td>
                                        @foreach($agunan as $item)
                                        @php
                                        $nameParts = explode(' ', $item->name);
                                        $permission = $nameParts[1];
                                        @endphp
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $item->name }}" {{ $user->permissions()->find($item->id) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $permission }}
                                            </label>
                                        </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td class="fw-bold" colspan="5">Monitoring</td>
                                    </tr>

                                    <tr>
                                        <td>Surat Tugas</td>
                                        @foreach($tugas as $item)
                                        @php
                                        $nameParts = explode(' ', $item->name);
                                        $permission = $nameParts[1];
                                        @endphp
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $item->name }}" {{ $user->permissions()->find($item->id) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $permission }}
                                            </label>
                                        </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td>Prospek Kredit</td>
                                        @foreach($prospek as $item)
                                        @php
                                        $nameParts = explode(' ', $item->name);
                                        $permission = $nameParts[1];
                                        @endphp
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $item->name }}" {{ $user->permissions()->find($item->id) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $permission }}
                                            </label>
                                        </td>
                                        @endforeach
                                    </tr>

                                    <tr>
                                        <td>Verifikasi Debitur</td>
                                        @foreach($verifikasi as $item)
                                        @php
                                        $nameParts = explode(' ', $item->name);
                                        $permission = $nameParts[1];
                                        @endphp
                                        <td>
                                            <input class="form-check-input" type="checkbox" name="permissions[]" value="{{ $item->name }}" {{ $user->permissions()->find($item->id) ? 'checked' : '' }}>
                                            <label class="form-check-label">
                                                {{ $permission }}
                                            </label>
                                        </td>
                                        @endforeach
                                    </tr>
                                    @error('permissions')
                                    <tr>
                                        <td class="text-center" colspan="3"><small class="text-danger">Please select at least one permission</small></td>
                                    </tr>
                                    @enderror
                                </tbody>
                            </table>

                            <div class="pt-4">
                                <a href="{{ route('user.index') }}" class="btn btn-label-secondary waves-effect">Kembali</a>
                                <button type="submit" class="btn btn-primary waves-effect waves-light" style="float: right;">Beri Akses</button>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <!--/ Role List -->

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