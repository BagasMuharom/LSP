<!-- BEGIN STYLE CUSTOMIZER -->
{{-- <div class="color-panel hidden-sm">
    <div class="color-mode-icons icon-color"></div>
    <div class="color-mode-icons icon-color-close"></div>
    <div class="color-mode">
        <p>THEME COLOR</p>
        <ul class="inline">
            <li class="color-red current color-default" data-style="red"></li>
            <li class="color-blue" data-style="blue"></li>
            <li class="color-green" data-style="green"></li>
            <li class="color-orange" data-style="orange"></li>
            <li class="color-gray" data-style="gray"></li>
            <li class="color-turquoise" data-style="turquoise"></li>
        </ul>
    </div>
</div> --}}
<!-- END BEGIN STYLE CUSTOMIZER -->

<!-- BEGIN TOP BAR -->
<div class="pre-header">
    <div class="container">
        <div class="row">
            <!-- BEGIN TOP BAR LEFT PART -->
            <div class="col-md-6 col-sm-6 additional-shop-info">
                <ul class="list-unstyled list-inline">
                    <li>
                        <i class="fa fa-phone"></i>
                        <span>{{ kustomisasi('no_telp') }}</span>
                    </li>
                    <li>
                        <i class="fa fa-envelope-o"></i>
                        <span>{{ kustomisasi('email') }}</span>
                    </li>
                </ul>
            </div>
            <!-- END TOP BAR LEFT PART -->
            <!-- BEGIN TOP BAR MENU -->
            <div class="col-md-6 col-sm-6 additional-nav">
                <ul class="list-unstyled list-inline pull-right">
                    @if(!GlobalAuth::check())
                    <li>
                        <a href="{{ route('login') }}">Masuk</a>
                    </li>
                    <li>
                        <a href="{{ route('register') }}">Daftar</a>
                    </li>
                    @else
                    <li class="dropdown" id="dropdown-header">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="small ml-1">{{ GlobalAuth::user()->nama }} <i class="fa fa-chevron-down"></i></span>
                        </a>
            
                        <div class="dropdown-menu">
                            <a href="{{ route('dashboard') }}" class="dropdown-item">
                                <i class="icon icon-settings"></i> Dasbor
                            </a>
                            <a href="{{ route('pengaturan.akun') }}" class="dropdown-item">
                                <i class="icon icon-settings"></i> Pengaturan Akun
                            </a>
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();document.getElementById('logout').submit()">
                                Keluar
                            </a>
                            <form action="{{ route('logout') }}" method="post" id="logout">
                                @csrf
                            </form>
                        </div>
                    </li>
                    @endif
                </ul>
            </div>
            <!-- END TOP BAR MENU -->
        </div>
    </div>
</div>
<!-- END TOP BAR -->
<!-- BEGIN HEADER -->
<div class="header">
    <div class="container">
        <a class="site-logo" href="{{ route('profil.home') }}">
            <img src="{{ asset(kustomisasi('logo')) }}" alt="{{ kustomisasi('nama') }}" width="30">
            {{ kustomisasi('nama') }}
        </a>

        <a href="javascript:void(0);" class="mobi-toggler">
            <i class="fa fa-bars"></i>
        </a>

        <!-- BEGIN NAVIGATION -->
        <div class="header-navigation pull-right font-transform-inherit">
            <ul>
                <li class="{{ Route::currentRouteName() == 'profil.home' ? 'active' : '' }}">
                    <a href="{{ url('/') }}">Beranda</a>
                </li>

                <li class="{{ Route::currentRouteName() == 'profil.profil' ? 'active' : '' }}">
                    <a href="{{ route('profil.profil') }}">Profil</a>
                </li>

                <li class="{{ Route::currentRouteName() == 'profil.event' ? 'active' : '' }}">
                    <a href="{{ route('profil.event') }}">Event</a>
                </li>

                <li class="{{ Route::currentRouteName() == 'profil.skema.sertifikasi' ? 'active' : '' }}">
                    <a href="{{ route('profil.skema.sertifikasi') }}">Skema Sertifikasi</a>
                </li>

                <li class="{{ Route::currentRouteName() == 'profil.pengumuman' ? 'active' : '' }}">
                    <a href="{{ route('profil.pengumuman') }}">Pengumuman</a>
                </li>

                <li class="{{ Route::currentRouteName() == 'profil.berita' ? 'active' : '' }}">
                    <a href="{{ route('profil.berita') }}">Berita</a>
                </li>

                <li class="{{ Route::currentRouteName() == 'profil.galeri' ? 'active' : '' }}">
                    <a href="{{ route('profil.galeri') }}">Galeri</a>
                </li>

                <li class="{{ Route::currentRouteName() == 'profil.kontak' ? 'active' : '' }}">
                    <a href="{{ route('profil.kontak') }}">Kontak</a>
                </li>

                <!-- BEGIN TOP SEARCH -->
                <li class="menu-search">
                    <span class="sep"></span>
                    <i class="fa fa-search search-btn"></i>
                    <div class="search-box">
                        <form action="{{ route('profil.berita') }}">
                            <div class="input-group">
                                <input type="text" name="q" placeholder="Cari sesuatu ..." class="form-control">
                                <span class="input-group-btn">
                                    <button class="btn btn-primary" type="submit">Cari</button>
                                </span>
                            </div>
                        </form>
                    </div>
                </li>
                <!-- END TOP SEARCH -->
            </ul>
        </div>
        <!-- END NAVIGATION -->
    </div>
</div>
<!-- Header END -->