<template>
    <div class="card">
        <div class="card-header border border-top-0 border-left-0 border-right-0">
            Asesmen Diri {{ mahasiswa.nama }}
        </div>

        <div class="card-body">
            <label>Pilih Unit</label>
            <div class="dropdown">
                <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                    {{ choosed.unit.nama }}
                </button>
                <div class="dropdown-menu">
                    <a v-for="(unit, index) in daftarUnit" :key="unit.id" class="dropdown-item" href="#" @click="choosed.unit = unit;choosed.index = index">{{ unit.nama }} <span class="badge badge-success float-right ml-3" v-if="unit.selesai">Selesai</span></a>
                </div>
            </div>
        </div>

        <table class="table table-bordered table-hovered" v-if="choosed.unit.id != -1">
            <thead class="text-center">
                <tr>
                    <th rowspan="2">Kriteria Unjuk Kerja</th>
                    <th colspan="2">Nilai</th>
                    <th rowspan="2" width="30%">Bukti</th>
                    <th colspan="4">Diisi Asesor</th>
                </tr>
                <tr>
                    <th>
                        K
                    </th>
                    <th>
                        BK
                    </th>
                    <th>
                        V

                        <div class="custom-control custom-control-lg custom-checkbox">
                            <input @change="centangSemuaToggle('V')" type="checkbox" name="v" class="custom-control-input" id="v" v-model="centangSemuaUnit.V">
                            <label class="custom-control-label" for="v"></label>
                        </div>
                    </th>
                    <th>
                        A

                        <div class="custom-control custom-control-lg custom-checkbox">
                            <input @change="centangSemuaToggle('A')" type="checkbox" name="a" class="custom-control-input" id="a" v-model="centangSemuaUnit.A">
                            <label class="custom-control-label" for="a"></label>
                        </div>
                    </th>
                    <th>
                        T

                        <div class="custom-control custom-control-lg custom-checkbox">
                            <input @change="centangSemuaToggle('T')" type="checkbox" name="t" class="custom-control-input" id="t" v-model="centangSemuaUnit.T">
                            <label class="custom-control-label" for="t"></label>
                        </div>
                    </th>
                    <th>
                        M

                        <!-- <div class="custom-control custom-control-lg custom-checkbox">
                            <input type="checkbox" name="m" class="custom-control-input" id="m" v-model="centangSemuaUnit.M" disabled>
                            <label class="custom-control-label" for="m"></label>
                        </div> -->
                    </th>
                </tr>
            </thead>
            <tbody>
                <template v-for="elemen in choosed.unit.get_elemen_kompetensi">
                    <tr :key="'el' + elemen.id">
                        <td colspan="9">{{ elemen.nama }}</td>
                    </tr>
                    <template v-for="kuk in elemen.get_kriteria">
                        <tr :key="kuk.id">
                            <td>{{ kuk.pertanyaan }}</td>
                            <td>
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input v-model="nilai[kuk.id].nilai" type="radio" value="K" class="custom-control-input" disabled>
                                    <label class="custom-control-label disabled"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input v-model="nilai[kuk.id].nilai" type="radio" value="BK" class="custom-control-input" disabled>
                                    <label class="custom-control-label disabled"></label>
                                </div>
                            </td>
                            <td>
                                <textarea class="form-control" v-model="nilai[kuk.id].bukti"></textarea>
                            </td>
                            <td>
                                <div class="custom-control custom-control-lg custom-checkbox">
                                    <input @change="initCentangUnit()" v-model="nilai[kuk.id].v" :name="'v' + kuk.id"  type="checkbox" value="V" class="custom-control-input" :id="'V' + kuk.id">
                                    <label class="custom-control-label disabled" :for="'V' + kuk.id"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-control-lg custom-checkbox">
                                    <input @change="initCentangUnit()" v-model="nilai[kuk.id].a" :name="'a' + kuk.id"  type="checkbox" value="A" class="custom-control-input" :id="'A' + kuk.id">
                                    <label class="custom-control-label disabled" :for="'A' + kuk.id"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-control-lg custom-checkbox">
                                    <input @change="initCentangUnit()" v-model="nilai[kuk.id].t" :name="'t' + kuk.id"  type="checkbox" value="T" class="custom-control-input" :id="'T' + kuk.id">
                                    <label class="custom-control-label disabled" :for="'T' + kuk.id"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-control-lg custom-checkbox">
                                    <input v-model="nilai[kuk.id].m" :name="'m' + kuk.id"  type="checkbox" value="M" class="custom-control-input" :id="'M' + kuk.id" disabled>
                                    <label class="custom-control-label disabled" :for="'M' + kuk.id"></label>
                                </div>
                            </td>
                        </tr>
                    </template>
                </template>
            </tbody>
        </table>

        <div class="row">
            <div class="col">
                <div class="form-group p-3">
                    <label>Rekomendasi Asesor</label>
                    <textarea id="rekomendasi" class="form-control" disabled></textarea>
                </div>
            </div>
            <div class="col">
                <div class="form-group p-3">
                    <label>Catatan</label>
                    <textarea id="catatan" class="form-control" v-model="uji.catatan_asesmen_diri"></textarea>
                </div>
            </div>
        </div>

        <div class="card-footer border border-left-0 border-right-0 border-bottom-0 bg-light">
            <button class="btn btn-success" @click="kirim($event)">Simpan Dulu</button>
            <button class="btn btn-warning" @click="kirim($event, true)">Simpan dan Konfirmasi</button>
        </div>
    </div>
