@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Dashboard | '.kustomisasi('nama'))

@section('content')
    @row
        @col(['size' => 9])
            @if(GlobalAuth::getAttemptedGuard() == 'mhs')
                @include('dashboard.pendaftaran')
            @else
                @row
                    @includeWhen(GlobalAuth::user()->hasMenu(App\Models\Menu::where('route', 'user')->first()), 'dashboard.user')
                    @includeWhen(GlobalAuth::user()->hasMenu(App\Models\Menu::where('route', 'uji')->first()), 'dashboard.uji')
                    @includeWhen(GlobalAuth::user()->hasMenu(App\Models\Menu::where('route', 'asesor')->first()), 'dashboard.asesor')
                    @includeWhen(GlobalAuth::user()->hasMenu(App\Models\Menu::where('route', 'mahasiswa')->first()), 'dashboard.mahasiswa')
                    @includeWhen(GlobalAuth::user()->hasMenu(App\Models\Menu::where('route', 'skema')->first()), 'dashboard.skema')
                    @includeWhen(GlobalAuth::user()->hasRole(App\Models\Role::ASESOR), 'dashboard.penilaian')
                @endrow
            @endif
        @endcol

        @col(['size' => 3])
            <h5>Pengumuman</h5>

            <p class="alert alert-info">
                @if(empty(\App\Models\Kustomisasi::where('key', 'pengumuman')->first()->value))
                    Tidak ada pengumuman.
                @else
                    {!! \App\Models\Kustomisasi::where('key', 'pengumuman')->first()->value !!}
                @endif
            </p>
        @endcol
    @endrow
@endsection