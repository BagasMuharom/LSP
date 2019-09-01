@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Detail Sertifikat')

@push('css')
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
@endpush

@section('content')

@card(['id' => 'root'])
    @slot('title', 'Detail Sertifikat')
    
    @can('update', $sertifikat)
        @slot('action')
        <button class="btn text-primary" @click="editMode = !editMode"><i class="fa fa-pencil-alt"></i> @{{ editMode ? 'Batalkan Edit' : 'Edit Data' }}</button>
        @endslot
    @endcan

    <div class="form-group row">
        <label class="col-lg-3">Nama Pemilik</label>
        <div class="col-lg-9">
            @{{ sertifikat.nama_pemegang }}
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3">Skema</label>
        <div class="col-lg-9">
            @{{ skema.nama }}
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3"><i>Issue Date</i></label>
        <div class="col-lg-9">
            <span v-if="!editMode">@{{ issueDate }}</span>
            <input type="text" class="form-control" v-model="sertifikat.issue_date" v-show="editMode" id="issue-date">

            <p class="alert alert-danger mt-3 mb-0" v-if="errors.mulai_berlaku != undefined">
                @{{ errors.mulai_berlaku[0] }}
            </p>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3">Masa Berlaku</label>
        <div class="col-lg-9">
            <span v-if="!editMode">@{{ masa_berlaku }} tahun</span>
            <input type="text" class="form-control" v-model="masa_berlaku" v-if="editMode">
            
            <p class="alert alert-danger mt-3 mb-0" v-if="errors.masa_berlaku != undefined">
                @{{ errors.masa_berlaku[0] }}
            </p>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3"><i>Expire Date</i></label>
        <div class="col-lg-9">
            @{{ expireDate }}
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3">Tanggal Cetak</label>
        <div class="col-lg-9">
            <span v-if="!editMode">@{{ tanggalCetak }}</span>
            <input type="text" class="form-control" v-model="sertifikat.tanggal_cetak" v-show="editMode" id="tanggal-cetak">

            <p class="alert alert-danger mt-3 mb-0" v-if="errors.tanggal_cetak != undefined">
                @{{ errors.tanggal_cetak[0] }}
            </p>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3">No. Urut Cetak</label>
        <div class="col-lg-9">
            <span v-if="!editMode">@{{ sertifikat.no_urut_cetak }}</span>
            <input type="text" class="form-control" v-model="sertifikat.no_urut_cetak" v-show="editMode">

            <p class="alert alert-danger mt-3 mb-0" v-if="errors.no_urut_cetak != undefined">
                @{{ errors.no_urut_cetak[0] }}
            </p>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3">No. Urut Skema</label>
        <div class="col-lg-9">
            <span v-if="!editMode">@{{ sertifikat.no_urut_skema }}</span>
            <input type="text" class="form-control" v-model="sertifikat.no_urut_skema" v-show="editMode">

            <p class="alert alert-danger mt-3 mb-0" v-if="errors.no_urut_skema != undefined">
                @{{ errors.no_urut_skema[0] }}
            </p>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3">Tahun</label>
        <div class="col-lg-9">
            <span v-if="!editMode">@{{ sertifikat.tahun }}</span>
            <input type="text" class="form-control" v-model="sertifikat.tahun" v-show="editMode">

            <p class="alert alert-danger mt-3 mb-0" v-if="errors.tahun != undefined">
                @{{ errors.tahun[0] }}
            </p>
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3">Prodi</label>
        <div class="col-lg-9">
            @if (!is_null($sertifikat->getUji(false)))
            @{{ prodi.nama }}
            @endif
        </div>
    </div>
   
    <div class="form-group row">
        <label class="col-lg-3">Jurusan</label>
        <div class="col-lg-9">
            @if (!is_null($sertifikat->getUji(false)))
            @{{ jurusan.nama }}
            @endif
        </div>
    </div>
    
    <div class="form-group row">
        <label class="col-lg-3">Fakultas</label>
        <div class="col-lg-9">
            @if (!is_null($sertifikat->getUji(false)))
            @{{ fakultas.nama }}
            @endif
        </div>
    </div>

    <div class="form-group row" v-show="editMode">
        <label class="col-lg-3">Berkas Scan Sertifikat</label>
        <div class="col-lg-9">
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
    
    <div class="form-group row" v-if="editMode">
        <label class="col-lg-3"></label>
        <div class="col-lg-9">
            <button class="btn btn-primary" @click="simpan">Simpan</button>
        </div>
    </div>

