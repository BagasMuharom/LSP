@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Daftar Mahasiwa | LSP Unesa')

@section('content')
    <div class="card card-body col-lg-6">
        <form action="{{ url()->current() }}">
            <div class="form-group">
                <label>NIM</label>
                <textarea class="form-control" name="nims" placeholder="Pisahkan dengan enter untuk cek banyak nim" rows="5">{{ $nims }}</textarea>
            </div>
            <input type="submit" class="btn btn-primary" value="Cek">
        </form>
    </div>
    @foreach($listmhs as $mhs)
        <div class="card card-body">
            <div class="row">
                <div class="col-lg-2 text-center">
                    <img src="https://siakadu.unesa.ac.id/photo/fotomhs/{{ $mhs->nim }}.jpg" class="img-fluid"
                         alt="Responsive image">
                </div>
                <div class="col-lg-10">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <tr>
                                <td>NIM</td>
                                <td>:</td>
                                <td>{{ $mhs->nim ?? '-' }}</td>

                                <td>Nama</td>
                                <td>:</td>
                                <td>{{ $mhs->nama_mahasiswa ?? '-' }}</td>

                                <td>Email</td>
                                <td>:</td>
                                <td>{{ $mhs->email ?? '-' }}</td>
                            </tr>
                            <tr>
                                <td>Jenis Kelamin</td>
                                <td>:</td>
                                <td>{{ (($mhs->jenis_kelamin == 'P') ? 'Perempuan' : 'Laki-laki') ?? '-' }}</td>

                                <td>Tempat/Tgl. Lahir</td>
                                <td>:</td>
                                <td>{{ $mhs->tempat_lahir ?? '-' }}
                                    / {{ formatDate(\Carbon\Carbon::parse($mhs->tgl_lahir), true, false) ?? '-' }}</td>

                                <td>PJP</td>
                                <td>:</td>
                                <td>{{ $mhs->prodi ?? '-' }}
                                    , {{ \App\Models\Prodi::findByKeyOrName('', $mhs->prodi)->getJurusan(false)->nama ?? '-' }}, Fakultas {{ $mhs->fakultas }}</td>
                            </tr>
                            <tr>
                                <td>IPK / Total SKS</td>
                                <td>:</td>
                                <td>{{ $mhs->aktivitas_kuliah->ipk ?? '-' }} / {{ $mhs->aktivitas_kuliah->sks_total ?? '-' }}</td>

                                <td>Alamat</td>
                                <td>:</td>
                                <td>{{ $mhs->jln ?? '-' }} RT {{ $mhs->rt ?? '-' }} RW {{ $mhs->rw ?? '-' }}, {{ $mhs->{'nama dusun'} ?? '-' }}
                                    , {{ $mhs->{'nama desa'} ?? '-' }}, {{ $mhs->nama_wilayah->nm_wil ?? '-' }}
                                    , {{ $mhs->nama_wilayah->nm_kab ?? '-' }}, {{ $mhs->nama_wilayah->nm_prop ?? '-' }}</td>
                                <td>Skripsi</td>
                                <td>:</td>
                                <td>Semester
                                    : {{ $mhs->n_skripsi->{array_keys(get_object_vars($mhs->n_skripsi))[0]}->smt ?? '-' }}
                                    <br> Nilai
                                    : {{ $mhs->n_skripsi->{array_keys(get_object_vars($mhs->n_skripsi))[0]}->n ?? '-' }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection