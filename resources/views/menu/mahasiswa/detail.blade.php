@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $mahasiswa->nama)

@push('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endpush

@section('content')

@include('layouts.include.alert')

@row
    @col(['size' => 9])
        @card(['id' => 'root'])
            @slot('title', 'Detail ' . $mahasiswa->nama)

            @slot('action')
            <button class="btn text-primary" @click="editMode = !editMode"><i class="fa fa-pencil-alt"></i> @{{ editMode ? 'Batalkan Edit' : 'Edit Data' }}</button>
            @endslot

            @row
                @col(['size' => 12])
                    @formgroup(['row' => true])
                        <label class="col-lg-3">Nama</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.nama }}</p>
                            <input v-show="editMode" type="text" name="nama" class="form-control" v-model="mahasiswa.nama">
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.nama">
                                @{{ errors.nama[0] }}
                            </p>
                        </div>

                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">NIM</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.nim }}</p>
                            <input v-show="editMode" type="text" name="nim" class="form-control" v-model="mahasiswa.nim" disabled>
                        </div>
                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">NIK</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.nik }}</p>
                            <input v-show="editMode" type="text" name="nik" class="form-control" v-model="mahasiswa.nik">
                        </div>
                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">E-mail</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.email }}</p>
                            <input v-show="editMode" type="email" name="email" class="form-control" v-model="mahasiswa.email">
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.email">
                                @{{ errors.email[0] }}
                            </p>
                        </div>
                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">Alamat</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.alamat }}</p>
                            <input v-show="editMode" type="text" name="alamat" class="form-control" v-model="mahasiswa.alamat">
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.alamat">
                                @{{ errors.alamat[0] }}
                            </p>
                        </div>
                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">Kabupaten</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.kabupaten }}</p>
                            <input v-show="editMode" type="text" name="kabupaten" class="form-control" v-model="mahasiswa.kabupaten">
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.kabupaten">
                                @{{ errors.kabupaten[0] }}
                            </p>
                        </div>
                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">Provinsi</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.provinsi }}</p>
                            <input v-show="editMode" type="text" name="provinsi" class="form-control" v-model="mahasiswa.provinsi">
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.provinsi">
                                @{{ errors.provinsi[0] }}
                            </p>
                        </div>
                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">Pendidikan</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.pendidikan }}</p>
                            <input v-show="editMode" type="text" name="pendidikan" class="form-control" v-model="mahasiswa.pendidikan">
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.pendidikan">
                                @{{ errors.pendidikan[0] }}
                            </p>
                        </div>
                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">Pekerjaan</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.pekerjaan }}</p>
                            <input v-show="editMode" type="text" name="pekerjaan" class="form-control" v-model="mahasiswa.pekerjaan">
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.pekerjaan">
                                @{{ errors.pekerjaan[0] }}
                            </p>
                        </div>
                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">No. telepon</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.no_telepon }}</p>
                            <input v-show="editMode" type="text" name="no_telepon" class="form-control" v-model="mahasiswa.no_telepon">
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.no_telepon">
                                @{{ errors.alamat[0] }}
                            </p>
                        </div>
                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">Tempat lahir</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.tempat_lahir }}</p>
                            <input v-show="editMode" type="text" name="tempat_lahir" class="form-control" v-model="mahasiswa.tempat_lahir">
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.tempat_lahir">
                                @{{ errors.tempat_lahir[0] }}
                            </p>
                        </div>
                    @endformgroup
                    
                    @formgroup(['row' => true])
                        <label class="col-lg-3">Tanggal lahir</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ mahasiswa.tgl_lahir }}</p>
                            <input v-show="editMode" type="text" name="tgl_lahir" class="form-control" v-model="mahasiswa.tgl_lahir">
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.tgl_lahir">
                                @{{ errors.tgl_lahir[0] }}
                            </p>
                        </div>
                    @endformgroup

                    @formgroup(['row' => true])
                        <label class="col-lg-3">Fakultas</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ input.fakultas.nama }}</p>
                            <select name="fakultas" id="fakultas" class="custom-select" v-model="input.fakultas.id" @change="ubahDaftarJurusan" v-show="editMode">
                                <option value="-1">Pilih Fakultas</option>
                                <option :value="fakultas.id" v-for="fakultas in daftarFakultas" :key="fakultas.id">@{{ fakultas.nama }}</option>
                            </select>
                        </div>
                    @endformgroup

                    @formgroup(['row' => true])
                        <label class="col-lg-3">Jurusan</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ input.jurusan.nama }}</p>
                            <select name="jurusan" id="jurusan" class="custom-select" v-model="input.jurusan.id" @change="ubahDaftarProdi" v-show="editMode">
                                <option value="-1">Pilih Jurusan</option>
                                <option :value="jurusan.id" v-for="jurusan in daftarJurusan" :key="jurusan.id">@{{ jurusan.nama }}</option>
                            </select>
                        </div>
                    @endformgroup

                    @formgroup(['row' => true])
                        <label class="col-lg-3">Prodi</label>
                        <div class="col-lg-9">
                            <p v-show="!editMode">@{{ input.prodi.nama }}</p>
                            <select name="prodi" id="prodi" class="custom-select" v-model="input.prodi.id" v-show="editMode">
                                <option value="-1">Pilih Prodi</option>
                                <option :value="prodi.id" v-for="prodi in daftarProdi" :key="prodi.id">@{{ prodi.nama }}</option>
                            </select>
                            <p class="alert alert-danger mt-3" v-if="undefined !== errors.prodi">
                                @{{ errors.prodi[0] }}
                            </p>
                        </div>
                    @endformgroup
                    
                    <div class="form-group row" v-show="editMode">
                        <label class="col-lg-3"></label>
                        <div class="col-lg-9">
                            <button class="btn btn-primary" v-show="!sedangMenyimpan" @click="simpan">Simpan</button>
                            <button class="btn btn-primary" v-show="sedangMenyimpan" disabled>Sedang menyimpan ...</button>
                        </div>
                    </div>
                @endcol
            @endrow
        @endcard

        @card(['id' => 'reset'])
            @slot('title', 'Reset Kata Sandi')

            <div class="form-group row">
                <label class="col-lg-3">Kata sandi baru</label>
                <div class="col-lg-9">
                    <div class="input-group">
                        <input type="password" class="form-control" placeholder="Kata sandi ..." v-model="password">
                        <div class="input-group-append" v-if="generatedRandom">
                            <span class="input-group-text">@{{ generated }}</span>
                        </div>
                        <div class="input-group-append">
                            <button class="btn btn-primary" @click="generate">Generate</button>
                        </div>
                    </div>

                    <p class="alert alert-danger mt-3 mb-0" v-if="undefined !== errors.password">
                        @{{ errors.password[0] }}
                    </p>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-3">Konfirmasi kata sandi baru</label>
                <div class="col-lg-9">
                    <div class="input-group mb-3">
                        <input type="password" class="form-control" placeholder="Konfimasi kata sandi ..." v-model="konfirmasi">
                    </div>
                    <p class="alert alert-danger" v-show="konfirmasi !== password && konfirmasi !== '' && password !== ''">
                        Kata sandi tidak sama
                    </p>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-3"></label>
                <div class="col-lg-9">
                    <button class="btn btn-warning" @click="reset" v-if="!sedangMereset">Ubah kata sandi</button>
                    <button class="btn btn-warning" v-if="sedangMereset" disabled>Sedang mengubah kata sandi</button>
                </div>
            </div>
        @endcard

        @card(['id' => 'event'])
            @slot('title', 'Sertifikasi Mandiri')
            <b>Sertifikasi mandiri yang dibuka untuk mahasiswa ini : </b>
            <ul class="list-group mt-3">
                @foreach($daftarMandiriEvent as $event)
                <li class="list-group-item">
                    {{ $event->getSkema(false)->nama }}
                    <form action="{{ route('event.hapus.mahasiswa.mandiri', ['event' => encrypt($event->id), 'mahasiswa' => encrypt($mahasiswa->nim)]) }}" method="post" style="float: right">
                        @csrf
                        <button @click.prevent="hapus" class="btn btn-danger btn-sm">Hapus</button>
                    </form>
                </li>
                @endforeach
            </ul>

            <form ref="formTambah" action="{{ route('event.tambah.mahasiswa.mandiri', ['mahasiswa' => encrypt($mahasiswa->nim)]) }}" method="post" class="mt-3">
                @csrf
                @formgroup
                <label><b>Pilih event mandiri yang akan dibuka untuk mahasiswa ini</b></label>
                <select name="event" class="custom-select mt-3">
                    @foreach ($daftarEventMandiri as $event)
                    <option value="{{ encrypt($event->id) }}">{{ $event->getSkema(false)->nama }}</option>
                    @endforeach
                </select>
                @endformgroup

                <button type="submit" class="btn btn-primary" @click.prevent="tambah">Simpan</button>
            </form>
        @endcard
    @endcol

    @col(['size' => 3])
        <div class="card p-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="h4 d-block font-weight-normal mb-2">{{ $mahasiswa->getSertifikat()->count() }}</span>
                    <span class="font-weight-light">Total Sertifikat</span>
                    <a href="{{ route('mahasiswa.sertifikat', ['mahasiswa' => encrypt($mahasiswa->nim)]) }}" class="btn btn-primary btn-sm mt-3">Lihat daftar sertifikat</a>
                </div>

                <div class="h2 text-muted">
                    <i class="icon icon-doc"></i>
                </div>
            </div>
        </div>
        
        <div class="card p-2">
            <div class="card-body d-flex justify-content-between align-items-center">
                <div>
                    <span class="h4 d-block font-weight-normal mb-2">{{ $mahasiswa->getUji()->count() }}</span>
                    <span class="font-weight-light">Total Sertifikasi</span>
                    <a href="{{ route('mahasiswa.uji', ['mahasiswa' => encrypt($mahasiswa->nim)]) }}" class="btn btn-primary btn-sm mt-3">Lihat daftar sertifikasi</a>
                </div>

                <div class="h2 text-muted">
                    <i class="icon icon-note"></i>
                </div>
            </div>
        </div>
    @endcol
