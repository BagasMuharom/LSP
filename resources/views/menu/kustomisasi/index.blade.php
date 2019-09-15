@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    @card(['title' => 'Pengumuman'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $pengumuman->updated_at->diffForHumans() }} oleh <b>{{ $pengumuman->getUser(false)->nama }}</b>
    @endalert
    <form action="{{ route('kustomisasi.update', ['kustomisasi' => encrypt($pengumuman->key)]) }}" method="post">
        @csrf
        @formgroup
        <textarea class="form-control tcme" rows="10" name="value">{{ $pengumuman->value }}</textarea>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard

    @row
    @col(['size' => 4])
    @card(['title' => 'Nama Aplikasi'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $nama->updated_at->diffForHumans() }} oleh <b>{{ $nama->getUser(false)->nama }}</b>
    @endalert

    <form action="{{ route('kustomisasi.update', ['kustomisasi' => encrypt($nama->key)]) }}" method="post">
        @csrf
        @formgroup
        <input class="form-control" type="text" name="value" value="{{ $nama->value }}" required>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard
    @endcol

    @col(['size' => 4])
    @card(['title' => 'No Telp'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $noTelp->updated_at->diffForHumans() }} oleh <b>{{ $noTelp->getUser(false)->nama }}</b>
    @endalert
    <form action="{{ route('kustomisasi.update', ['kustomisasi' => encrypt($noTelp->key)]) }}" method="post">
        @csrf
        @formgroup
        <input class="form-control" type="text" name="value" value="{{ $noTelp->value }}" required>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard
    @endcol

    @col(['size' => 4])
    @card(['title' => 'Email'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $email->updated_at->diffForHumans() }} oleh <b>{{ $email->getUser(false)->nama }}</b>
    @endalert
    <form action="{{ route('kustomisasi.update', ['kustomisasi' => encrypt($email->key)]) }}" method="post">
        @csrf
        @formgroup
        <input class="form-control" type="email" name="value" value="{{ $email->value }}" required>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard
    @endcol
    @endrow

    @row
    @col(['size' => 6])
    @card(['title' => 'Logo'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $logo->updated_at->diffForHumans() }} oleh <b>{{ $logo->getUser(false)->nama }}</b>
    @endalert
    <img src="{{ $logo->value }}" class="img-fluid mx-auto d-block" style="max-height: 325px; min-height: 325px">
    <br>
    <form action="{{ route('kustomisasi.update.file', ['kustomisasi' => encrypt($logo->key)]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @formgroup
        <div class="custom-file">
            <input name="value" type="file" accept="image/*" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
        </div>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard

    @card(['title' => 'Alamat'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $alamat->updated_at->diffForHumans() }} oleh <b>{{ $alamat->getUser(false)->nama }}</b>
    @endalert
    <form action="{{ route('kustomisasi.update', ['kustomisasi' => encrypt($alamat->key)]) }}" method="post">
        @csrf
        @formgroup
        <textarea class="form-control" rows="10" name="value">{{ $alamat->value }}</textarea>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard

    @card(['title' => 'Misi'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $misi->updated_at->diffForHumans() }} oleh <b>{{ $misi->getUser(false)->nama }}</b>
    @endalert
    <form action="{{ route('kustomisasi.update', ['kustomisasi' => encrypt($misi->key)]) }}" method="post">
        @csrf
        @formgroup
        <textarea class="form-control" rows="10" name="value">{{ $misi->value }}</textarea>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard
    @endcol

    @col(['size' => 6])
    @card(['title' => 'Susunan Organisasi'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $susunanOrganisasi->updated_at->diffForHumans() }} oleh <b>{{ $susunanOrganisasi->getUser(false)->nama }}</b>
    @endalert
    <img src="{{ $susunanOrganisasi->value }}" class="img-fluid mx-auto d-block" style="max-height: 325px; min-height: 325px">
    <br>
    <form action="{{ route('kustomisasi.update.file', ['kustomisasi' => encrypt($susunanOrganisasi->key)]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @formgroup
        <div class="custom-file">
            <input name="value" type="file" accept="image/*" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
        </div>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard

    @card(['title' => 'Visi'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $visi->updated_at->diffForHumans() }} oleh <b>{{ $visi->getUser(false)->nama }}</b>
    @endalert
    <form action="{{ route('kustomisasi.update', ['kustomisasi' => encrypt($visi->key)]) }}" method="post">
        @csrf
        @formgroup
        <textarea class="form-control" rows="10" name="value">{{ $visi->value }}</textarea>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard

    @card(['title' => 'Sasaran Mutu'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $sasaranMutu->updated_at->diffForHumans() }} oleh <b>{{ $sasaranMutu->getUser(false)->nama }}</b>
    @endalert
    <form action="{{ route('kustomisasi.update', ['kustomisasi' => encrypt($sasaranMutu->key)]) }}" method="post">
        @csrf
        @formgroup
        <textarea class="form-control" rows="10" name="value">{{ $sasaranMutu->value }}</textarea>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard
    @endcol
    @endrow

    @card(['title' => 'Profil'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $profil->updated_at->diffForHumans() }} oleh <b>{{ $profil->getUser(false)->nama }}</b>
    @endalert
    <form action="{{ route('kustomisasi.update', ['kustomisasi' => encrypt($profil->key)]) }}" method="post">
        @csrf
        @formgroup
        <textarea class="form-control tcme" rows="10" name="value">{{ $profil->value }}</textarea>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard

    @card(['title' => 'MAPS'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $maps->updated_at->diffForHumans() }} oleh <b>{{ $maps->getUser(false)->nama }}</b>
    @endalert
    <img src="{{ $maps->value }}" class="img-fluid mx-auto d-block" style="max-height: 325px; min-height: 325px">
    <br>
    <form action="{{ route('kustomisasi.update.file', ['kustomisasi' => encrypt($maps->key)]) }}" method="post" enctype="multipart/form-data">
        @csrf
        @formgroup
        <div class="custom-file">
            <input name="value" type="file" accept="image/*" class="custom-file-input" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
        </div>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard

    @card(['title' => 'MAPS URL'])
    @alert(['type' => 'info'])
    Terakhir diperbarui {{ $mapsUrl->updated_at->diffForHumans() }} oleh <b>{{ $mapsUrl->getUser(false)->nama }}</b>
    @endalert
    <form action="{{ route('kustomisasi.update', ['kustomisasi' => encrypt($mapsUrl->key)]) }}" method="post">
        @csrf
        @formgroup
        <textarea class="form-control" rows="3" name="value">{{ $mapsUrl->value }}</textarea>
        @endformgroup
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard
@endsection

@push('js')
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>
    <script>
        tinymce.init({
            selector: '.tcme',
            entity_encoding : "raw",
            theme: 'modern',
            plugins: [
                'autoresize'
            ],
            toolbar1: 'styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image',
        });
    </script>
@endpush