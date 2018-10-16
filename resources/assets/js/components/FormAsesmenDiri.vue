<template>
    <div class="card">
        <div class="card-header border border-top-0 border-left-0 border-right-0">
            Asesmen Diri
        </div>

        <div class="card-body">
            <p class="alert alert-info">
                Pastikan anda mengisi seluruh asesmen diri pada semua unit
            </p>
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
                    <th colspan="3">Nilai</th>
                </tr>
                <tr>
                    <th>
                        K
                        <div class="custom-control custom-control-lg custom-radio">
                            <input type="radio" name="centangsemua" class="custom-control-input" id="kompeten" v-model="centangSemuaUnit" value="K">
                            <label class="custom-control-label" for="kompeten">Centang semua</label>
                        </div>
                    </th>
                    <th>
                        BK
                        <div class="custom-control custom-control-lg custom-radio">
                            <input type="radio" name="centangsemua" class="custom-control-input" id="belumkompeten" v-model="centangSemuaUnit" value="BK">
                            <label class="custom-control-label" for="belumkompeten">Centang semua</label>
                        </div>
                    </th>
                </tr>
            </thead>
            <tbody>
                <template v-for="elemen in choosed.unit.get_elemen_kompetensi">
                    <tr :key="'el' + elemen.id">
                        <td colspan="4">{{ elemen.nama }}</td>
                    </tr>
                    <template v-for="kuk in elemen.get_kriteria">
                        <tr :key="kuk.id">
                            <td>{{ kuk.pertanyaan }}</td>
                            <td>
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input :name="'nilai' + kuk.id" v-model="nilai[kuk.id].nilai" type="radio" value="K" class="custom-control-input" :id="'k' + kuk.id" @change="ubahNilai($event, kuk.id)">
                                    <label class="custom-control-label" :for="'k' + kuk.id"></label>
                                </div>
                            </td>
                            <td>
                                <div class="custom-control custom-control-lg custom-radio">
                                    <input :name="'nilai' + kuk.id" v-model="nilai[kuk.id].nilai" type="radio" value="BK" class="custom-control-input" :id="'bk' + kuk.id" @change="ubahNilai($event, kuk.id)">
                                    <label class="custom-control-label" :for="'bk' + kuk.id"></label>
                                </div>
                            </td>
                        </tr>
                    </template>
                </template>
            </tbody>
        </table>

        <div class="card-footer border border-left-0 border-right-0 border-bottom-0 bg-light">
            <p class="alert alert-info">
                Anda bisa mengirim ketika anda telah mengisi seluruh asesmen diri pada semua unit
            </p>
            <button class="btn btn-success" :disabled="!bisaKirim" @click="kirim">Kirim Asesmen Diri</button>
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
                centangSemuaUnit: null,
                nilai: {},
                bisaKirim: false
            }
        },

        mounted() {
            this.skema = this.$parent.skema
            this.daftarUnit = this.$parent.daftarUnit
            this.initNilai()
        },

        methods: {
            kirim() {
                let that = this

                swal({
                    icon: 'warning',
                    title: 'Apa anda yakin ?',
                    text: 'Anda tidak bisa mengedit setelah mengirim asesmen diri',
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
                    axios.post(that.$parent.url.asesmendiri, that.nilai).then(response => {
                        if (response.data.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.data.message
                            }).then(confirm => {
                                window.location.replace(response.data.redirect)
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
                for (let unit of this.daftarUnit) {
                    for (let elemen of unit.get_elemen_kompetensi) {
                        for (let kriteria of elemen.get_kriteria) {
                            this.nilai[kriteria.id] = {
                                nilai: null
                            }
                        }
                    }
                }
            },

            centangSemua(e) {
                let daftarKriteria = []

                if (this.centangSemuaUnit === null)
                    return

                for (let elemen of this.choosed.unit.get_elemen_kompetensi) {
                    for (let kriteria of elemen.get_kriteria) {
                        this.nilai[kriteria.id].nilai = this.centangSemuaUnit
                    }
                }
                this.daftarUnit[this.choosed.index].selesai = true
                this.initBisaKirim()
                this.$forceUpdate()
            },

            initCentangUnit() {
                let unit = this.choosed.unit

                var temp = null;

                for (let elemen of unit.get_elemen_kompetensi) {
                    for (let kriteria of elemen.get_kriteria) {
                        if (temp === null)
                            temp = this.nilai[kriteria.id].nilai
                        else {
                            if (this.nilai[kriteria.id].nilai != temp || this.nilai[kriteria.id].nilai === null) {
                                this.centangSemuaUnit = null
                                return
                            }
                        }
                    }
                }

                this.centangSemuaUnit = temp
            },

            ubahNilai(e, kriteria) {
                if (this.nilai[kriteria].nilai != this.centangSemuaUnit)
                    this.centangSemuaUnit = null

                this.initUnitSelesai()
                this.$forceUpdate()
            },

            initUnitSelesai() {
                for (let elemen of this.choosed.unit.get_elemen_kompetensi) {
                    for (let kriteria of elemen.get_kriteria) {
                        if (this.nilai[kriteria.id].nilai == null) {
                            this.daftarUnit[this.choosed.index].selesai = false
                            return
                        }
                    }
                }

                this.daftarUnit[this.choosed.index].selesai = true
                this.initBisaKirim()
                this.$forceUpdate()
            },

            initBisaKirim() {
                for (let unit of this.daftarUnit) {
                    if (unit.selesai !== true) {
                        this.bisaKirim = false
                        return
                    }
                }

                this.bisaKirim = true
            }
        },

        watch: {
            'choosed.unit': function () {
                this.initCentangUnit()
                this.$forceUpdate()
            },

            centangSemuaUnit: function () {
                this.centangSemua(null)
            }
        }
    }
</script>