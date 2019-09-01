@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Terbitkan Sertifikat')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endpush

@section('content')

@card(['id' => 'root'])
    @slot('title', 'Terbitkan Sertifikat')

    @row
    @col(['size' => 6])
        <div class="form-group row">
            <label class="col-lg-4 text-right">Nama Pemilik</label>
            <div class="col-lg-8">
                @{{ pemilik.nama }}
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-4 text-right">Skema</label>
            <div class="col-lg-8">
                @{{ skema.nama }}
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-4 text-right"><i>Issue Date</i></label>
            <div class="col-lg-8">
                <input type="text" class="form-control" id="issue-date" ref="issue-date" v-model="sertifikat.mulai_berlaku">

                <p class="alert alert-danger mt-3 mb-0" v-if="errors.mulai_berlaku != undefined">
                    @{{ errors.mulai_berlaku[0] }}
                </p>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-4 text-right">Masa Berlaku</label>
            <div class="col-lg-8">
                <input type="text" class="form-control" v-model="sertifikat.masa_berlaku">
                
                <p class="alert alert-danger mt-3 mb-0" v-if="errors.masa_berlaku != undefined">
                    @{{ errors.masa_berlaku[0] }}
                </p>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-4 text-right"><i>Expire Date</i></label>
            <div class="col-lg-8">
                @{{ expireDate }}
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-4 text-right">Prodi</label>
            <div class="col-lg-8">
                @{{ prodi.nama }}
            </div>
        </div>
    
        <div class="form-group row">
            <label class="col-lg-4 text-right">Jurusan</label>
            <div class="col-lg-8">
                @{{ jurusan.nama }}
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-4 text-right">Fakultas</label>
            <div class="col-lg-8">
                @{{ fakultas.nama }}
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-4"></label>
            <div class="col-lg-8">
                <button class="btn btn-success btn-lg" @click="simpan">Simpan</button>
            </div>
        </div>
    @endcol

    @col(['size' => 6])
        
        <div class="form-group row">
            <label class="col-lg-4 text-right">No. urut cetak</label>
            <div class="col-lg-8">
                <input type="text" name="no_urut_cetak" id="no_urut_cetak" v-model="sertifikat.no_urut_cetak" class="form-control">

                <p class="alert alert-danger mt-3 mb-0" v-if="errors.no_urut_cetak != undefined">
                    @{{ errors.no_urut_cetak[0] }}
                </p>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-4 text-right">No. urut skema</label>
            <div class="col-lg-8">
                <input type="text" name="no_urut_skema" id="no_urut_skema" v-model="sertifikat.no_urut_skema" class="form-control">

                <p class="alert alert-danger mt-3 mb-0" v-if="errors.no_urut_skema != undefined">
                    @{{ errors.no_urut_skema[0] }}
                </p>
            </div>
        </div>
       
        <div class="form-group row">
            <label class="col-lg-4 text-right">Tahun</label>
            <div class="col-lg-8">
                <input type="text" name="tahun" id="tahun" v-model="sertifikat.tahun" class="form-control">

                <p class="alert alert-danger mt-3 mb-0" v-if="errors.tahun != undefined">
                    @{{ errors.tahun[0] }}
                </p>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-4 text-right">Tanggal cetak</label>
            <div class="col-lg-8">
                <input type="text" name="tanggal_cetak" id="tanggal_cetak" v-model="sertifikat.tanggal_cetak" class="form-control" ref="tanggal-cetak">

                <p class="alert alert-danger mt-3 mb-0" v-if="errors.tanggal_cetak != undefined">
                    @{{ errors.tanggal_cetak[0] }}
                </p>
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-4 text-right">Berkas Scan Sertifikat</label>
            <div class="col-lg-8">
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary btn-pilih-berkas" type="button">Pilih Berkas</button>
                    </div>
                    <div class="custom-file">
                        <input class="custom-file-input" type="file" @change="pilihBerkas($event)" name="berkas">
                        <label class="custom-file-label">Anda belum memilih berkas</label>
                    </div>
                </div>

                <p class="alert alert-danger mt-3 mb-0" v-if="errors.berkas != undefined">
                    @{{ errors.berkas[0] }}
                </p>
            </div>
        </div>
        @endcol
    @endrow

