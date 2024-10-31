<li class="menu-item {{ Request::is('dashboard') ? 'active' : '' }}">
    <a href="{{ route('dashboard') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-home"></i>
        <div data-i18n="Dashboard">Dashboard</div>
    </a>
</li>
<li class="menu-item {{ Request::is('profile', 'password') ? 'active' : '' }}">
    <a href="{{ route('profile') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-user-cog"></i>
        <div data-i18n="User Profile">User Profile</div>
    </a>
</li>

@role('Super Admin')
<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Administrator</span>
</li>

<li class="menu-item {{ Request::is('user', 'user/create', 'user/*/edit', 'user/*/access') ? 'active' : '' }}">
    <a href="{{ route('user.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-user"></i>
        <div>Kelola Users</div>
    </a>
</li>

<li class="menu-item {{ Request::is('role', 'role/*/edit') ? 'active' : '' }}">
    <a href="{{ route('role.index')  }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-lock"></i>
        <div>Kelola Roles</div>
    </a>
</li>

<li class="menu-item {{ Request::is('permission', 'permission/*/edit') ? 'active' : '' }}">
    <a href="{{ route('permission.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-key"></i>
        <div>Permissions</div>
    </a>
</li>
@endrole

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Maste Data</span>
</li>


<li class="menu-item {{ Request::is('telebilling', 'telebilling/*') ? 'active' : '' }}">
    <a href="{{ route('telebilling.index') }}" class="menu-link @can('Telebilling Read') @else disable-clik @endcan">
        <i class="menu-icon tf-icons ti ti-devices"></i>
        <div>Telebilling</div>
    </a>
</li>

<li class="menu-item {{ Route::is('postra.index', 'postra.show') ? 'active' : '' }}">
    <a href="{{ route('postra.index') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-table-alias"></i>
        <div>Data Postra</div>
    </a>
</li>

<li class="menu-item {{ Request::is('kredit', 'kredit/*') ? 'active' : '' }}">
    <a href="{{ route('kredit.index') }}" class="menu-link @can('Kredit Read') @else disable-clik @endcan">
        <i class="menu-icon tf-icons ti ti-credit-card"></i>
        <div>Data Kredit</div>
    </a>
</li>

<li class="menu-item {{ Request::is('writeoff', 'writeoff/*') ? 'active' : '' }}">
    <a href="{{ route('writeoff.index') }}" class="menu-link @can('Writeoff Read') @else disable-clik @endcan">
        <i class="menu-icon tf-icons ti ti-notes-off"></i>
        <div>Data Writeoff</div>
    </a>
</li>

<li class="menu-item {{ Request::is('agunan') ? 'active' : '' }}">
    <a href="{{ route('agunan.index') }}" class="menu-link @can('Agunan Read') @else disable-clik @endcan">
        <i class="menu-icon tf-icons ti ti-armchair"></i>
        <div>Data Agunan</div>
    </a>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Monitoring</span>
</li>

<li class="menu-item {{ Request::is('tugas', 'tugas/*/edit', 'verifikasi/kredit/*', 'verifikasi/agunan/*') ? 'active' : '' }}">
    <a href="{{ route('tugas.index') }}" class="menu-link @can('Tugas Read') @else disable-clik @endcan">
        <i class="menu-icon tf-icons ti ti-clipboard-data"></i>
        <div>Surat Tugas</div>
    </a>
</li>

<li class="menu-item {{ Request::is('prospek', 'prospek/create', 'prospek/*') ? 'active' : '' }}">
    <a href="{{ route('prospek.index') }}" class="menu-link @can('Prospek Read') @else disable-clik @endcan">
        <i class="menu-icon tf-icons ti ti-presentation"></i>
        <div>Prospek Kredit</div>
    </a>
</li>

<li class="menu-item {{ Request::is('rekap/petugas', 'rekap/wilayah') ? 'open' : '' }}">
    <a href="javascript:void(0);" class="menu-link menu-toggle">
        <i class="menu-icon tf-icons ti ti-chart-pie"></i>
        <div>Rekapitulasi</div>
    </a>
    <ul class="menu-sub">
        <li class="menu-item {{ Request::is('rekap/petugas') ? 'active' : '' }}">
            <a href="{{ route('rekap.petugas') }}" class="menu-link">
                <div>Petugas</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('rekap/wilayah') ? 'active' : '' }}">
            <a href="{{ route('rekap.wilayah') }}" class="menu-link">
                <div>Wilayah</div>
            </a>
        </li>
        <li class="menu-item {{ Request::is('rekap/prospek') ? 'active' : '' }}">
            <a href="{{ route('rekap.prospek') }}" class="menu-link">
                <div>Prospek</div>
            </a>
        </li>
    </ul>
</li>

<li class="menu-header small text-uppercase">
    <span class="menu-header-text">Reporting</span>
</li>

<li class="menu-item {{ Route::is('') ? 'active' : '' }}">
    <a href="{{ route('export.klasifikasi.kredit') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-table-down"></i>
        <div>Klasifikasi Kredit</div>
    </a>
</li>

<li class="menu-item {{ Route::is('') ? 'active' : '' }}">
    <a href="{{ route('export.penanganan.kredit') }}" class="menu-link">
        <i class="menu-icon tf-icons ti ti-table-down"></i>
        <div>Penanganan Kredit</div>
    </a>
</li>