@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Penilaian | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    @card(['title' => 'Mahasiswa yang belum dinilai'])

    <form action="{{ url()->current() }}">

        <div class="row">
            <div class="col-md-auto col-sm-12 mt-1">
                <select name="status" class="custom-select">
                    @foreach ([
                        'Dalam Proses Penilaian', 
                        'Lulus Sertifikasi',
                        'Tidak Lulus Sertifikasi',
                        'Tidak Lolos Asesmen Diri'] as $status)
                        <option value="{{ $loop->index }}" {{ request()->has('status') && request()->get('status') == $loop->index ? 'selected="selected"' : '' }}>{{ $status }}</option>
                    @endforeach

                </select>
            </div>

            <div class="col-md-auto col-sm-12 mt-1">
                <input type="text" id="input-group-2" name="q" class="form-control"
                            placeholder="Cari berdasarkan nama atau keterangan" value="{{ $q }}">
            </div>

            <div class="col-md-auto col-sm-12 mt-1">
                <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search"></i> Filter
                </button>
            </div>
        </div>
        
    </form>

    @slot('table')
        <table class="table table-hover">
            <thead>
            <tr>
                <th>NIM</th>
                <th>Nama</th>
                <th>Skema</th>
                <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @forelse($data as $uji)
                <tr>
                    <td>{{ $uji->nim }}</td>
                    <td>{{ $uji->getMahasiswa(false)->nama }}</t>
                    <td>{{ $uji->getSkema(false)->nama }}</t>
                    <td>
                        <div class="btn-group">
                            @can('penilaian', $uji)
                            <a class="btn btn-info btn-sm text-white"
                               href="{{ route('penilaian.nilai', ['uji' => encrypt($uji->id)]) }}">Lakukan Penilaian</a>
                            @endcan

                            @can('penilaianDiri', $uji)
                            <a href="{{ route('uji.asesmendiri.asesor', ['uji' => encrypt($uji->id)]) }}"
                               class="btn btn-primary btn-sm">Asesmen Diri</a>
                            @endcan

                            @can('konfirmasiPenilaian', $uji)
                                <a class="btn btn-success btn-sm text-white" onclick="konfirmasi('{{ route('penilaian.konfirmasi', ['uji' => encrypt($uji->id)]) }}')">Konfirmasi Penilaian</a>
                            @endcan

                            <a href="{{ route('uji.detail', ['uji' => encrypt($uji->id)]) }}" class="btn btn-warning btn-sm">Detail Uji</a>
                        </div>
                    </t>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="text-center">
                        <p class="alert alert-info">
                            Tidak ada data.
                        </p>
                    </td>
                </tr>
            @endforelse
            </tbody>
        </table>
        {{ $data->links() }}
    @endslot
    @endcard

    <form method="post" id="konfirmasi">
        @csrf
    </form>
@endsection

@push('js')
<script>
    function konfirmasi(route){
        event.preventDefault()
        swal({
            title: "Anda tidak dapat mengubah nilai ketika nilai dikonfirmasi. Apakah anda yakin ingin mengkonfirmasi?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
        }).then((choice) => {
            if (choice) {
                swal('Sedang memuat. . .', {
                    buttons: false,
                    closeOnClickOutside: false
                })
                $('#konfirmasi').attr('action', route)
                $('#konfirmasi').submit()
            }
        })
    }
</script>
@endpush