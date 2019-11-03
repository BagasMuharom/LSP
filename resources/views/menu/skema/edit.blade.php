@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' > Edit | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    <form action="{{ route('skema.update') }}" method="post">
        @csrf
        {{ method_field('patch') }}
        <input type="hidden" name="id" value="{{ encrypt($skema->id) }}">
        @card(['title' => 'Edit Skema'])
        @row

        @col(['size' => 4])
        @card(['title' => 'Data skema'])

        @formgroup
        <label>Kode</label>
        <input type="text" name="kode" class="form-control" value="{{ $skema->kode }}" required>
        @endformgroup
        <hr>

        @formgroup
        <label>Judul</label>
        <input type="text" name="nama" class="form-control" value="{{ $skema->nama }}" required>
        @endformgroup
        
        @formgroup
        <label>Judul (dalam bahasa inggris)</label>
        <input type="text" name="nama_english" class="form-control" value="{{ $skema->nama_english }}" required>
        @endformgroup
        <hr>

        @formgroup
        <label>Sektor</label>
        <textarea name="sektor" class="form-control" required>{{ $skema->sektor }}</textarea>
        @endformgroup
        <hr>

        @formgroup
        <label>Jenis</label>
        <select name="jenis_id" class="form-control select" required>
            @if($skema->hasJenis())
                <option value="{{ $skema->jenis_id }}">{{ $skema->getJenis(false)->nama }}</option>
                @foreach($daftarjenis as $jenis)
                    @if($jenis->id != $skema->jenis_id)
                        <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                    @endif
                @endforeach
            @else
                @foreach($daftarjenis as $jenis)
                    <option value="{{ $jenis->id }}">{{ $jenis->nama }}</option>
                @endforeach
            @endif
        </select>
        @endformgroup
        <hr>

        @row
        @col(['size' => 6])
        @formgroup
        <label>KBLI</label>
        <input type="number" name="kbli" class="form-control" value="{{ $skema->kbli }}" required>
        @endformgroup
        @formgroup
        <label>Level KKNI</label>
        <input type="number" name="level_kkni" class="form-control" value="{{ $skema->level_kkni }}" required>
        @endformgroup
        @endcol

        @col(['size' => 6])
        @formgroup
        <label>KBJI</label>
        <input type="number" name="kbji" class="form-control" value="{{ $skema->kbji }}" required>
        @endformgroup
        @formgroup
        <label>Kode Unit SKKNI</label>
        <input type="text" name="kode_unit_skkni" class="form-control" value="{{ $skema->kode_unit_skkni }}" required>
        @endformgroup
        @endcol
        @endrow
        @formgroup
        <label>Kualifikasi</label>
        <input type="text" name="kualifikasi" class="form-control" value="{{ $skema->kualifikasi }}" required>
        @endformgroup
        @formgroup
        <label>Kualifikasi (dalam bahasa inggris)</label>
        <input type="text" name="qualification" class="form-control" value="{{ $skema->qualification }}" required>
        @endformgroup
        <hr>

        @formgroup
        <label>Bidang</label>
        <input type="text" name="bidang" class="form-control" value="{{ $skema->bidang }}" required>
        @endformgroup

        @formgroup
        <label>Field (bidang dalam bahasa inggris)</label>
        <input type="text" name="field" class="form-control" value="{{ $skema->field }}" required>
        @endformgroup
        <hr>

        @formgroup
        <label>Biaya Registrasi</label>
        <div class="input-group mb-3">
            <div class="input-group-prepend">
                <span class="input-group-text">Rp</span>
            </div>
            <input type="number" name="harga" class="form-control" value="{{ $skema->harga }}" required>
        </div>
        @endformgroup
        <hr>

        @formgroup
        <label>Jurusan</label>
        <select name="jurusan_id" class="form-control select" required>
            <option value="{{ $skema->jurusan_id }}">{{ $skema->getJurusan(false)->nama }} (Fakultas {{ $skema->getJurusan(false)->getFakultas(false)->nama }})</option>
            @foreach($daftarjurusan as $jurusan)
                @if($jurusan->id != $skema->jurusan_id)
                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama }} (Fakultas {{ $jurusan->getFakultas(false)->nama }})</option>
                @endif
            @endforeach
        </select>
        @endformgroup
        <hr>

        <div class="toggle-switch" data-ts-color="primary">
            <label for="ts2" class="ts-label">Lintas jurusan</label>
            <input id="ts2" type="checkbox" name="lintas" hidden="hidden" {{ $skema->lintas ? 'checked' : '' }}>
            <label for="ts2" class="ts-helper"></label>
        </div>
        <hr>

        @formgroup
        <label>Keterangan</label>
        <textarea name="keterangan" class="form-control" rows="5">{{ $skema->keterangan }}</textarea>
        @endformgroup

        @endcard
        @endcol

        @col(['size' => 8])
        @card(['title' => 'Tempat uji'])
        @row
        @col(['size' => 4])
        @formgroup
        <label>Kode</label>
        <input class="form-control" name="tempat_uji_kode" value="{{ $skema->hasTempatUji() ? $skema->getTempatUji(false)->kode : '' }}" required>
        <input type="hidden" name="tempat_uji_id" value="{{ $skema->hasTempatUji() ? $skema->getTempatUji(false)->id : '' }}">
        @endformgroup
        @endcol

        @col(['size' => 8])
        @formgroup
        <label>Nama Ruangan</label>
        <input class="form-control" name="tempat_uji_nama" value="{{ $skema->hasTempatUji() ? $skema->getTempatUji(false)->nama : '' }}" required>
        @endformgroup
        @endcol
        @endrow

        @formgroup
        <label>Jurusan</label>
        <br>
        <select name="tempat_uji_jurusan_id" class="form-control select" required>
            @if($skema->hasTempatUji())
                <option value="{{ $skema->getTempatUji(false)->jurusan_id }}">{{ $skema->getTempatUji(false)->getJurusan(false)->nama }} (Fakultas {{ $skema->getTempatUji(false)->getJurusan(false)->getFakultas(false)->nama }})</option>
                @foreach($daftarjurusan as $jurusan)
                    @if($skema->getTempatUji(false)->jurusan_id != $jurusan->id)
                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama }} (Fakultas {{ $jurusan->getFakultas(false)->nama }})</option>
                    @endif
                @endforeach
            @else
                @foreach($daftarjurusan as $jurusan)
                    <option value="{{ $jurusan->id }}">{{ $jurusan->nama }} (Fakultas {{ $jurusan->getFakultas(false)->nama }})</option>
                @endforeach
            @endif
        </select>
        <br><br>
        <label>Admin TUK</label>
        <br>
        @if($admintuk->count() > 0)
            <select name="tempat_uji_user_id" class="select">
                <option></option>
                @foreach($admintuk as $user)
                    <option value="{{ $user->id }}" {{ ($user->id == $skema->getTempatUji(false)->user_id) ? 'selected' : '' }}>{{ $user->nama }}</option>
                @endforeach
            </select>
        @else
            <div class="alert alert-warning">
                Belum ada admin TUK
            </div>
        @endif
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
            @foreach($skema->getSkemaUnit()->orderBy('kode')->get() as $unit)
            <tr>
                <th><input class="form-control" type="text" name="kodeunit[]" value="{{ $unit->kode }}" required></th>
                <th><input class="form-control" type="text" name="namaunit[]" value="{{ $unit->nama }}" required></th>
                <th>
                    <div class="btn-group">
                        <a href="{{ route('unit', ['q' => $unit->kode]) }}" class="btn btn-info btn-sm" target="_blank">Detail</a>
                        <button class="btn btn-danger btn-sm" onclick="$(this).parent().parent().parent().remove()">Hapus</button>
                    </div>
                </th>
            </tr>
            @endforeach
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