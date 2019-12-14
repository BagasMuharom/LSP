@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Penilaian | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')
    @php
    $kompeten = GlobalAuth::user()->getUjiAsAsesor()->filterByStatus(9)->count();
    $belum_kompeten = GlobalAuth::user()->getUjiAsAsesor()->filterByStatus(10)->count();
    $total = $kompeten + $belum_kompeten;
    $persen_kompeten = number_format($kompeten / $total * 100, 2);
    $persen_belum_kompeten = number_format($belum_kompeten / $total * 100, 2);
    @endphp

    @row
    @col(['size' => 3])
        <div class="card p-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="h4 d-block font-weight-normal mb-2">{{ GlobalAuth::user()->getUjiAsAsesor()->count() }}</span>
                    <span class="font-weight-light">Jumlah Total Pengujian</span>
                </div>

                <div class="h2 text-muted">
                    <i class="icon icon-people"></i>
                </div>
            </div>
        </div>
    @endcol

    @col(['size' => 3])
        <div class="card p-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="h4 d-block font-weight-normal mb-2">{{ GlobalAuth::user()->getJumlahHariUji() }}</span>
                    <span class="font-weight-light">Jumlah Pengujian (Hari)</span>
                </div>

                <div class="h2 text-muted">
                    <i class="icon icon-calendar"></i>
                </div>
            </div>
        </div>
    @endcol
    
    @col(['size' => 3])
        <div class="card p-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="h4 d-block font-weight-normal mb-2">{{ $kompeten }} ({{ $persen_kompeten }} %)</span>
                    <span class="font-weight-light">Jumlah Lulus Uji</span>
                </div>

                <div class="h2 text-muted">
                    <i class="icon icon-graph"></i>
                </div>
            </div>
        </div>
    @endcol

    @col(['size' => 3])
        <div class="card p-3">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="h4 d-block font-weight-normal mb-2">{{ $belum_kompeten }} ({{ $persen_belum_kompeten }} %)</span>
                    <span class="font-weight-light">Jumlah Tidak Lulus Uji</span>
                </div>

                <div class="h2 text-muted">
                    <i class="icon icon-graph"></i>
                </div>
            </div>
        </div>
    @endcol
    @endrow

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
                    <input type="hidden" name="event" v-model="filter.event.id">
                    <div class="dropdown dropdown-suggest">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                            <span class="choosed">@{{ namaEvent }}</span>
                        </button>
                        <div class="dropdown-menu">
                            <input type="text" class="form-control" v-model="input.keyword_event"
                                   @keyup="ubahOpsiDaftarEvent">
                            <div style="max-height: 150px;overflow-y:scroll;">
                                <a href="#" :key="event.id" v-for="event in daftarEvent" class="dropdown-item"
                                   @click.prevent="ubahOpsiEvent($event, event)">@{{ event.nama }}</a>
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
                    <td>{{ $uji->getMahasiswa(false)->nama }}</td>
                    <td>{{ $uji->getSkema(false)->nama }}</td>
                    <td>
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

                                @can('isiFRAI02', $uji)
                                    <a href="{{ route('uji.isi.fr_ai_02', ['uji' => encrypt($uji->id)]) }}" class="dropdown-item">
                                        Isi Uji Observasi
                                    </a>
                                @endcan
                                
                                @can('penilaian', $uji)
                                <a href="{{ route('penilaian.fr-ai-04', ['uji' => encrypt($uji->id)]) }}"
                                   class="dropdown-item">FR.AI.04 CEKLIS EVALUASI PORTOFOLIO</a>
                                @endcan
                                
                                @can('penilaian', $uji)
                                <a href="{{ route('penilaian.fr-ai-05', ['uji' => encrypt($uji->id)]) }}"
                                   class="dropdown-item">FR.AI.05 Formulir bukti pihak ketiga</a>
                                @endcan
                            </div>
                        </div>

                        @can('konfirmasiPenilaian', $uji)
                            <a class="btn btn-success btn-sm text-white"
                               onclick="konfirmasi('{{ route('penilaian.konfirmasi', ['uji' => encrypt($uji->id)]) }}')">Konfirmasi
                                Penilaian</a>
                        @endcan

                        <a href="{{ route('uji.detail', ['uji' => encrypt($uji->id)]) }}"
                           class="btn btn-warning btn-sm">Detail Uji</a>
                    </td>
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
                    daftar_event: '{{ route('event.daftar') }}',
                },
                filter: {
                    event: {!! request()->has('event') && request('event') != -1 ? App\Models\Event::with(['getSkema', 'getDana'])->find((int) request('event')) : '{id: -1, nama: "Semua Event"}' !!}
                },
                input: {
                    keyword_event: ''
                },
                daftarEvent: [{id: -1, nama: 'Semua Event'}]
            },
            methods: {
                ubahOpsiDaftarEvent: function (e) {
                    let that = this

                    axios.post(this.url.daftar_event, {
                        keyword: that.input.keyword_event
                    }).then(function (response) {
                        if (response.data.length > 0) {
                            that.daftarEvent = response.data
                        }
                    }).catch(function (error) {

                    })
                },
                ubahOpsiEvent: function (e, event) {
                    this.filter.event = event
                }
            },

            computed: {
                namaEvent: function () {
                    var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' }

                    if (this.filter.event.nama == 'Semua Event') {
                        return 'Semua Event'
                    }

                    return this.filter.event.get_skema.nama + ' (' + this.filter.event.get_dana.nama + ') ' + (new Date(Date.parse(this.filter.event.tgl_uji))).toLocaleDateString('id-ID', options)
                }
            }
        })
    </script>
@endpush