@endrow
@endsection

@push('js')
<script>
    new Vue({
        el: '#root',
        data: {
            url: {
                daftarJurusan: '{{ route('fakultas.daftar.jurusan', ['fakultas' => '']) }}',
                daftarProdi: '{{ route('jurusan.daftar.prodi', ['jurusan' => '']) }}',
                edit: '{{ route('mahasiswa.edit', ['mahasiswa' => encrypt($mahasiswa->nim)]) }}'
            },
            mahasiswa: @json($mahasiswa),
            daftarFakultas: @json($daftarFakultas),
            daftarJurusan: @json($daftarJurusan),
            daftarProdi: @json($daftarProdi),
            input: {
                fakultas: @json($fakultas),
                jurusan: @json($jurusan),
                prodi: @json($prodi)
            },
            errors: {},
            editMode: false,
            sedangMenyimpan: false
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
            },

            simpan: function () {
                let that = this
                this.errors = {}
                this.sedangMenyimpan = true

                axios.post(this.url.edit, {
                    nama: that.mahasiswa.nama,
                    email: that.mahasiswa.email,
                    prodi: that.input.prodi.id,
                    nik: that.mahasiswa.nik,
                    pekerjaan: that.mahasiswa.pekerjaan,
                    pendidikan: that.mahasiswa.pendidikan,
                    kabupaten: that.mahasiswa.kabupaten,
                    provinsi: that.mahasiswa.provinsi,
                    '_method': 'put'
                }).then(function (response) {
                    that.sedangMenyimpan = false

                    if (response.data.success) {
                        swal({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.data.message
                        })
                    }
                }).catch(function (error) {
                    that.sedangMenyimpan = false

                    if (error.response) {
                        switch (error.response.status) {
                            case 422:
                                that.errors = error.response.data.errors
                                break
                        }
                    }
                })
            }
            
        },

        watch: {
            editMode: function () {
                if (!this.editMode) {
                    $('input[name="tgl_lahir"]').next().remove()
                    return
                }

                var that = this

                flatpickr(document.getElementsByName('tgl_lahir'), {
                    defaultDate: that.mahasiswa.tgl_lahir,
                    altInput: true,
                    altFormat: 'l, d F Y',
                    locale: 'id'
                })
            }
        }
    })

    new Vue({
        el: '#reset',
        data: {
            url: {
                reset: '{{ route('mahasiswa.reset.katasandi', ['mahasiswa' => encrypt($mahasiswa->nim)]) }}'
            },
            generatedRandom: false,
            generated: null,
            password: '',
            konfirmasi: '',
            sedangMereset: false,
            errors: {}
        },
        methods: {
            generate: function () {
                this.generated = this.random(8)
                this.password = this.generated
                this.konfirmasi = this.generated
                this.generatedRandom = true
            },
            reset: function () {
                let that = this
                this.sedangMereset = true

                axios.post(this.url.reset, {
                    password: that.password,
                    password_confirmation: that.konfirmasi
                }).then(function (response) {
                    if (response.data.success) {
                        swal({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.data.message,
                        })

                        that.password = ''
                        that.konfirmasi = ''
                        that.sedangMereset = false
                    }
                }).catch(function (error) {
                    that.sedangMereset = false

                    if (error.response) {
                        switch (error.response.status) {
                            case 422:
                                that.errors = error.response.data.errors
                                break
                        }
                    }
                })
            },

            random: function(max) {
                str = ''
                
                for (var i = 1; i <= max; i++)
                    str += Math.ceil(Math.random() * Math.floor(9));
                
                return str
            }
        },
        watch: {
            
        }
    })

    new Vue({
        el: '#event',
        data: {

        },
        
        methods: {
            tambah: function () {
                var that = this

                swal({
                    icon: 'warning',
                    title: 'Apa anda yakin ?',
                    buttons: {
                        confirm: 'Yakin',
                        cancel: 'Batal'
                    }
                }).then(function (confirm) {
                    if (!confirm)
                        return

                    that.$refs['formTambah'].submit()
                })
            },

            hapus: function (e) {
                var that = this

                swal({
                    icon: 'warning',
                    title: 'Apa anda yakin ?',
                    buttons: {
                        confirm: 'Yakin',
                        cancel: 'Batal'
                    }
                }).then(function (confirm) {
                    if (!confirm)
                        return

                    e.target.parentNode.submit()
                })
            }
        }
    })
</script>
@endpush