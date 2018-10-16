@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Sertifikat | LSP Unesa')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endpush

@section('content')

@card
    @slot('title', 'Daftar Sertifikat')

    {{-- Filter --}}
    @if(!isset($filter) || $filter)
    <form id="filter" action="{{ url()->current() }}" method="get">
        
        @row
            @col(['size' => 3])
                <div class="form-group">
                    <label>Pencarian</label>
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Ketik nama atau no. sertifikat" v-model="input.keyword">
                </div>
            @endcol

            @col(['size' => 9])
                @row
                    @col
                        <div class="form-group">
                            <label>Fakultas</label>
                            <select name="fakultas" id="fakultas" class="custom-select" v-model="input.fakultas.id" @change="ubahDaftarJurusan">
                                <option value="-1">Semua Fakultas</option>
                                <option :value="fakultas.id" v-for="fakultas in daftarFakultas" :key="fakultas.id">@{{ fakultas.nama }}</option>
                            </select>
                        </div>
                    @endcol
                    @col
                        <div class="form-group">
                            <label>Semua Jurusan</label>
                            <select name="jurusan" id="jurusan" class="custom-select" v-model="input.jurusan.id" @change="ubahDaftarProdi">
                                <option value="-1">Semua Jurusan</option>
                                <option :value="jurusan.id" v-for="jurusan in daftarJurusan" :key="jurusan.id">@{{ jurusan.nama }}</option>
                            </select>
                        </div>
                    @endcol
                    @col
                        <div class="form-group">
                            <label>Semua Prodi</label>
                            <select name="prodi" id="prodi" class="custom-select" v-model="input.prodi.id">
                                <option value="-1">Semua Prodi</option>
                                <option :value="prodi.id" v-for="prodi in daftarProdi" :key="prodi.id">@{{ prodi.nama }}</option>
                            </select>
                        </div>
                    @endcol
                @endrow
            @endcol
        @endrow

        @row
            @col(['size' => 8])
                @row
                    @col
                        <div class="form-group">
                            <label>Tanggal cetak</label>
                            <input ref="tgl_cetak_mulai" type="text" name="tgl_cetak_mulai" class="form-control" v-model="input.tgl_cetak_mulai">
                        </div>
                    @endcol

                    @col(['class' => 'col-auto'])
                        <div class="form-group">
                            <label style="margin-top: 2rem">Sampai</label>
                        </div>
                    @endcol

                    @col
                        <div class="form-group">
                            <label>&nbsp;</label>
                            <input ref="tgl_cetak_akhir" type="text" name="tgl_cetak_akhir" class="form-control" v-model="input.tgl_cetak_akhir">
                        </div>
                    @endcol
                @endrow
            @endcol
            @col
                <div class="form-group">
                    <label>&nbsp;</label><br>
                    <button type="submit" class="btn btn-primary">Filter</button>
                </div>
            @endcol
        @endrow

    </form>
    @endif

    <div id="tools">
    @can('importSertifikat', \App\Models\Sertifikat::class)
        <button class="btn btn-primary" @click="showForm">Impor Sertifikat</button>
    @endcan
        <button class="btn btn-primary" @click="$refs['ekspor'].submit()">Ekspor Sertifikat</button>
        <form ref="ekspor" action="{{ route('sertifikat.ekspor', request()->all()) }}" method="post">
            @csrf
        </form>
    </div>
    

    @slot('table')
        <p class="pl-3">
            Jumlah data : <b>{{ $total }}</b> 
        </p>

        <table class="table">
            <thead>
                <tr>
                    <th>Pemegang</th>
                    <th>No. Sertifikat</th>
                    <th>Issue date</th>
                    <th>Expire date</th>
                    <th>Tanggal cetak</th>
                    <th>Keterangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($daftarSertifikat as $sertifikat)
                    <tr>
                        <td>
                            {{ $sertifikat->nama_pemegang }}
                            @if(!is_null($sertifikat->getUji(false)))
                            <br>
                            <span class="badge badge-primary">{{ $sertifikat->getMahasiswa(false)->getProdi(false)->nama }}</span>
                            @endif

                            @if(is_null($sertifikat->uji_id))
                                <br>
                                <span class="badge badge-secondary"><i>Imported</i></span>
                            @endif
                        </td>
                        <td>
                            {{ $sertifikat->nomor_sertifikat }}
                            <br>
                            <span class="badge badge-success">{{ $sertifikat->getSkema(false)->nama }}</span>
                        </td>
                        <td>{{ formatDate(Carbon\Carbon::parse($sertifikat->issue_date), false, false) }}</td>
                        <td>{{ formatDate(Carbon\Carbon::parse($sertifikat->expire_date), false, false) }}</td>
                        <td>{{ formatDate(Carbon\Carbon::parse($sertifikat->tanggal_cetak), false, false) }}</td>
                        <td>
                            @if($sertifikat->hasKuesioner())
                                <span class="badge badge-success">Telah mengisi kuesioner</span>
                            @else
                                <span class="badge badge-warning">Belum mengisi kuesioner</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('sertifikat.detail', ['sertifikat' => encrypt($sertifikat->id)]) }}" class="btn btn-primary">Detail</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7">
                            <p class="alert alert-info text-center">
                                Tidak ada data.
                            </p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pl-3">
            {{ $daftarSertifikat->links() }}
        </div>
    @endslot
