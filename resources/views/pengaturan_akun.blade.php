@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Pengaturan Akun | '.kustomisasi('nama'))

@push('css')
<style>
    .custom-file-label::after {
        display: none;
    }
    .signature-pad {
        border: 1px solid #888888;
        display: block;
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
        @else
            @card
                @slot('title', 'Unggah Berkas Tambahan')

                <p class="alert alert-warning">
                Ukuran berkas maksimum 500 KB
                </p>

                <form action="{{ route('user.berkas.unggah') }}" method="post" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <label>Nama berkas</label>
                            <input type="text" name="nama" class="form-control">

                            <button class="btn btn-primary mt-3" type="submit">Unggah</button>
                        </div>
                        <div class="col-lg-6">
                            <label>Berkas</label>
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                    <button class="btn btn-outline-primary btn-pilih-berkas" type="button">Pilih Berkas</button>
                                </div>
                                <div class="custom-file">
                                    <input class="custom-file-input" type="file" name="berkas">
                                    <label class="custom-file-label">Pilih Berkas ...</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                @slot('list')
                    <b class="p-3">Daftar Berkas yang Di unggah</b>
                    <ul class="list-group">
                        @forelse($daftarBerkas as $berkas)
                            <li class="list-group-item d-flex justify-content-between">
                                <div>
                                    {{ basename($berkas) }}
                                </div>
                                <div>
                                    <form action="{{ route('user.berkas.hapus', ['user' => encrypt(GlobalAuth::user()->id)]) }}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <a target="_blank" href="{{ route('user.berkas.lihat', ['user' => encrypt(GlobalAuth::user()->id), 'filename' => encrypt(basename($berkas))]) }}" class="btn btn-primary btn-sm">Lihat</a>
                                        <input type="hidden" name="filename" value="{{ basename($berkas) }}"/>
                                        <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                                    </form>
                                </div>
                            </li>
                        @empty
                            <li class="list-group-item d-flex justify-content-between">
                            Tidak ada berkas.
                            </li>
                        @endforelse
                    </ul>
                @endslot
            @endcard
        @endif

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

@card
    
    @slot('title', 'Pengaturan Akun')

    <form action="{{ route('pengaturan.akun') }}" method="post">

        @csrf
        <div class="row">
            <div class="col-md-6">
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
                @endif

                @formgroup(['name' => 'nama'])      
                    <label>Nama</label>
                    <input @if(GlobalAuth::getAttemptedGuard() == 'mhs') name="nama" @endif type="text" class="form-control" value="{{ GlobalAuth::user()->nama }}" {{ GlobalAuth::getAttemptedGuard() == 'mhs' ? 'disabled' : '' }}>
                @endformgroup
                
                @formgroup(['name' => 'email'])
                    <label>Alamat E-mail</label>
                    <input type="text" class="form-control" value="{{ GlobalAuth::user()->email }}" name="email">
                @endformgroup
            </div>
            
            @if(GlobalAuth::getAttemptedGuard() == 'mhs')
                <div class="col-md-6">
                
                @formgroup            
                    <label>Alamat</label>
                    <input type="text" class="form-control" value="{{ GlobalAuth::user()->alamat }}">
                @endformgroup
                
                @formgroup            
                    <label>No. telepon</label>
                    <input type="text" class="form-control" value="{{ GlobalAuth::user()->no_telepon }}">
                @endformgroup
                
                @formgroup          
                    <label>Program Studi</label>
                    <input type="text" class="form-control" value="{{ GlobalAuth::user()->getProdi(false)->nama }}" disabled>
                @endformgroup
                </div>
            @endif

        </div>

        <button class="btn btn-primary">Simpan</button>

    </form>

@endcard

<h4>Tanda Tangan</h4>

@card
    @slot('title', 'Tambahkan Tanda Tangan Baru')

    <canvas width="300" height="150" id="tambah-ttd" class="signature-pad"></canvas>

    <button id="btn-tambah-ttd" class="btn btn-primary">Tambah</button>
    <button id="btn-reset-ttd" class="btn btn-primary">Reset</button>
@endcard

<div class="row">
    @foreach (GlobalAuth::user()->getTTD(false) as $ttd)
        <div class="col-md-3" id="ttd-container">
        @card
            @slot('title', 'Tanda Tangan')
            <form action="{{ route('ttd.hapus', ['id' => $ttd->id]) }}" method="post">
                @csrf
                <img style="width: 100%" src="{{ $ttd->ttd }}">
                <button type="submit" class="btn btn-outline-danger">Hapus</button>
            </form>
        @endcard
        </div>
    @endforeach
</div>

@endsection

@push('js')
<script src="{{ asset('js/signature_pad.min.js') }}"></script>
<script>
let tambah_tdd = document.getElementById('tambah-ttd')
tambah_ttd_sp = new SignaturePad(tambah_tdd, {
    backgroundColor: 'rgba(255, 255, 255, 0)',
    penColor: 'rgb(0, 0, 0)'
})

$('#btn-reset-ttd').click(function () {
    tambah_ttd_sp.clear()
})

$('#btn-tambah-ttd').click(function () {
    axios.post('{{ route('ttd.tambah') }}', {
        'ttd' : tambah_ttd_sp.toDataURL()
    }).then(function (response) {
        if (response.data.success) {
            swal({
                icon: 'success',
                title: 'Berhasil',
                text: response.data.message
            }).then(confirm => {
                window.location.reload()
            })
        }
    })
})

</script>
@endpush