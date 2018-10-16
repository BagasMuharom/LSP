@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' > Jenis | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    @row

    @col(['size' => 8])
    <div class="card">
        <div class="card-header bg-light">
            Terdapat {{ $data->total() }} jenis skema
        </div>
        <div class="card-body">
            @foreach($data as $jenis)
                <form action="{{ route('skema.jenis.update') }}" method="post">
                    @csrf
                    {{ method_field('patch') }}
                    <input type="hidden" name="id" value="{{ encrypt($jenis->id) }}">
                    @row
                    @col(['size' => 9])
                    <input type="text" name="nama" value="{{ $jenis->nama }}" class="form-control" required>
                    @endcol
                    @col(['size' => 3])
                    <div class="btn-group">
                        <button class="btn btn-success">Simpan</button>
                        <button type="button" class="btn btn-danger" onclick="event.preventDefault();hapus('{{ encrypt($jenis->id) }}', '{{ $jenis->nama }}')">Hapus</button>
                    </div>
                    @endcol
                    @endrow
                    <hr>
                </form>
            @endforeach
            {{ $data->links() }}
        </div>
    </div>
    <form action="{{ route('skema.jenis.delete') }}" method="post" id="hapus">
        @csrf
        {{ method_field('delete') }}
        <input type="hidden" name="id" id="id-delete">
    </form>
    @endcol

    @col(['size' => 4])
    @card(['title' => 'Tambah jenis skema'])
    @alert(['type' => 'info'])
    Pisahkan dengan enter untuk menambahkan banyak jenis skema
    @endalert
    <form action="{{ route('skema.jenis.add') }}" method="post">
        @csrf
        {{ method_field('put') }}
        <textarea class="form-control" name="nama" rows="5"></textarea>
        <br>
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard
    @endcol

    @endrow
@endsection

@push('js')
    <script>
        function hapus(id, nama) {
            swal({
                title: "Anda yakin ingin menghapus jenis " + nama + "?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((choice) => {
                if (choice) {
                    swal('Sedang memuat. . .',{
                        buttons:false ,
                        closeOnClickOutside: false
                    })
                    $('#id-delete').val(id)
                    $('#hapus').submit()
                }
            })
        }
    </script>
@endpush