@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Daftar Mahasiwa | LSP Unesa')

@section('content')

@card(['id' => 'root'])
    @slot('title', 'Daftar Mahasiswa')

    @include('layouts.include.alert')

    {{-- Filter --}}
    <form action="{{ url()->current() }}" method="get">
    
        @row
            @col(['size' => 2])
                <div class="form-group">
                    <label>Status akun</label>
                    <select name="status" id="status" class="custom-select" v-model="input.status.id">
                        <option :value="-1">Semua</option>
                        <option :value="{{ App\Models\Mahasiswa::AKTIF }}">Aktif</option>
                        <option :value="{{ App\Models\Mahasiswa::TERBLOKIR }}">Terblokir</option>
                        <option :value="{{ App\Models\Mahasiswa::BELUM_TERVERIFIKASI }}">Belum Terverifikasi</option>
                    </select>
                </div>
            @endcol

            @col(['size' => 2])
                <div class="form-group">
                    <label>Pencarian</label>
                    <input type="text" name="keyword" id="keyword" class="form-control" placeholder="Ketik nama atau nim" v-model="input.keyword">
                </div>
            @endcol

            @col(['size' => 8])
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
        
        <button type="submit" class="btn btn-primary">Filter</button>
    </form>
    
    <div class="btn-group mt-3">
        <a href="{{ route('mahasiswa.tambah') }}" class="btn btn-primary">Tambah</a>
    </div>

    @slot('table')
        <p class="pl-3">
            Jumlah data : <b>{{ $total }}</b> 
        </p>

        <table class="table">
            <thead>
                <tr>
                    <th>NIM</th>
                    <th>Nama</th>
                    <th>Prodi</th>
                    <th>Status akun</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($daftarMahasiswa as $mahasiswa)
                    <tr>
                        <td>{{ $mahasiswa->nim }}</td>
                        <td>{{ $mahasiswa->nama }}</td>
                        <td>{{ $mahasiswa->getProdi(false)->nama }}</td>
                        <td>
                            @if($mahasiswa->terverifikasi and !$mahasiswa->terblokir)
                            <h5><span class="badge badge-success">Aktif</span></h5>
                            @elseif($mahasiswa->terblokir)
                            <h5><span class="badge badge-danger">Terblokir</span></h5>
                            @else
                            <h5><span class="badge badge-warning">Belum Terverifikasi</span></h5>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('mahasiswa.detail', ['mahasiswa' => encrypt($mahasiswa->nim)]) }}" class="btn btn-primary">Detail</a>
                                @unless($mahasiswa->terverifikasi)
                                <a href="#" class="btn btn-success" @click.prevent="verifikasi($event, '{{ encrypt($mahasiswa->nim) }}')">Verifikasi Akun</a>
                                @endunless
                                @if($mahasiswa->terblokir)
                                <a href="#" class="btn btn-success" @click.prevent="aktifkan($event, '{{ encrypt($mahasiswa->nim) }}')">Aktifkan</a>
                                @else
                                <a href="#" class="btn btn-danger" @click.prevent="blokir($event, '{{ encrypt($mahasiswa->nim) }}')">Blokir</a>
                                @endif
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="pl-3">
            {{ $daftarMahasiswa->links() }}
        </div>
    @endslot
@endcard

@endsection

@push('js')
<script>
    new Vue({
        el: '#root',
        data: {
            url: {
                blokir: '{{ route('mahasiswa.blokir', ['mahasiswa' => '']) }}',
                aktifkan: '{{ route('mahasiswa.aktifkan', ['mahasiswa' => '']) }}',
                daftarJurusan: '{{ route('fakultas.daftar.jurusan', ['fakultas' => '']) }}',
                daftarProdi: '{{ route('jurusan.daftar.prodi', ['jurusan' => '']) }}',
                verifikasi: '{{ route('mahasiswa.verifikasi.akun', ['mahasiswa' => '']) }}'
            },
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
                }
            }
        },
        methods: {
            blokir: function (e, mahasiswa) {
                let that = this

                swal({
                    icon: 'warning',
                    title: 'Apa anda yakin ?',
                    buttons: {
                        confirm: {
                            text: 'Yakin',
                            closeModal: false
                        },
                        cancel: {
                            text: 'Batal',
                            visible: true
                        }
                    }
                }).then(function (confirm) {
                    if (!confirm)
                        return

                    axios.post(that.url.blokir + '/' + mahasiswa).then(function (response) {
                        if (response.data.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.data.message
                            }).then(function () {
                                window.location.reload()
                            })
                        }
                    })
                })
            },
            
            verifikasi: function (e, mahasiswa) {
                let that = this

                swal({
                    icon: 'warning',
                    title: 'Apa anda yakin ?',
                    buttons: {
                        confirm: {
                            text: 'Yakin',
                            closeModal: false
                        },
                        cancel: {
                            text: 'Batal',
                            visible: true
                        }
                    }
                }).then(function (confirm) {
                    if (!confirm)
                        return

                    axios.post(that.url.verifikasi + '/' + mahasiswa).then(function (response) {
                        if (response.data.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.data.message
                            }).then(function () {
                                window.location.reload()
                            })
                        }
                    })
                })
            },

            aktifkan: function (e, mahasiswa) {
                let that = this

                swal({
                    icon: 'warning',
                    title: 'Apa anda yakin ?',
                    buttons: {
                        confirm: {
                            text: 'Yakin',
                            closeModal: false
                        },
                        cancel: {
                            text: 'Batal',
                            visible: true
                        }
                    }
                }).then(function (confirm) {
                    if (!confirm)
                        return

                    axios.post(that.url.aktifkan + '/' + mahasiswa).then(function (response) {
                        if (response.data.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.data.message
                            }).then(function () {
                                window.location.reload()
                            })
                        }
                    })
                })
            },

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
</script>
@endpush