@endcard

@endsection

@push('js')
<script>
    new Vue({
        el: '#filter',
        data: {
            url: {
                blokir: '{{ route('mahasiswa.blokir', ['mahasiswa' => '']) }}',
                aktifkan: '{{ route('mahasiswa.aktifkan', ['mahasiswa' => '']) }}',
                daftarJurusan: '{{ route('fakultas.daftar.jurusan', ['fakultas' => '']) }}',
                daftarProdi: '{{ route('jurusan.daftar.prodi', ['jurusan' => '']) }}'
            },
            @if(!isset($filter) || $filter)
            daftarFakultas: @json($daftarFakultas),
            daftarJurusan: @json($daftarJurusan),
            daftarProdi: @json($daftarProdi),
            input: {
                status: {
                    id: {{ request()->has('status') ? request('status') : -1 }}
                },
                keyword: '{{ request()->has('keyword') ? request('keyword') : '' }}',
                fakultas: {
                    id: {{ request()->has('fakultas') ? request('fakultas') : -1 }}      
                },
                jurusan: {
                    id: {{ request()->has('jurusan') ? request('jurusan') : -1 }}  
                },
                prodi: {
                    id: {{ request()->has('prodi') ? request('prodi') : -1 }}    
                },
                tgl_cetak_mulai: '{{ request()->has('tgl_cetak_mulai') ? request()->get('tgl_cetak_mulai') : Carbon\Carbon::now()->format('Y-m-d') }}',
                tgl_cetak_akhir: '{{ request()->has('tgl_cetak_akhir') ? request()->get('tgl_cetak_akhir') : Carbon\Carbon::now()->format('Y-m-d') }}'
            }
            @endif
        },

        mounted: function () {
            var that = this

            flatpickr(this.$refs['tgl_cetak_mulai'], {
                defaultDate: that.input.tgl_cetak_mulai,
                altInput: true,
                altFormat: 'l, d F Y',
                locale: 'id'
            })
            
            flatpickr(this.$refs['tgl_cetak_akhir'], {
                defaultDate: that.input.tgl_cetak_akhir,
                altInput: true,
                altFormat: 'l, d F Y',
                locale: 'id'
            })
        },

        methods: {
            ubahDaftarJurusan: function () {
                let that = this

                if (this.input.fakultas.id == -1)
                    return

                axios.post(this.url.daftarJurusan + '/' + this.input.fakultas.id)
                    .then(function (response) {
                        if (response.data) {
                            that.daftarJurusan = response.data      
                        }
                    })
            },

            ubahDaftarProdi: function () {
                let that = this

                if (this.input.jurusan.id == -1)
                    return

                axios.post(this.url.daftarProdi + '/' + this.input.jurusan.id)
                    .then(function (response) {
                        if (response.data) {
                            that.daftarProdi = response.data      
                        }
                    })
            }
        }
    })

    new Vue({
        el: '#tools',
        data: {
            url: {
                impor: '{{ route('sertifikat.impor') }}'
            }
        },

        methods: {
            showForm: function () {
                let that = this
                let root = document.createElement('div')
                let form = document.createElement('form-impor-sertifikat')
                root.appendChild(form)

                swal({
                    closeOnClickOutside: false,
                    content: root,
                    buttons: false
                })

                new Vue({
                    el: root,
                    data: {
                        url: {
                            impor: '{{ route('sertifikat.impor') }}'
                        }
                    }
                })
            }
        }
    })
</script>
@endpush