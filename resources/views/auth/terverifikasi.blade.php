@extends('layouts.carbon.app', [
    'sidebar' => false
])

@section('title', 'Verifikasi Akun | LSP Unesa')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border border-top-0 border-left-0 border-right-0">
                    Verifikasi Akun
                </div>

                <div class="card-body">
                    @alert(['type' => 'success'])
                    Akun <strong>{{ $mahasiswa->email }}</strong> telah berhasil terverifikasi. {{ !GlobalAuth::check() ? 'Silahkan login untuk melanjutkan.' : ''}}
                    @endalert

                    @if(!GlobalAuth::check())
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                    @endif
                    
                    @if(GlobalAuth::check())
                    <a href="{{ route('dashboard') }}" class="btn btn-primary">Ke Halaman Dasbor Saya</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection