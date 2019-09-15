@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Penilaian | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    @card(['title' => 'Mahasiswa yang belum dinilai'])

    <form action="{{ url()->current() }}" id="filter">

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

            <div class="col-md-auto mt-1">
                <div class="form-group" style="position: relative">
                    <input type="hidden" name="skema" v-model="filter.skema.id">
                    <div class="dropdown dropdown-suggest">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                            <span class="choosed">@{{ filter.skema.nama }}</span>
                        </button>
                        <div class="dropdown-menu">
                            <input type="text" class="form-control" v-model="input.keyword_skema"
                                   @keyup="ubahOpsiDaftarSkema">
                            <div style="max-height: 150px;overflow-y:scroll;">
                                <a href="#" :key="skema.id" v-for="skema in daftarSkema" class="dropdown-item"
                                   @click.prevent="ubahOpsiSkema($event, skema)">@{{ skema.nama }}</a>
                            </div>
                        </div>
                    </div>
                </div>
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
                            <div class="dropdown">
                                <button class="btn btn-secondary dropdown-toggle btn-sm" type="button"
                                        id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true"
                                        aria-expanded="false">
                                    Penilaian
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    @can('penilaian', $uji)
                                        <a class="dropdown-item"
                                           href="{{ route('penilaian.nilai', ['uji' => encrypt($uji->id)]) }}">Lakukan
                                            Penilaian</a>
                                    @endcan

                                    @can('penilaianDiri', $uji)
                                        <a href="{{ route('uji.asesmendiri.asesor', ['uji' => encrypt($uji->id)]) }}"
                                           class="dropdown-item">Asesmen Diri</a>
                                    @endcan

                                    <a href="{{ route('penilaian.fr-ai-04', ['uji' => encrypt($uji->id)]) }}" class="dropdown-item">FR.AI.04 CEKLIS EVALUASI PORTOFOLIO</a>
                                </div>
                            </div>

                            @can('konfirmasiPenilaian', $uji)
                                <a class="btn btn-success btn-sm text-white"
                                   onclick="konfirmasi('{{ route('penilaian.konfirmasi', ['uji' => encrypt($uji->id)]) }}')">Konfirmasi
                                    Penilaian</a>
                            @endcan

                            <a href="{{ route('uji.detail', ['uji' => encrypt($uji->id)]) }}"
                               class="btn btn-warning btn-sm">Detail Uji</a>
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
        function konfirmasi(route) {
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

        new Vue({
            el: '#filter',
            data: {
                url: {
                    daftar_skema: '{{ route('skema.daftar') }}',
                },
                filter: {
                    skema: {!! request()->has('skema') && request('skema') != -1 ? App\Models\Skema::find((int) request('skema')) : '{id: -1, nama: "Semua Skema"}' !!}
                },
                input: {
                    keyword_skema: ''
                },
                daftarSkema: [{id: -1, nama: 'Semua Skema'}]
            },
            methods: {
                ubahOpsiDaftarSkema: function (e) {
                    let that = this

                    axios.post(this.url.daftar_skema, {
                        keyword: that.input.keyword_skema
                    }).then(function (response) {
                        if (response.data.length > 0) {
                            that.daftarSkema = response.data
                        }
                    }).catch(function (error) {

                    })
                },
                ubahOpsiSkema: function (e, skema) {
                    this.filter.skema = skema
                }
            }
        })
    </script>
@endpush