@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    <button class="btn btn-info" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false"
            aria-controls="collapseExample">Buat Galeri
    </button>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form action="{{ route('galeri.create') }}" method="post" enctype="multipart/form-data">
                @csrf
                {{ method_field('put') }}
                @formgroup
                <label>Nama</label>
                <input type="text" name="nama" class="form-control" required>
                @endformgroup

                @formgroup
                <label>Keterangan</label>
                <textarea class="form-control" name="keterangan" rows="5" required></textarea>
                @endformgroup

                @formgroup
                <label>Tambah Foto</label>
                <div class="custom-file">
                    <input name="dir[]" type="file" multiple accept="image/*" class="custom-file-input"
                           id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                    <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                </div>
                @endformgroup
                <button class="btn btn-success btn-sm">Simpan</button>
            </form>
        </div>
    </div>
    @card(['title' => 'Daftar Galeri'])
    @alert(['type' => 'info'])
    Terdapat {{ $data->total() }} galeri sesuai filter
    @endalert

    <form action="{{ url()->current() }}">
        <div class="input-group">
            <input type="text" id="input-group-2" name="q" class="form-control"
                   placeholder="Cari berdasarkan nama atau keterangan" value="{{ $q }}">
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
                <td>No</td>
                <td>Nama</td>
                <td>Keterangan</td>
                <td>Jumlah foto</td>
                <td>Aksi</td>
            </tr>
            </thead>
            <tbody>
            @foreach($data as $galeri)
                <tr>
                    <td>{{ ($data->currentpage() * $data->perpage()) + (++$no) - $data->perpage()  }}</td>
                    <td>{{ $galeri->nama }}</td>
                    <td>{{ str_limit($galeri->keterangan, 75) }}</td>
                    <td>{{ $galeri->getFoto()->count() }}</td>
                    <td>
                        <div class="btn-group">
                            <button class="btn btn-warning btn-sm"
                                    onclick="event.preventDefault(); $(this).parent().parent().parent().next().toggle()">
                                Detail/Edit
                            </button>
                            <a class="btn btn-info btn-sm text-white"
                               href="{{ route('galeri.foto', ['galeri' => $eu = encrypt($galeri->id)]) }}">Lihat Foto</a>
                            @if($galeri->nama != 'Carousel')
                                <button class="btn btn-danger btn-sm" onclick="event.preventDefault();hapus('{{ $eu }}', '{{ 'galeri '.$galeri->nama }}')">Hapus</button>
                            @endif
                        </div>
                    </td>
                </tr>
                <tr style="display: none">
                    <td colspan="5">
                        <form action="{{ route('galeri.update', ['galeri' => $eu]) }}" method="post"
                              enctype="multipart/form-data">
                            @csrf
                            {{ method_field('patch') }}
                            @if($galeri->nama != 'Carousel')
                                @formgroup
                                <label>Nama</label>
                                <input type="text" name="nama" class="form-control" value="{{ $galeri->nama }}"
                                       required>
                                @endformgroup

                                @formgroup
                                <label>Keterangan</label>
                                <textarea class="form-control" name="keterangan"
                                          required>{{ $galeri->keterangan }}</textarea>
                                @endformgroup
                            @endif

                            @formgroup
                            <label>Tambah Foto</label>
                            <div class="custom-file">
                                <input name="dir[]" type="file" multiple accept="image/*" class="custom-file-input"
                                       id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                            </div>
                            @endformgroup
                            <button class="btn btn-success btn-sm">Simpan</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $data->links() }}
    @endslot
    @endcard

    <form id="hapus" action="{{ route('galeri.delete') }}" method="post">
        @csrf
        {{ method_field('delete') }}
        <input type="hidden" name="id" id="id-delete">
    </form>
@endsection

@push('js')
    <script>
        function hapus(id, nama) {
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
    </script>
@endpush