@endcard

@endsection

@push('js')
    <script>
        new Vue({
            el: '#root',
            data: {
                url: {
                    edit: '{{ route('sertifikat.edit', ['sertifikat' => encrypt($sertifikat->id)]) }}'
                },
                sertifikat: @json($sertifikat),
                @if (!is_null($sertifikat->getUji(false)))
                pemilik: @json($sertifikat->getMahasiswa(false)),
                prodi: @json($sertifikat->getMahasiswa(false)->getProdi(false)),
                jurusan: @json($sertifikat->getMahasiswa(false)->getJurusan(false)),
                fakultas: @json($sertifikat->getMahasiswa(false)->getFakultas(false)),
                @endif
                skema: @json($sertifikat->getSkema(false)),
                editMode: false,
                dateConfig: {
                    weekday: 'long',
                    year: 'numeric',
                    month: 'long',
                    day: 'numeric'
                },
                errors: {},
                masa_berlaku: null
            },

            mounted: function () {
                var expire = new Date(this.sertifikat.expire_date)
                var issue = new Date(this.sertifikat.issue_date)
                this.masa_berlaku = expire.getFullYear() - issue.getFullYear()
            },

            methods: {
                @can('update', $sertifikat)
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

                        formData.append('issue_date', that.sertifikat.issue_date)
                        formData.append('masa_berlaku', that.masa_berlaku)
                        formData.append('no_urut_cetak', that.sertifikat.no_urut_cetak)
                        formData.append('no_urut_skema', that.sertifikat.no_urut_skema)
                        formData.append('tanggal_cetak', that.sertifikat.tanggal_cetak)
                        formData.append('tahun', that.sertifikat.tahun)

                        if ('object' === typeof that.sertifikat.berkas)
                            formData.append('berkas', that.sertifikat.berkas)

                        axios.post(that.url.edit, formData, {
                            headers: {
                                'Content-Type': 'multipart/form-data'
                            }
                        }).then(function (response) {
                            if (response.data.success) {
                                swal({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.data.message 
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
                @endcan

                pilihBerkas: function ($event) {
                    this.sertifikat.berkas = $event.target.files[0]
                }
            },

            computed: {
                expireDate: function () {
                    var d = new Date(this.sertifikat.issue_date);
                    var year = d.getFullYear();
                    var month = d.getMonth();
                    var day = d.getDate();
                    var c = new Date(year + Number(this.masa_berlaku), month, day)  

                    return c.toLocaleString('id-ID', this.dateConfig)  
                },

                issueDate: function () {
                    var d = new Date(this.sertifikat.issue_date); 
                    return d.toLocaleString('id-ID', this.dateConfig) 
                },

                tanggalCetak: function () {
                    return new Date(this.sertifikat.tanggal_cetak).toLocaleString('id-ID', this.dateConfig)
                }
            },

            watch: {
                editMode: function () {
                    if (!this.editMode) {
                        $('#issue-date').next().remove()
                        $('#tanggal-cetak').next().remove()
                        return
                    }
                        
                    let that = this

                    let config = {
                        defaultDate: that.sertifikat.issue_date,
                        altInput: true,
                        altFormat: 'l, d F Y',
                        locale: 'id'
                    }

                    flatpickr(document.getElementById('issue-date'), config);
                    flatpickr(document.getElementById('tanggal-cetak'), config);
                }
            }
        })
    </script>
@endpush