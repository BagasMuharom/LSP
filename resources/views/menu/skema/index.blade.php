@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    <div class="btn-group">
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                {{ $j }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach($daftarjenis as $jenis)
                    <form action="{{ url()->current() }}">
                        <input type="hidden" name="q" value="{{ $q }}">
                        <input type="hidden" name="j" value="{{ $jenis->nama }}">
                        <a class="dropdown-item" href=""
                           onclick="event.preventDefault();$(this).parent().submit()">{{ $jenis->nama }}</a>
                    </form>
                @endforeach
            </div>
        </div>
        <div class="dropdown">
            <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                {{ $jrs }}
            </button>
            <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                @foreach($daftarjurusan as $jurusan)
                    <form action="{{ url()->current() }}">
                        <input type="hidden" name="q" value="{{ $q }}">
                        <input type="hidden" name="j" value="{{ $j }}">
                        <input type="hidden" name="jrs" value="{{ $jurusan->nama }}">
                        <a class="dropdown-item" href=""
                           onclick="event.preventDefault();$(this).parent().submit()">{{ $jurusan->getFakultas(false)->nama }} | {{ $jurusan->nama }}</a>
                    </form>
                @endforeach
            </div>
        </div>
        <a class="btn btn-success" href="{{ route('skema.tambah') }}">Tambah Skema</a>
        <a class="btn btn-info" href="{{ route('skema.jenis') }}">Lihat Jenis Skema</a>
    </div>
    @card
    @slot('title', 'Daftar skema')
    @alert(['type' => 'info'])
    Terdapat {{ $data->total() }} skema sesuai filter
    @endalert

    <form action="{{ url()->current() }}">
        <input type="hidden" name="j" value="{{ $j }}">
        <div class="input-group">
            <input type="text" id="input-group-2" name="q" class="form-control"
                   placeholder="Cari berdasarkan kode atau judul" value="{{ $q }}">
            <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </span>
        </div>
    </form>
    
    @slot('table')
    <table class="table table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Judul</th>
            <th>Jenis</th>
            <th>Jurusan</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $skema)
            <tr>
                <th>
                    {{ ($data->currentpage() * $data->perpage()) + (++$no) - $data->perpage()  }}
                </th>
                <th>{{ $skema->kode }}</th>
                <th>{{ $skema->nama }}</th>
                <th>{!! $skema->hasJenis() ? $skema->getJenis(false)->nama : '<span class="badge badge-warning">Belum memiliki jenis</span>' !!}</th>
                <th>
                    {{ $skema->getJurusan(false)->nama }}
                    <br>
                    <span class="badge badge-{{ $skema->lintas ? 'primary' : 'secondary' }}">{{ $skema->lintas ? 'Lintas Jurusan' : 'Bukan Lintas Jurusan' }}</span>
                </th>
                <th>
                    @if(!$skema->trashed())
                        <div class="btn-group">
                            <a class="btn btn-warning btn-sm text-white"
                               href="{{ route('skema.detail', ['id' =>  $es = encrypt($skema->id)]) }}">Edit/Detail</a>
                            <button class="btn btn-info btn-sm" onclick="event.preventDefault(); $(this).parent().parent().parent().next().toggle()">Persyaratan</button>
                            <a class="btn btn-danger btn-sm text-white"
                               onclick="hapus('{{ $es }}', '{{ $skema->nama }}')">Hapus</a>
                        </div>
                    @else
                        <form action="{{ route('skema.restore') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $es = encrypt($skema->id) }}">
                            <button type="submit" class="btn btn-success btn-sm">Kembalikan Data</button>
                        </form>
                    @endif
                </th>
            </tr>
            <tr style="display: none">
                <th colspan="6">
                    <form action="{{ route('skema.syarat.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $es }}">
                        <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Nama Persyaratan</th>
                                <th>Perlu unggah berkas</th>
                                <th>Aksi</th>
                            </tr>
                            </thead>
                            <tbody id="syarat-{{ $skema->id }}">
                            @foreach($skema->getSyarat(false) as $syarat)
                            <tr>
                                <th>
                                    <input type="text" name="syarat[{{ $syarat->id }}]" class="form-control" value="{{ $syarat->nama }}" required>
                                </th>
                                <th>
                                    <input type="checkbox" name="upload[{{ $syarat->id }}]" {{ $syarat->upload ? 'checked' : '' }}> Perlu unggah berkas/file
                                </th>
                                <th>
                                    <button class="btn btn-danger btn-sm" onclick="event.preventDefault(); $(this).parent().parent().remove()">Hapus</button>
                                </th>
                            </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <div class="btn-group">
                            <button type="submit" class="btn btn-success btn-sm">Simpan</button>
                            <button type="button" class="btn btn-info btn-sm" onclick="event.preventDefault(); tambah('#syarat-{{ $skema->id }}')">Tambah</button>
                        </div>
                        </div>
                    </form>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
    @endslot
    @endcard

    <form id="hapus" action="{{ route('skema.delete') }}" method="post">
        @csrf
        {{ method_field('delete') }}
        <input type="hidden" name="id" id="id-delete">
    </form>
@endsection

@push('js')
    <script>
        function hapus(id, nama) {
            event.preventDefault()
            swal({
                title: "Anda yakin ingin menghapus " + nama + "?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((choice) => {
                if (choice) {
                    swal('Sedang memuat. . .', {
                        buttons: false,
                        closeOnClickOutside: false
                    })
                    $('#id-delete').val(id)
                    $('#hapus').submit()
                }
            })
        }

        function tambah(id) {
            var count = $(id).find('tr.baru').length

            $(id).append('' +
                '<tr class="baru">\n' +
                '                                <th>\n' +
                '                                    <input type="text" name="namabaru[' + count + ']" class="form-control" required></th>' +
                '<th><input type="checkbox" name="uploadbaru[' + count + ']"> Perlu unggah berkas/file' +
                '                                </th>\n' +
                '                                <th>\n' +
                '                                    <button class="btn btn-danger btn-sm" onclick="event.preventDefault(); $(this).parent().parent().remove()">Hapus</button>\n' +
                '                                </th>\n' +
                '                            </tr>' +
                '');
        }
    </script>
@endpush