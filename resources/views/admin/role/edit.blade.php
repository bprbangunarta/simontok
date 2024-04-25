@extends('layouts.app')
@section('title', 'Kelola Roles')

@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <div class="row">

            <!-- Add Role -->
            <div class="col-xl-4 mb-4 col-lg-5 col-12">
                <div class="card">
                    <div class="d-flex align-items-end row">
                        <div class="col-12">
                            <div class="card-body text-nowrap">
                                <form action="{{ route('role.update', $role->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label class="form-label">Role Name</label>
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                               id="name" name="name" value="{{ $role->name }}">

                                        @error('name')
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <div class="mb-3">
                                        <label class="form-label">Guard Name</label>
                                        <input type="text" class="form-control @error('guard_name') is-invalid @enderror"
                                               id="guard_name" name="guard_name" value="{{ $role->guard_name }}">

                                        @error('guard_name')
                                        <div
                                            class="fv-plugins-message-container fv-plugins-message-container--enabled invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>

                                    <button type="submit" class="btn btn-primary waves-effect waves-light"
                                            style="width: 100%;">
                                        Update
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Add Role -->

            <!-- Role List -->
            <div class="col-xl-8 mb-4 col-lg-7 col-12">
                <div class="card">
                    <div id="DataTables_Table_0_wrapper" class="dataTables_wrapper dt-bootstrap5 no-footer border-bottom">
                        <div class="row mx-1">
                            <div class="col-sm-12 col-md-3">
                                <div class="dataTables_length" id="DataTables_Table_0_length">
                                    <button type="button" class="btn btn-outline-primary waves-effect">List Role</button>
                                </div>
                            </div>
                            <div class="col-sm-12 col-md-9">
                                <div
                                    class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-md-end justify-content-center flex-wrap me-1">
                                    <div>
                                        <form action="{{ route('role.index') }}" method="GET">
                                            <div class="dataTables_filter">
                                                <label>Search
                                                    <input type="search" class="form-control" name="search"
                                                           value="{{ request('search') }}" placeholder="Search..">
                                                </label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card-body" style="margin-top: -20px;">
                        <div class="table-responsive text-nowrap mb-3" style="border-bottom: 1px solid #DBDADE;">
                            <table class="table">
                                <thead class="fw-bold">
                                <tr class="text-danger">
                                    <td>Nama Role</td>
                                    <td>Guard</td>
                                    <td class="text-center" width="10%">Action</td>
                                </tr>
                                </thead>
                                <tbody class="table-border-bottom-0">
                                @forelse ($roles as $index => $item)
                                    <tr>
                                        <td>{{ $item->name }}</td>

                                        <td>{{ $item->guard_name }}</td>

                                        <td class="text-center">
                                            <a href="{{ route('role.edit', $item->id) }}">
                                            <span class="badge badge-center bg-warning w-px-30 h-px-30">
                                                <i class="ti ti-user-edit ti-sm"></i>
                                            </span>
                                            </a>

                                            <a href="{{ route('role.destroy', $item->id) }}"
                                               onclick="event.preventDefault(); if(confirm('Apakah Anda yakin ingin menghapus role ini?')) { document.getElementById('delete-form-{{ $item->id }}').submit(); }">
                                            <span class="badge badge-center bg-danger w-px-30 h-px-30">
                                                <i class="ti ti-trash ti-sm"></i>
                                            </span>
                                            </a>
                                            <form id="delete-form-{{ $item->id }}"
                                                  action="{{ route('role.destroy', $item->id) }}" method="POST"
                                                  style="display: none;">
                                                @csrf
                                                @method('DELETE')
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="10">No matching records found</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="row" style="margin-bottom: -30px;">
                            <div class="col-sm-12 col-md-12">
                                <div>
                                    <nav aria-label="Page navigation">
                                        {{ $roles->withQueryString()->onEachSide(0)->links('helper.pagination') }}
                                    </nav>
                                </div>
                            </div>

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
@endpush
