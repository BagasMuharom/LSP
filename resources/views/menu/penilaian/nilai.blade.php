@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Penilaian > Nilai | '.kustomisasi('nama'))

@push('css')
    <meta name="uji" content="{{ $uji->id }}">
    <style>
        .custom-radio .custom-control-input:checked ~ .custom-control-label:after {
            background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E");
        }

        .table thead tr:first-child th:first-child {
            width: 50%;
        }

        .table thead tr th {
            vertical-align: middle;
        }

        .table tbody td {
            font-size: 15px;
        }

        .signature-pad {
            border: 1px solid #888888;
            display: block;
            width: 300px;
            height: 150px;
        }
    </style>
@endpush

@section('content')
    <div id="root">
        <div class="card">
            <div class="card-header border border-top-0 border-left-0 border-right-0">
                Penilaian
            </div>

            <div class="card-body">
                <p class="alert alert-info">
                    Pastikan anda mengisi seluruh penilaian pada semua unit
                </p>

                <p class="alert alert-secondary">    
                    <b>Anda akan melakukan penilaian untuk : </b><br>
                    Nama : <b>{{ $uji->getMahasiswa(false)->nama }}</b><br>
                    Skema : <b>{{ $uji->getSkema(false)->nama }}</b>
                </p>

                <label>Pilih Unit</label>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        @{{ choosed.unit.nama }}
                    </button>
                    <div class="dropdown-menu">
                        <a v-for="(unit, index) in daftarUnit" :key="unit.id" :class="{'dropdown-item' : true, 'active': choosed.unit == unit}" href="#"
                           @click="choosed.unit = unit;choosed.index = index">@{{ unit.nama }} <span
                                    class="badge badge-success float-right ml-3" v-if="unit.selesai">Selesai</span></a>
                    </div>
                </div>

                <h6 class="mt-3" v-if="choosed.unit.id != -1"><b>Penilaian Unit</b></h6>
                
            </div>

            <table class="table table-bordered table-hover" v-if="choosed.unit.id != -1">
                <thead>
                    <tr>
                        <th rowspan="2">Jenis Penilaian</th>
                        <th colspan="3">Pencapaian</th>
                    </tr>
                    <tr>
                        <th>Tidak Menggunakan Tes Jenis Ini</th>
                        <th>K</th>
                        <th>BK</th>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(value, key) in nilaiUnit[choosed.unit.id]" :key="key">
                        <td>@{{ key }}</td>
                        <td>
                            <div class="custom-control custom-control-lg custom-radio">
                                <input :name="'nilai_unit' + key" v-model="nilaiUnit[choosed.unit.id][key]" type="radio" :value="null" class="custom-control-input" :id="'nilai_unit_n' + key">
                                <label class="custom-control-label" :for="'nilai_unit_n' + key"></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-control-lg custom-radio">
                                <input :name="'nilai_unit' + key" v-model="nilaiUnit[choosed.unit.id][key]" type="radio" value="K" class="custom-control-input" :id="'nilai_unit_k' + key">
                                <label class="custom-control-label" :for="'nilai_unit_k' + key"></label>
                            </div>
                        </td>
                        <td>
                            <div class="custom-control custom-control-lg custom-radio">
                                <input :name="'nilai_unit' + key" v-model="nilaiUnit[choosed.unit.id][key]" type="radio" value="BK" class="custom-control-input" :id="'nilai_unit_bk' + key">
                                <label class="custom-control-label" :for="'nilai_unit_bk' + key"></label>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>

            <div class="card-body" v-if="choosed.unit.id != -1">
                <h6 class="mt-3"><b>Penilaian Per Kriteria</b></h6>
            </div>

            <table class="table table-bordered table-hover" v-if="choosed.unit.id != -1">
                <thead class="text-center">
                <tr>
                    <th rowspan="2">Kriteria Unjuk Kerja</th>
                    {{-- <th colspan="3">Jenis Bukti</th> --}}
                    <th colspan="2">Nilai</th>
                </tr>
                <tr>
                    {{-- <th>
                        BL
                        <div class="custom-control custom-control-lg custom-radio">
                            <input type="radio" name="centangsemuabukti" class="custom-control-input" id="buktilangsung"
                                   v-model="centangSemuaUnitBukti" value="BL">
                            <label class="custom-control-label" for="buktilangsung">Centang semua</label>
                        </div>
                    </th>
                    <th>
                        BTL
                        <div class="custom-control custom-control-lg custom-radio">
                            <input type="radio" name="centangsemuabukti" class="custom-control-input"
                                   id="buktitidaklangsung" v-model="centangSemuaUnitBukti" value="BTL">
                            <label class="custom-control-label" for="buktitidaklangsung">Centang semua</label>
                        </div>
                    </th>
                    <th>
                        BT
                        <div class="custom-control custom-control-lg custom-radio">
                            <input type="radio" name="centangsemuabukti" class="custom-control-input" id="buktitambahan"
                                   v-model="centangSemuaUnitBukti" value="BT">
                            <label class="custom-control-label" for="buktitambahan">Centang semua</label>
                        </div>
                    </th> --}}
                    <th>
                        K
                        <div class="custom-control custom-control-lg custom-radio">
                            <input type="radio" name="centangsemuanilai" class="custom-control-input" id="kompeten"
                                   v-model="centangSemuaUnitNilai" value="K">
                            <label class="custom-control-label" for="kompeten">Centang semua</label>
                        </div>
                    </th>
                    <th>
                        BK
                        <div class="custom-control custom-control-lg custom-radio">
                            <input type="radio" name="centangsemuanilai" class="custom-control-input" id="belumkompeten"
                                   v-model="centangSemuaUnitNilai" value="BK">
                            <label class="custom-control-label" for="belumkompeten">Centang semua</label>
                        </div>
                    </th>
                    {{-- <th>
                        AL
                        <div class="custom-control custom-control-lg custom-radio">
                            <input type="radio" name="centangsemuanilai" class="custom-control-input" id="asesmenlanjut"
                                   v-model="centangSemuaUnitNilai" value="AL">
                            <label class="custom-control-label" for="asesmenlanjut">Centang semua</label>
                        </div>
                    </th> --}}
                </tr>
                </thead>
                <tbody>
                <template v-for="elemen in choosed.unit.get_elemen_kompetensi">
                    <tr :key="'el' + elemen.id">
                        <td colspan="7">@{{ elemen.nama }}</td>
                    </tr>
                    <template v-for="kuk in elemen.get_kriteria">
                        <tr :key="kuk.id">
                            <td>@{{ kuk.unjuk_kerja }}</td>
                            {{-- <td>
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input :name="'bukti' + kuk.id" v-model="nilai[kuk.id].bukti" type="radio"
                                           value="BL" class="custom-control-input" :id="'bl' + kuk.id"
                                           @change="ubahBukti($event, kuk.id)">
                                    <label class="custom-control-label" :for="'bl' + kuk.id"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input :name="'bukti' + kuk.id" v-model="nilai[kuk.id].bukti" type="radio"
                                           value="BTL" class="custom-control-input" :id="'btl' + kuk.id"
                                           @change="ubahBukti($event, kuk.id)">
                                    <label class="custom-control-label" :for="'btl' + kuk.id"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input :name="'bukti' + kuk.id" v-model="nilai[kuk.id].bukti" type="radio"
                                           value="BT" class="custom-control-input" :id="'bt' + kuk.id"
                                           @change="ubahBukti($event, kuk.id)">
                                    <label class="custom-control-label" :for="'bt' + kuk.id"></label>
                                </div>
                            </td> --}}
                            <td>
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input :name="'nilai' + kuk.id" v-model="nilai[kuk.id].nilai" type="radio" value="K"
                                           class="custom-control-input" :id="'k' + kuk.id"
                                           @change="ubahNilai($event, kuk.id)">
                                    <label class="custom-control-label" :for="'k' + kuk.id"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input :name="'nilai' + kuk.id" v-model="nilai[kuk.id].nilai" type="radio"
                                           value="BK" class="custom-control-input" :id="'bk' + kuk.id"
                                           @change="ubahNilai($event, kuk.id)">
                                    <label class="custom-control-label" :for="'bk' + kuk.id"></label>
                                </div>
                            </td>
                            {{-- <td>
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input :name="'nilai' + kuk.id" v-model="nilai[kuk.id].nilai" type="radio"
                                           value="AL" class="custom-control-input" :id="'al' + kuk.id"
                                           @change="ubahNilai($event, kuk.id)">
                                    <label class="custom-control-label" :for="'al' + kuk.id"></label>
                                </div>
                            </td> --}}
                        </tr>
                    </template>
                </template>
                </tbody>
            </table>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td>
                            @formgroup
                            <label>Umpan balik terhadap pencapaian unjuk kerja</label>
                            <textarea class="form-control" rows="5" disabled></textarea>
                            @endformgroup
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @formgroup
                            <label>Identifikasi kesenjangan pencapaian unjuk kerja</label>
                            <textarea class="form-control" rows="5" disabled></textarea>
                            @endformgroup
                        </td>
                    </tr>
                    <tr>
                        <td>
                            @formgroup
                            <label>Saran tindak lanjut hasil asesmen</label>
                            <textarea class="form-control" rows="5" disabled></textarea>
                            @endformgroup
                        </td>
                    </tr>
                </table>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <tr>
                        <td rowspan="2" width="60%">
                            @formgroup
                            <label>Rekomendasi Asesor</label>
                            <textarea class="form-control" v-model="rekomendasi_asesor" rows="20"></textarea>
                            @endformgroup
                        </td>
                        <td width="40%">
                            <template v-for="asesor in daftar_asesor">
                            <br>
                            <br>
                            Tanda Tangan Asesor @{{ asesor.nama }}
                            <br>
                            <canvas :id="'ttd-asesor' + asesor.id" class="signature-pad" width="300" height="150"></canvas>
                                <button class="btn btn-primary" @click="signature.asesor[asesor.id].clear()">Hapus</button>
                            </template>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Tanda Tangan Peserta
                            <br>
                            <canvas id="ttd-asesi" class="signature-pad" width="300" height="150"></canvas>
                            <button class="btn btn-primary" @click="signature.asesi.clear()">Hapus</button>
                        </td>
                    </tr>
                </table>
            </div>

            <div class="card-footer border border-left-0 border-right-0 border-bottom-0 bg-light">
                <button class="btn btn-success" @click="kirim">Beri Penilaian</button>
            </div>

        </div>
    </div>

