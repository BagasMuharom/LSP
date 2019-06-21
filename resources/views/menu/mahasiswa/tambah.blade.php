@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Tambah Mahasiswa')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endpush

@section('content')
@card()
    @slot('title', 'Tambah Mahasiswa Baru')

    <div class="row">
        <div class="col-lg-10">
            <form action="{{ route('mahasiswa.tambah') }}" method="post">

                @csrf
        
                @formgroup(['name' => 'nim', 'row' => true])
                    <label class="col-lg-4 text-right">NIM</label>
                    <div class="col-lg-8">
                        <input type="text" name="nim" id="nim" class="form-control" autofocus required>
                        <b>Keterangan: </b> harus mengandung 11 digit
                    </div>
                @endformgroup
               
                @formgroup(['name' => 'nik', 'row' => true])
                    <label class="col-lg-4 text-right">NIK</label>
                    <div class="col-lg-8">
                        <input type="text" name="nik" id="nik" class="form-control" required>
                        <b>Keterangan: </b> harus mengandung 16 digit
                    </div>
                @endformgroup
        
                @formgroup(['name' => 'nama', 'row' => true])
                    <label class="col-lg-4 text-right">Nama</label>
                    <div class="col-lg-8">
                        <input type="text" name="nama" id="nama" class="form-control" required>
                    </div>
                @endformgroup
        
                @formgroup(['name' => 'email', 'row' => true])
                    <label class="col-lg-4 text-right">Email</label>
                    <div class="col-lg-8">
                        <input type="text" name="email" id="email" class="form-control" required>
                    </div>
                @endformgroup
                
                @formgroup(['name' => 'jenis_kelamn', 'row' => true])
                    <label class="col-lg-4 text-right">Jenis Kelamin</label>
                    <div class="col-lg-8">
                        <div class="custom-control custom-radio">
                            <input type="radio" id="laki_laki" value="L" name="jenis_kelamin" class="custom-control-input">
                            <label class="custom-control-label" for="laki_laki">Laki-laki</label>
                        </div>
                        
                        <div class="custom-control custom-radio">
                            <input type="radio" id="perempuan" value="P" name="jenis_kelamin" class="custom-control-input">
                            <label class="custom-control-label" for="perempuan">Perempuan</label>
                        </div>
                    </div>
                @endformgroup

                @formgroup(['name' => 'prodi_id', 'row' => true])
                    <label class="col-lg-4 text-right">Prodi</label>
                    <div class="col-lg-8" id="prodi">
                        @row
                            @col
                                <div class="form-group">
                                    <label>Fakultas</label>
                                    <select name="fakultas" id="fakultas" class="custom-select" v-model="input.fakultas.id" @change="ubahDaftarJurusan">
                                        <option value="-1">Pilih Fakultas</option>
                                        <option :value="fakultas.id" v-for="fakultas in daftarFakultas" :key="fakultas.id">@{{ fakultas.nama }}</option>
                                    </select>
                                </div>
                            @endcol
                            @col
                                <div class="form-group">
                                    <label>Jurusan</label>
                                    <select name="jurusan" id="jurusan" class="custom-select" v-model="input.jurusan.id" @change="ubahDaftarProdi">
                                        <option value="-1">Pilih Jurusan</option>
                                        <option :value="jurusan.id" v-for="jurusan in daftarJurusan" :key="jurusan.id">@{{ jurusan.nama }}</option>
                                    </select>
                                </div>
                            @endcol
                            @col
                                <div class="form-group">
                                    <label>Prodi</label>
                                    <select name="prodi_id" id="prodi" class="custom-select" v-model="input.prodi.id">
                                        <option value="-1">Pilih Prodi</option>
                                        <option :value="prodi.id" v-for="prodi in daftarProdi" :key="prodi.id">@{{ prodi.nama }}</option>
                                    </select>
                                </div>
                            @endcol
                        @endrow
                    </div>
                @endformgroup
        
                @formgroup(['name' => 'alamat', 'row' => true])
                    <label class="col-lg-4 text-right">Alamat</label>
                    <div class="col-lg-8">
                        <input type="text" name="alamat" id="alamat" class="form-control" required>
                    </div>
                @endformgroup
                
                @formgroup(['name' => 'kabupaten', 'row' => true])
                    <label class="col-lg-4 text-right">Kabupaten</label>
                    <div class="col-lg-8">
                        <input type="text" name="kabupaten" id="kabupaten" class="form-control" required>
                    </div>
                @endformgroup
                
                @formgroup(['name' => 'provinsi', 'row' => true])
                    <label class="col-lg-4 text-right">Provinsi</label>
                    <div class="col-lg-8">
                        <input type="text" name="provinsi" id="provinsi" class="form-control" required>
                    </div>
                @endformgroup
                
                @formgroup(['name' => 'pendidikan', 'row' => true])
                    <label class="col-lg-4 text-right">Pendidikan</label>
                    <div class="col-lg-8">
                        <input type="text" name="pendidikan" id="pendidikan" class="form-control" required>
                    </div>
                @endformgroup
                
                @formgroup(['name' => 'pekerjaan', 'row' => true])
                    <label class="col-lg-4 text-right">Pekerjaan</label>
                    <div class="col-lg-8">
                        <input type="text" name="pekerjaan" id="pekerjaan" class="form-control" required>
                    </div>
                @endformgroup
                
                @formgroup(['name' => 'no_telepon', 'row' => true])
                    <label class="col-lg-4 text-right">No. telepon</label>
                    <div class="col-lg-8">
                        <input type="text" name="no_telepon" id="no_telepon" class="form-control" required>
                    </div>
                @endformgroup
                
                @formgroup(['name' => 'tempat_lahir', 'row' => true])
                    <label class="col-lg-4 text-right">Tempat Lahir</label>
                    <div class="col-lg-8">
                        <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" required>
                    </div>
                @endformgroup
                
                @formgroup(['name' => 'tgl_lahir', 'row' => true])
                    <label class="col-lg-4 text-right">Tanggal Lahir</label>
                    <div class="col-lg-8">
                        <input type="text" name="tgl_lahir" id="tgl_lahir" class="form-control" required>
                    </div>
                @endformgroup
                
                @formgroup(['name' => 'password', 'row' => true])
                    <label class="col-lg-4 text-right">Kata sandi</label>
                    <div class="col-lg-8">
                        <input type="password" name="password" id="password" class="form-control" required>
                        <b>Keterangan: </b> panjang minimal 8 karakter
                    </div>
                @endformgroup
                
                @formgroup(['name' => 'password_confirmation', 'row' => true])
                    <label class="col-lg-4 text-right">Konfirmasi kata sandi</label>
                    <div class="col-lg-8">
                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                    </div>
                @endformgroup

                @formgroup(['row' => true])
                    <label class="col-lg-4 text-right"></label>
                    <div class="col-lg-8">
                        <button class="btn btn-success" type="submit">Tambah</button>
                    </div>
                @endformgroup
        
            </form>
        </div>
    </div>

@endcard
@endsection

@push('js')
<script>
    flatpickr(document.getElementById('tgl_lahir'), {
        defaultDate: new Date,
        altInput: true,
        altFormat: 'l, d F Y',
        locale: 'id'
    })

    new Vue({
        el: '#prodi',
        data: {
            url: {
                daftarJurusan: '{{ route('fakultas.daftar.jurusan', ['fakultas' => '']) }}',
                daftarProdi: '{{ route('jurusan.daftar.prodi', ['jurusan' => '']) }}'
            },
            daftarFakultas: @json(App\Models\Fakultas::all()),
            daftarJurusan: [],
            daftarProdi: [],
            input: {
                fakultas: {
                    id: -1
                },
                jurusan: {
                    id: -1
                },
                prodi: {
                    id: -1
                }
            }
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
</script>
@endpush