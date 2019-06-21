<div class="sidebar">
    <nav class="sidebar-nav">
        <ul class="nav" style="padding-bottom: 50px">
            <li class="nav-title">
                ANDA LOGIN SEBAGAI
                <br>
                <b>
                @if(GlobalAuth::getAttemptedGuard() === 'user')
                    {{ arrayToString(GlobalAuth::user()->getUserRole(false)->pluck('nama')->toArray(), ', ', ' dan ') }}
                @else
                    MAHASISWA
                @endif
                </b>
            </li>

            <li class="nav-item">
                <a href="{{ route('dashboard') }}" class="nav-link {{ Route::currentRouteName() === 'dashboard' ? 'active' : '' }}">
                    <i class="icon icon-speedometer"></i> Dashboard
                </a>
            </li>
            @if(GlobalAuth::getAttemptedGuard() === 'user')
                @if(GlobalAuth::user()->hasRole(\App\Models\Role::ASESOR) && Route::has('penilaian'))
                    <li class="nav-item">
                        <a href="{{ route('penilaian') }}" class="nav-link {{ explode('.', Route::currentRouteName())[0] === 'penilaian' ? 'active' : '' }}">
                            <i class="icon-check"></i> Penilaian
                        </a>
                    </li>
                @endif
                @foreach (App\Models\Menu::orderBy('nama')->get() as $menu)
                    @if(Route::has($menu->route) && GlobalAuth::user()->hasMenu($menu))
                        <li class="nav-item">
                            <a href="{{ route($menu->route) }}" class="nav-link {{ explode('.', Route::currentRouteName())[0] === $menu->route ? 'active' : '' }}">
                                <i class="{{ $menu->icon }}"></i> {{ ucwords($menu->nama) }}
                            </a>
                        </li>
                    @endif
                @endforeach
            @endif
            
            @if(GlobalAuth::getAttemptedGuard() === 'mhs')
            <li class="nav-item">
                <a href="{{ route('sertifikasi.daftar') }}" class="nav-link {{ Route::currentRouteName() === 'sertifikasi.daftar' ? 'active' : '' }}">
                    <i class="icon icon-speedometer"></i> Pendaftaran Sertifikasi
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('sertifikasi.riwayat') }}" class="nav-link {{ Route::currentRouteName() === 'sertifikasi.riwayat' ? 'active' : '' }}">
                    <i class="icon icon-speedometer"></i> Riwayat Sertifikasi
                </a>
            </li>
            @endif

        </ul>
    </nav>
</div>