</template>

<style lang="scss" scoped>
.custom-radio .custom-control-input:checked~.custom-control-label:after {
    background-image: url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E");
}

.table {
    thead tr {

        &:first-child {
            th {
                &:first-child {
                    width: 50%;
                }
            }
        }
        
        th {
            vertical-align: middle;
        }

    }

    tbody {

        td {
            font-size: 15px;
        }
        
    }
}
</style>

<script>
    export default {
        data() {
            return {
                daftarUnit: [],
                skema: {},
                choosed: {
                    unit: {
                        id: -1,
                        nama: 'Pilih Unit'
                    }
                },
                centangSemuaUnit: {
                    V: false,
                    A: false,
                    T: false,
                    M: false
                },
                nilai: {},
                mahasiswa: {},
                uji: {}
            }
        },

        mounted() {
            this.skema = this.$parent.skema
            this.daftarUnit = this.$parent.daftarUnit
            this.uji = this.$parent.uji
            this.mahasiswa = this.$parent.mahasiswa
            this.initNilai()
            this.initSelesai()
        },

        methods: {
            kirim(e, konfirmasi = false) {
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
                }).then(confirm => {
                    if (!confirm)
                        return
                        
                    axios.post(that.$parent.url.asesmendiri, {
                        nilai: that.nilai,
                        catatan: that.uji.catatan_asesmen_diri,
                        konfirmasi: konfirmasi
                    }).then(response => {
                        if (response.data.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.data.message
                            }).then(confirm => {
                                if (konfirmasi)
                                    window.location.replace(response.data.redirect)
                                else
                                    window.location.reload()
                            })
                        }
                    }).catch(error => {
                        if (error.response) {
                            swal({
                                icon: 'danger',
                                title: 'Gagal',
                                text: 'Gagal mengirim asesmen diri. Mohon ulangi beberapa saat lagi'
                            })
                        }
                    })
                }).catch(error => {

                })
            },

            ubahDaftarElemen(e, index) {
                this.choosed.unit = this.daftarUnit[index]
            },

            initNilai() {
                this.nilai = this.$parent.daftarNilai
            },

            centangSemuaToggle(keterangan) {
                for (let elemen of this.choosed.unit.get_elemen_kompetensi) {
                    for (let kriteria of elemen.get_kriteria) {
                        this.nilai[kriteria.id][keterangan.toLowerCase()] = this.centangSemuaUnit[keterangan]
                    }
                }

                this.$forceUpdate()
                if (this.centangSemuaUnit.V != false || this.centangSemuaUnit.A != false || this.centangSemuaUnit.T != false || this.centangSemuaUnit.M != false)
                    this.choosed.unit.selesai = true
                else
                    this.choosed.unit.selesai = false
            },

            initCentangUnit() {
                let unit = this.choosed.unit
                let stop = {
                    V: false,
                    A: false,
                    T: false,
                    M: false
                }

                for (let elemen of unit.get_elemen_kompetensi) {
                    for (let kriteria of elemen.get_kriteria) {
                        if (!stop.V) {
                            stop.V = (this.nilai[kriteria.id].v == null || !this.nilai[kriteria.id].v)
                        }
                        if (!stop.A) {
                            stop.A = (this.nilai[kriteria.id].a == null || !this.nilai[kriteria.id].a)
                        }
                        if (!stop.T) {
                            stop.T = (this.nilai[kriteria.id].t == null || !this.nilai[kriteria.id].t)
                        }
                        if (!stop.M) {
                            stop.M =( this.nilai[kriteria.id].m == null || !this.nilai[kriteria.id].m)
                        }
                    }
                }

                this.centangSemuaUnit.V = !stop.V
                this.centangSemuaUnit.A = !stop.A
                this.centangSemuaUnit.T = !stop.T
                this.centangSemuaUnit.M = !stop.M
                this.initSelesaiUnit(unit)
                this.$forceUpdate()
            },

            initSelesai() {
                for (let unit of this.daftarUnit) {
                    this.initSelesaiUnit(unit)
                }
            },

            initSelesaiUnit(unit) {
                let selesai = true

                for (let elemen of unit.get_elemen_kompetensi) {
                    for (let kriteria of elemen.get_kriteria) {
                        let nilai = this.nilai[kriteria.id]

                        if (nilai.v == null && nilai.a == null && nilai.t == null && nilai.m == null) {
                            selesai = false
                            break
                        }
                    }

                    if (!selesai)
                        break
                }

                unit.selesai = selesai
                this.$forceUpdate()
            }
        },

        watch: {
            'choosed.unit': function () {
                this.initCentangUnit()
            }
        }
    }
</script>