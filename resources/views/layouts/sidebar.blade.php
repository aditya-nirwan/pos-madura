<div class="sidebar" data-background-color="dark">
    <div class="sidebar-logo">
        <div class="logo-header" data-background-color="dark">
            <a href="{{ url('/') }}" class="logo">
                <img src="{{ asset('assets/logo-erp.png') }}" alt="Logo" class="navbar-brand" height="50" />
            </a>

            <div class="nav-toggle">
                <button class="btn btn-toggle toggle-sidebar"><i class="gg-menu-right"></i></button>
                <button class="btn btn-toggle sidenav-toggler"><i class="gg-menu-left"></i></button>
            </div>
            <button class="topbar-toggler more"><i class="gg-more-vertical-alt"></i></button>
        </div>
    </div>


    <div class="sidebar-wrapper scrollbar scrollbar-inner">
        <div class="sidebar-content">
            <ul class="nav nav-primary">

                {{-- Dashboard --}}
                <li class="nav-item {{ request()->is('home') ? 'active' : '' }}">
                    <a href="{{ url('home') }}">
                        <i class="fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                {{-- Landing --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fas fa-desktop"></i>
                    </span>
                    <h4 class="text-section">Landing</h4>
                </li>

                <li class="nav-item {{ request()->is('') ? 'active' : '' }}">
                    <a href="{{ url('landing/barcode') }}">
                        <i class="fas fa-home"></i>
                        <p>Landing</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('carousel*') ? 'active' : '' }}">
                    <a href="{{ url('/carousel') }}">
                        <i class="fas fa-image"></i>
                        <p>Gambar Landing</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('setting*') ? 'active' : '' }}">
                    <a href="{{ url('/setting') }}">
                        <i class="fas fa-cog"></i>
                        <p>Setting</p>
                    </a>
                </li>


                {{-- Master Data --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fas fa-database"></i>
                    </span>
                    <h4 class="text-section">Master Data</h4>
                </li>
                <li class="nav-item {{ request()->is('product*') ? 'active' : '' }}">
                    <a href="{{ url('/product') }}">
                        <i class="fas fa-box"></i>
                        <p>Product</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('categori*') ? 'active' : '' }}">
                    <a href="{{ url('/categori') }}">
                        <i class="fas fa-tags"></i>
                        <p>Kategori</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('units*') ? 'active' : '' }}">
                    <a href="{{ url('/units') }}">
                        <i class="fas fa-ruler-combined"></i>
                        <p>Unit</p>
                    </a>
                </li>

                {{-- Gudang --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fas fa-warehouse"></i>
                    </span>
                    <h4 class="text-section">Gudang & Toko</h4>
                </li>
                <li class="nav-item {{ request()->is('gudang') ? 'active' : '' }}">
                    <a href="{{ url('/gudang') }}">
                        <i class="fas fa-warehouse"></i>
                        <p>Gudang</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('gudang/laporan') ? 'active' : '' }}">
                    <a href="{{ url('/gudang/laporan') }}">
                        <i class="fas fa-file-alt"></i>
                        <p>Gudang Laporan</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('laporan/pindah-toko') ? 'active' : '' }}">
                    <a href="{{ url('/laporan/pindah-toko') }}">
                        <i class="fas fa-exchange-alt"></i>
                        <p>Laporan Pindah Toko</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('cashier*') ? 'active' : '' }}">
                    <a href="{{ url('/cashier') }}">
                        <i class="fa-solid fa-cash-register"></i>
                        <p>Cashier</p>
                    </a>
                </li>

                {{-- Transaksi --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fas fa-shopping-cart"></i>
                    </span>
                    <h4 class="text-section">Transaksi</h4>
                </li>
                <li class="nav-item {{ request()->is('transaksi*') ? 'active' : '' }}">
                    <a href="{{ url('/transaksi') }}">
                        <i class="fas fa-shopping-cart"></i>
                        <p>Transaksi</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('daily-revenues*') ? 'active' : '' }}">
                    <a href="{{ url('/daily-revenues') }}">
                        <i class="fas fa-chart-line"></i>
                        <p>Daily Revenues</p>
                    </a>
                </li>


                {{-- Gaji & Absensi --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fas fa-money-bill-wave"></i>
                    </span>
                    <h4 class="text-section">Gaji & Absensi</h4>
                </li>
                <li class="nav-item {{ request()->is('gaji-karyawan*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#gajiKaryawan" class="collapsed" aria-expanded="false">
                        <i class="fas fa-money-check-alt"></i>
                        <p>Gaji Karyawan</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('gaji-karyawan*') ? 'show' : '' }}" id="gajiKaryawan">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('gaji-karyawan') ? 'active' : '' }}">
                                <a href="{{ url('/gaji-karyawan') }}">
                                    <span class="sub-item">Input Gaji</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('gaji-karyawan/rekap') ? 'active' : '' }}">
                                <a href="{{ url('/gaji-karyawan/rekap') }}">
                                    <span class="sub-item">Rekap Gaji</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('gaji-karyawan/potongan') ? 'active' : '' }}">
                                <a href="{{ url('/gaji-karyawan/potongan') }}">
                                    <span class="sub-item">Potongan</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('gaji-karyawan/tunjangan') ? 'active' : '' }}">
                                <a href="{{ url('/gaji-karyawan/tunjangan') }}">
                                    <span class="sub-item">Tunjangan</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li class="nav-item {{ request()->is('absensi*') ? 'active' : '' }}">
                    <a data-bs-toggle="collapse" href="#absensiMenu" class="collapsed" aria-expanded="false">
                        <i class="fas fa-user-check"></i>
                        <p>Absensi</p>
                        <span class="caret"></span>
                    </a>
                    <div class="collapse {{ request()->is('absensi*') ? 'show' : '' }}" id="absensiMenu">
                        <ul class="nav nav-collapse">
                            <li class="{{ request()->is('absensi') ? 'active' : '' }}">
                                <a href="{{ url('/absensi') }}">
                                    <span class="sub-item">Input Absensi</span>
                                </a>
                            </li>
                            <li class="{{ request()->is('absensi/rekap') ? 'active' : '' }}">
                                <a href="{{ url('/absensi/rekap') }}">
                                    <span class="sub-item">Rekap Absensi</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>

                {{-- Laporan --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fas fa-chart-line"></i>
                    </span>
                    <h4 class="text-section">Laporan</h4>
                </li>

                <li class="nav-item {{ request()->is('laporan/harian') ? 'active' : '' }}">
                    <a href="{{ url('/laporan/harian') }}">
                        <i class="fas fa-file-invoice"></i>
                        <p>Laporan Harian</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('laporan/bulanan') ? 'active' : '' }}">
                    <a href="{{ url('/laporan/bulanan') }}">
                        <i class="fas fa-file-invoice"></i>
                        <p>Laporan Bulanan</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('laporan/tahunan') ? 'active' : '' }}">
                    <a href="{{ url('/laporan/tahunan') }}">
                        <i class="fas fa-file-invoice"></i>
                        <p>Laporan Tahunan</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('laporan/pph') ? 'active' : '' }}">
                    <a href="{{ url('/laporan/pph') }}">
                        <i class="fas fa-file-invoice"></i>
                        <p>Laporan PPH</p>
                    </a>
                </li>

                <li class="nav-item {{ request()->is('perbandingan/bulanan') ? 'active' : '' }}">
                    <a href="{{ url('/perbandingan/bulanan') }}">
                        <i class="fas fa-file-invoice"></i>
                        <p>Perbandingan Bulanan</p>
                    </a>
                </li>

                {{-- Manajemen User --}}
                <li class="nav-section">
                    <span class="sidebar-mini-icon">
                        <i class="fas fa-user-cog"></i>
                    </span>
                    <h4 class="text-section">Manajemen</h4>
                </li>
                <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                    <a href="{{ url('/users') }}">
                        <i class="fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('karyawan*') ? 'active' : '' }}">
                    <a href="{{ url('/karyawan') }}">
                        <i class="fas fa-user-tie"></i>
                        <p>Karyawan</p>
                    </a>
                </li>
                <li class="nav-item {{ request()->is('jabatan*') ? 'active' : '' }}">
                    <a href="{{ url('/jabatan') }}">
                        <i class="fas fa-briefcase"></i>
                        <p>Jabatan</p>
                    </a>
                </li>

            </ul>
        </div>
    </div>

</div>
