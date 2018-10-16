@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' > Buat | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    <form action="{{ route('skema.add') }}" method="post">
        @csrf
        {{ method_field('put') }}
        @card(['title' => 'Tambah Skema'])
        @row

        @col(['size' => 4])
        @card(['title' => 'Data skema'])

        @formgroup
        <label>Kode</label>
        <input type="text" name="kode" class="form-control" required>
        @endformgroup
        <hr>

        @formgroup
        <label>Judul</label>
        <input type="text" name="nama" class="form-control" required>
        @endformgroup
        <hr>

        @formgroup
        <label>Sektor</label>
        <textarea name="sektor" class="form-control" required></textarea>
        @endformgroup
        <hr>

        @formgroup
        <label>Jenis</label>
        <select name="jenis_id" class="form-control select" required>
            @foreach($daftarjenis as $jenis)
                <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
            @endforeach
        </select>
        @endformgroup
        <hr>

        @row
        @col(['size' => 6])
        @formgroup
        <label>KBLI</label>
        <input type="number" name="kbli" class="form-control" required>
        @endformgroup
        @formgroup
        <label>Level KKNI</label>
        <input type="number" name="level_kkni" class="form-control" required>
        @endformgroup
        @endcol

        @col(['size' => 6])
        @formgroup
        <label>KBJI</label>
        <input type="number" name="kbji" class="form-control" required>
        @endformgroup
        @formgroup
        <label>Kode Unit SKKNI</label>
        <input type="text" name="kode_unit_skkni" class="form-control" required>
        @endformgroup
        @endcol
        @endrow
        @formgroup
        <label>Kualifikasi</label>
        <input type="text" name="kualifikasi" class="form-control" required>
        @endformgroup
        @formgroup
        <label>Kualifikasi (dalam bahasa inggris)</label>
        <input type="text" name="qualification" class="form-control" required>
        @endformgroup
        <hr>

        @formgroup
        <label>Biaya Registrasi</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
            </div>
            <input type="number" name="harga" class="form-control" value="0" min="0" required>
        </div>
        @endformgroup
        <hr>

        @formgroup
        <label>Jurusan</label>
        <select name="jurusan_id" class="form-control select" required>
            @foreach($daftarjurusan as $jurusan)
                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }} (Fakultas {{ $jurusan->getFakultas(false)->nama }})</option>
            @endforeach
        </select>
        @endformgroup
        <hr>

        <div class="toggle-switch" data-ts-color="primary">
            <label for="ts2" class="ts-label">Lintas jurusan</label>
            <input id="ts2" type="checkbox" name="lintas" hidden="hidden" checked>
            <label for="ts2" class="ts-helper"></label>
        </div>
        <hr>

        @formgroup
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="5"></textarea>
        @endformgroup

        @endcard
        @endcol

        @col(['size' => 8])

        @card(['title' => 'Tempat uji'])
        @row
        @col(['size' => 4])
        @formgroup
        <label>Kode</label>
        <input class="form-control" name="tempat_uji_kode" required>
        @endformgroup
        @endcol

        @col(['size' => 8])
        @formgroup
        <label>Nama Ruangan</label>
        <input class="form-control" name="tempat_uji_nama" required>
        @endformgroup
        @endcol
        @endrow

        @formgroup
        <label>Jurusan</label>
        <select name="tempat_uji_jurusan_id" class="form-control select" required>
            @foreach($daftarjurusan as $jurusan)
                <option value="{{ $jurusan->id }}">{{ $jurusan->nama }} (Fakultas {{ $jurusan->getFakultas(false)->nama }})</option>
            @endforeach
        </select>
        @endformgroup
        @endcard

        @card(['title' => 'Data unit'])
        @slot('table')
        <table class="table">
            <thead>
            <tr>
                <th>Kode</th>
                <th>Judul</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody id="list-unit">
            </tbody>
        </table>
        <button type="button" class="btn btn-primary" onclick="tambah()">Tambah unit</button>
        @endslot
        @endcard
        @endcol

        @endrow
        <hr>
        <button class="btn btn-success btn-lg btn-block">Simpan</button>
        @endcard
    </form>
@endsection

@push('js')
    <script>
        function tambah() {
            $('#list-unit').append('' +
                '<tr>\n' +
                '        <th><input class="form-control" type="text" name="kodeunit[]" required></th>\n' +
                '        <th><input class="form-control" type="text" name="namaunit[]" required></th>\n' +
                '        <th><button class="btn btn-danger btn-sm" onclick="$(this).parent().parent().remove()">Hapus</button></th>\n' +
                '    </tr>' +
                '');
        }

        $('.select').select2()
    </script>
@endpush