@endsection

@push('js')
    <script src="{{ asset('js/signature_pad.min.js') }}"></script>
    <script>

        new Vue({
            el: '#root',
            data: {
                skema: @json($uji->getSkema(false)),
                daftarUnit: @json($uji->getSkema(false)->getSkemaUnit()->with(['getElemenKompetensi', 'getElemenKompetensi.getKriteria'])->get()),
                url: {
                    penilaian: '{{ route('penilaian.update', ['uji' => encrypt($uji->id)]) }}'
                },
                choosed: {
                    unit: {
                        id: -1,
                        nama: 'Pilih Unit'
                    }
                },
                centangSemuaUnitNilai: null,
                nilai: @json($uji->getPenilaian(false)->pluck('pivot')->keyBy('kriteria_id')),
                nilaiUnit: @json($uji->helper['nilai_unit']),
                rekomendasi_asesor: '{!! str_replace('<br />', '\n', $uji->rekomendasi_asesor) !!}',
                ttd_asesor: '',
                ttd_peserta: '',
                daftar_asesor: @json($uji->getAsesorUji(false)),
                signature: {
                    asesor: {},
                    asesi: null
                }
            },

            mounted: function () {
                let ratio = Math.max(window.devicePixelRatio || 1, 1)

                for (var asesor of this.daftar_asesor) {
                    let canvas = document.getElementById('ttd-asesor' + asesor.id)
                    
                    this.signature.asesor[asesor.id] = new SignaturePad(canvas, {
                        backgroundColor: 'rgba(255, 255, 255, 0)',
                        penColor: 'rgb(0, 0, 0)'
                    });

                    canvas.width = canvas.offsetWidth * ratio
                    canvas.height = canvas.offsetHeight * ratio
                    canvas.getContext("2d").scale(ratio, ratio)

                    this.signature.asesor[asesor.id].fromDataURL(asesor.pivot.ttd)
                }

                let canvas_asesi = document.getElementById('ttd-asesi')

                this.signature.asesi = new SignaturePad(canvas_asesi, {
                    backgroundColor: 'rgba(255, 255, 255, 0)',
                    penColor: 'rgb(0, 0, 0)'
                });

                canvas_asesi.width = canvas_asesi.offsetWidth * ratio
                canvas_asesi.height = canvas_asesi.offsetHeight * ratio
                canvas_asesi.getContext("2d").scale(ratio, ratio)
                this.signature.asesi.fromDataURL("{{ $uji->ttd_peserta }}")

                this.initUnitYangSelesai()
            },

            methods: {
                kirim() {
                    let that = this

                    swal({
                        icon: 'warning',
                        title: 'Apa anda yakin ?',
                        text: 'Anda tidak bisa mengedit setelah mengirim penilaian',
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
                    }).then(confirm => {
                        if (!confirm)
                            return
                            
                        let data = new FormData()
                        data.append('nilai', JSON.stringify(that.nilai))
                        data.append('nilai_unit', JSON.stringify(that.nilaiUnit))
                        data.append('rekomendasi_asesor', that.rekomendasi_asesor)

                        for (let asesor of that.daftar_asesor)
                            data.append('ttd_asesor[' + asesor.id + ']', that.signature.asesor[asesor.id].toDataURL())

                        data.append('ttd_asesi', that.signature.asesi.toDataURL())
                        axios.post(that.url.penilaian, data).then(response => {
                            if (response.data.success) {
                                swal({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.data.message
                                }).then(confirm => {
                                    window.location.reload()
                                })
                            }
                        }).catch(error => {
                            if (error.response) {
                                swal({
                                    icon: 'danger',
                                    title: 'Gagal',
                                    text: 'Gagal mengirim penilaian. Mohon ulangi beberapa saat lagi'
                                })
                            }
                        })
                    }).catch(error => {

                    })
                },

                ubahDaftarElemen(e, index) {
                    this.choosed.unit = this.daftarUnit[index]
                },

                centangSemuaNilai(e) {
                    let daftarKriteria = []

                    if (this.centangSemuaUnitNilai === null)
                        return

                    for (let elemen of this.choosed.unit.get_elemen_kompetensi) {
                        for (let kriteria of elemen.get_kriteria) {
                            this.nilai[kriteria.id].nilai = this.centangSemuaUnitNilai
                        }
                    }

                    this.initUnitSelesai(this.choosed.unit)
                    this.$forceUpdate()
                },

                initCentangUnitNilai() {
                    let unit = this.choosed.unit

                    var temp = null;

                    for (let elemen of unit.get_elemen_kompetensi) {
                        for (let kriteria of elemen.get_kriteria) {
                            if (temp === null)
                                temp = this.nilai[kriteria.id].nilai
                            else {
                                if (this.nilai[kriteria.id].nilai != temp || this.nilai[kriteria.id].nilai === null) {
                                    this.centangSemuaUnitNilai = null
                                    return
                                }
                            }
                        }
                    }

                    this.centangSemuaUnitNilai = temp
                },

                ubahNilai(e, kriteria) {
                    if (this.nilai[kriteria].nilai != this.centangSemuaUnitNilai)
                        this.centangSemuaUnitNilai = null

                    this.initUnitSelesai(this.choosed.unit)
                    this.$forceUpdate()
                },

                initUnitSelesai(unit) {
                    for (let elemen of unit.get_elemen_kompetensi) {
                        for (let kriteria of elemen.get_kriteria) {
                            if (this.nilai[kriteria.id].nilai == null) {
                                unit.selesai = false
                                return
                            }
                        }
                    }

                    unit.selesai = true
                    this.$forceUpdate()
                },

                initUnitYangSelesai: function () {
                    for (let unit of this.daftarUnit) {
                        this.initUnitSelesai(unit)
                    }
                }

            },

            watch: {
                'choosed.unit': function () {
                    this.initCentangUnitNilai()
                    this.$forceUpdate()
                },

                centangSemuaUnitNilai: function () {
                    this.centangSemuaNilai(null)
                }
            }
        })
    </script>
@endpush