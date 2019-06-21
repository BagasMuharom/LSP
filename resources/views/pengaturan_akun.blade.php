@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Pengaturan Akun | '.kustomisasi('nama'))

@push('css')
<style>
    .custom-file-label::after {
        display: none;
    }
</style>
@endpush

@section('content')

@row
    @col(['size' => 6])
        @if(GlobalAuth::getAttemptedGuard() == 'mhs')
        @card
        @slot('title', 'Persyaratan Wajib')

        @if(session()->has('message'))
            @alert(['type' => 'warning'])
                {{ session('message') }}
            @endalert
        @endif

        @alert(['type' => 'info'])
            Persyaratan berikut digunakan ketika anda melakukan pendaftaran sertifikasi, sehingga tidak perlu mengunggah file yang sama setiap kali mendaftar, sehingga pastikan persyaratan berikut sesuai dan diubah setiap terdapat perubahan.
        @endalert
        
        @alert(['type' => 'warning'])
            Pastikan ukuran file tidak lebih dari 1MB.
        @endalert
        <form action="{{ route('mahasiswa.unggah.syarat') }}" method="post" enctype="multipart/form-data">
            @csrf

            <label>KTP (File jpg/png/gif)</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-primary btn-pilih-berkas" type="button">Pilih Berkas</button>
                </div>
                <div class="custom-file">
                    <input class="custom-file-input" type="file" name="ktp">
                    @if(is_null(GlobalAuth::user()->dir_ktp))
                    <label class="custom-file-label">Anda belum mengunggah berkas</label>
                    @else
                    <label class="custom-file-label">Anda telah mengunggah ktp</label>
                    @endif
                </div>
                @if(!is_null(GlobalAuth::user()->dir_ktp))
                <div class="input-group-append">
                    <a class="btn btn-primary" href="{{ route('lihat.syarat', ['jenis' => 'ktp', 'mahasiswa' => encrypt(GLobalAuth::user()->nim)]) }}">Lihat KTP</a>
                </div>
                @endif
            </div>

            @if($errors->has('ktp'))
                @alert(['type' => 'danger'])
                    {{ $errors->first('ktp') }}
                @endalert
            @endif
            
            <label>Foto (File jpg/png/gif)</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-primary btn-pilih-berkas" type="button">Pilih Berkas</button>
                </div>
                <div class="custom-file">
                    <input class="custom-file-input" type="file" name="foto">
                    @if(is_null(GlobalAuth::user()->dir_foto))
                    <label class="custom-file-label">Anda belum mengunggah foto</label>
                    @else
                    <label class="custom-file-label">Anda telah mengunggah foto</label>
                    @endif
                </div>
                @if(!is_null(GlobalAuth::user()->dir_foto))
                <div class="input-group-append">
                    <a class="btn btn-primary" href="{{ route('lihat.syarat', ['jenis' => 'foto', 'mahasiswa' => encrypt(GLobalAuth::user()->nim)]) }}">Lihat Foto</a>
                </div>
                @endif
            </div>

            @if($errors->has('foto'))
                @alert(['type' => 'danger'])
                    {{ $errors->first('foto') }}
                @endalert
            @endif
            
            <label>Transkrip (File pdf)</label>
            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-primary btn-pilih-berkas" type="button">Pilih Berkas</button>
                </div>
                <div class="custom-file">
                    <input class="custom-file-input" type="file" name="transkrip">
                    @if(is_null(GlobalAuth::user()->dir_transkrip))
                    <label class="custom-file-label">Anda belum mengunggah transkrip</label>
                    @else
                    <label class="custom-file-label">Anda telah mengunggah transkrip</label>
                    @endif
                </div>
                @if(!is_null(GlobalAuth::user()->dir_transkrip))
                <div class="input-group-append">
                    <a class="btn btn-primary" href="{{ route('lihat.syarat', ['jenis' => 'transkrip', 'mahasiswa' => encrypt(GLobalAuth::user()->nim)]) }}">Lihat Transkrip</a>
                </div>
                @endif
            </div>

            @if($errors->has('transkrip'))
                @alert(['type' => 'danger'])
                    {{ $errors->first('transkrip') }}
                @endalert
            @endif

            <button type="submit" class="btn btn-primary">Unggah</button>
        </form>
        @endcard
        @endif

        @card
        @slot('title', 'Pengaturan Akun')

        <form action="{{ route('pengaturan.akun') }}" method="post">

            @csrf

            @if(GlobalAuth::getAttemptedGuard() == 'user')
                @formgroup            
                    <label>MET</label>
                    <input type="text" class="form-control" value="{{ GlobalAuth::user()->nip }}" disabled>
                @endformgroup
            @endif
            
            @if(GlobalAuth::getAttemptedGuard() == 'mhs')
                @formgroup            
                    <label>NIM</label>
                    <input type="text" class="form-control" value="{{ GlobalAuth::user()->nim }}" disabled>
                @endformgroup
                
                @formgroup            
                    <label>NIK</label>
                    <input type="text" class="form-control" value="{{ GlobalAuth::user()->nik }}" disabled>
                @endformgroup
                
                @formgroup            
                    <label>Alamat</label>
                    <input type="text" class="form-control" value="{{ GlobalAuth::user()->alamat }}">
                @endformgroup
               
                @formgroup            
                    <label>No. telepon</label>
                    <input type="text" class="form-control" value="{{ GlobalAuth::user()->no_telepon }}">
                @endformgroup
            @endif
            
            @formgroup(['name' => 'nama'])      
                <label>Nama</label>
                <input @if(GlobalAuth::getAttemptedGuard() == 'mhs') name="nama" @endif type="text" class="form-control" value="{{ GlobalAuth::user()->nama }}" {{ GlobalAuth::getAttemptedGuard() == 'mhs' ? 'disabled' : '' }}>
            @endformgroup
            
            @if(GlobalAuth::getAttemptedGuard() == 'mhs')
                @formgroup          
                    <label>Program Studi</label>
                    <input type="text" class="form-control" value="{{ GlobalAuth::user()->getProdi(false)->nama }}" disabled>
                @endformgroup
            @endif
            
            @formgroup(['name' => 'email'])
                <label>Alamat E-mail</label>
                <input type="text" class="form-control" value="{{ GlobalAuth::user()->email }}" name="email">
            @endformgroup

            <button class="btn btn-primary">Simpan</button>

        </form>

        @endcard
    @endcol
    
    @col(['size' => 6])
        @card
        @slot('title', 'Ubah Kata Sandi')
            <form action="{{ route('ubah.kata.sandi') }}" method="POST">
                @csrf
                @formgroup(['name' => 'passlama'])
                    <label>Kata sandi lama</label>
                    <input type="password" class="form-control" name="passlama">
                @endformgroup

                @formgroup(['name' => 'passbaru'])
                    <label>Kata sandi baru</label>
                    <input type="password" class="form-control" name="passbaru">
                @endformgroup

                @formgroup
                    <label>Konfirmasi kata sandi baru</label>
                    <input type="password" class="form-control" name="passbaru_confirmation">
                @endformgroup
                <button class="btn btn-primary">Ubah Kata Sandi</button>
            </form>
        @endcard
    @endcol
@endrow
@endsection