@endcard

@endsection

@push('js')
    <script>
        let a = new Vue({
            el: '#root',
            data: {
                url: {
                    tambah: '{{ route('sertifikat.tambah', ['uji' => encrypt($uji->id)]) }}'
                },
                sertifikat: {
                    nomor: null,
                    mulai_berlaku: null,
                    masa_berlaku: 3,
                    no_urut_cetak: null,
                    no_urut_skema: null,
                    tahun: null,
                    tgl_cetak: null,
                    berkas: null
                },
                pemilik: @json($uji->getMahasiswa(false)),
                prodi: @json($uji->getMahasiswa(false)->getProdi(false)),
                jurusan: @json($uji->getMahasiswa(false)->getJurusan(false)),
                fakultas: @json($uji->getMahasiswa(false)->getFakultas(false)),
                skema: @json($uji->getSkema(false)),
                dateConfig: {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                },
                errors: {}
            },

            mounted() {
                let that = this

                // Mengatur konfigurasi untuk flatpickr
                let config = {
                    defaultDate: new Date(),
                    altInput: true,
                    altFormat: 'l, d F Y',
                    locale: 'id',
                    dateFormat: 'Y-m-d'
                }
                
                // Inisialisasi objek dom ke dalam flatpickr
                flatpickr(this.$refs['issue-date'], config);
                flatpickr(this.$refs['tanggal-cetak'], config);

                this.sertifikat.mulai_berlaku = this.formatDate(new Date())
                this.sertifikat.tgl_cetak = this.formatDate(new Date())
            },

            methods: {
                simpan: function () {
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

                        var formData = new FormData()

                        formData.append('issue_date', that.sertifikat.mulai_berlaku)
                        formData.append('masa_berlaku', that.sertifikat.masa_berlaku)
                        formData.append('no_urut_cetak', that.sertifikat.no_urut_cetak)
                        formData.append('no_urut_skema', that.sertifikat.no_urut_skema)
                        formData.append('tanggal_cetak', that.sertifikat.tgl_cetak)
                        formData.append('tahun', that.sertifikat.tahun)
                        formData.append('berkas', that.sertifikat.berkas)
                        formData.append('_method', 'put')

                        axios.post(that.url.tambah, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(function (response) {
                            if (response.data.success) {
                                swal({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.data.message 
                                }).then(function () {
                                    window.location.replace(response.data.redirect)
                                })
                            }
                        }).catch(function (error) {
                            swal.close()
                            if (error.response) {
                                switch (error.response.status) {
                                    case 422:
                                        that.errors = error.response.data.errors
                                        break
                                }
                            }
                        })
                    })
                },

                addyear: function (date, years) {
                    var d = new Date(date);
                    var year = d.getFullYear();
                    var month = d.getMonth();
                    var day = d.getDate();
                    var c = new Date(year + Number(years), month, day)

                    return c
                },

                pilihBerkas: function ($event) {
                    this.sertifikat.berkas = $event.target.files[0]
                },

                formatDate: function (date) {
                    var day = date.getDate()
                    var month = date.getMonth() + 1
                    var year = date.getFullYear()

                    return year + '-' + month + '-' + day
                }
            },
            computed: {
                expireDate: function () {  
                    return this.addyear(this.sertifikat.mulai_berlaku, this.sertifikat.masa_berlaku).toLocaleString('id-ID', this.dateConfig)  
                },

                issueDate: function () {
                    var d = new Date(this.sertifikat.mulai_berlaku); 
                    return d.toLocaleString('id-ID', this.dateConfig) 
                }
            }
        })
    </script>
@endpush