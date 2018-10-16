<template>
    <form :action="url.action" method="post" enctype="multipart/form-data" @submit.prevent="submit()">
        <input type="hidden" name="_token" :value="csrf">
        <div class="form-group">
            <label>Pilih Skema</label>

            <select name="skema" id="skema" class="custom-select" v-model="skema" @change="ubahDaftarPersyaratan">
                <option value="-1">Pilih Skema</option>
                <option :value="event.id" v-for="event in daftarEvent" :key="event.id">{{ event.get_skema.nama }} ({{ event.get_dana.nama }})</option>
            </select>
        </div>
        
        <template v-if="daftarSyarat.length > 0">
            <h4>Unggah Berkas Persyaratan (Tidak wajib)</h4>
            <p class="alert alert-warning">
                Jenis file yang bisa diunggah adalah gambar (jpg, png, gif) atau file pdf dengan ukuran maksimal 500KB.
            </p>
            <div :key="syarat.id" v-for="(syarat, index) in daftarSyarat" class="form-group">
                <label class="col-form-label">{{ syarat.nama }}</label>
                <div class="input-group mb-3">
                    <div class="input-group-prepend">
                        <button class="btn btn-outline-primary btn-pilih-berkas" type="button">Pilih Berkas</button>
                    </div>
                    <div class="custom-file">
                        <input class="custom-file-input" type="file" @change="ubahSyarat($event, index)" :name="nameSyarat(syarat.id)">
                        <label class="custom-file-label">Anda belum mengunggah berkas</label>
                    </div>
                </div>

                <p class="alert alert-danger" v-show="hasError(syarat.id)">
                    {{ getValidationError(syarat.id) }}
                </p>
            </div>
        </template>

        <template v-if="daftarSyarat.length == 0 && skema != -1">
            <p class="alert alert-info">
                Tidak ada persyaratan tambahan yang diperlukan.
            </p>
        </template>

        <!-- Tambahan bukti kompetensi -->
        <template v-if="skema != -1">
            <h5>Unggah Bukti Kompetensi (Tidak Wajib)</h5>
            <p>Jika anda memiliki bukti Pendidikan/Pelatihan, Pengalaman Kerja, atau Pengalaman Hidup yang berhubungan dengan skema anda</p>
            <form class="form-inline" v-for="(value, index) in daftarBuktiKompetensi" :key="index">
                <div class="form-group mb-2">
                    <input type="text" class="form-control" v-model="value.nama">
                </div>
                <div class="form-group mx-sm-3 mb-2">
                    <div class="custom-file">
                        <input type="file" class="custom-file-input" :id="'bukti' + index" @change="ubahFileBukti($event, value)">
                        <label class="custom-file-label">Pilih File</label>
                    </div>
                </div>

                <button type="submit" class="btn btn-danger mb-2" @click.prevent="hapusBukti(index)">Hapus</button>
            </form>

            <button type="submit" class="btn btn-primary mb-2" @click.prevent="tambahBukti">Tambah Bukti Kompetensi</button>
        </template>

        <p v-show="daftarSyarat.length > 0" class="alert alert-warning">
            Mohon untuk mengoreksi kembali data-data yang dimasukkan.
        </p>

        <button v-if="skema != -1" type="submit" class="btn btn-primary btn-lg">Daftar</button>
    </form>
</template>

<script>
    export default {
        props: {
            daftarEvent: Array,
            url: Object
        },
        data: () => {
            return {
                skema: -1,
                daftarSyarat: [],
                csrf: null,
                valErrors: {},
                event: null,
                daftarBuktiKompetensi: []
            }
        },
        mounted() {
            this.csrf = document.head.querySelector('meta[name="csrf-token"]').content
        },
        methods: {
            ubahDaftarPersyaratan() {
                let that = this

                this.event = this.daftarEvent.filter((item) => {
                    return item.id == that.skema
                })[0]

                if (this.skema == -1)
                    return

                axios.post(this.url.daftar_syarat, {
                    skema: that.event.get_skema.id
                }).then((response) => {
                    that.daftarSyarat = response.data
                }).catch((response) => {

                })
            },

            nameSyarat(syarat) {
                return 'syarat[' + syarat + ']'
            },

            ubahSyarat(event, index) {
                this.daftarSyarat[index].content = event.target.files[0]
            },

            submit() {
                let that = this

                swal({
                    icon: 'warning',
                    title: 'Apa anda yakin ?',
                    text: 'Pastikan anda memilih skema yang sesuai',
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
                
                    let formData = new FormData()
                    formData.append('event', that.event.id)
                    let config = {
                        headers: {
                            'Content-Type': 'multipart/form-data'
                        }
                    }

                    for (let index in that.daftarSyarat) {
                        let name = that.nameSyarat(that.daftarSyarat[index].id)
                        let content = that.daftarSyarat[index].content
                        if (content !== undefined)
                            formData.append(name, content)  
                    }

                    for (let bukti of that.daftarBuktiKompetensi) {
                        if (bukti.nama != null && bukti.nama != '' && bukti.file != null) {
                            formData.append('bukti_kompetensi_nama[]', bukti.nama)
                            formData.append('bukti_kompetensi_file[]', bukti.file)
                        }
                    }
                    
                    // Ajax memulai proses pendaftaran
                    axios.post(that.url.action, formData, config).then(function (response) {
                        if (response.data.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil !',
                                text: 'Berhasil melakukan pendaftaran sertifikasi. Pendaftaran akan diverifikasi oleh admin dan pihak LSP.'
                            }).then(function (ok) {
                                if (ok) {
                                    window.location.reload()
                                }
                            })
                        }
                    }).catch(function (error) {
                        if (error.response) {
                            switch (error.response.status) {
                                case 422:
                                    that.valErrors = error.response.data.errors
                                    break
                                case 500:
                                    swal({
                                        icon: 'danger',
                                        title: 'Gagal !',
                                        text: 'Terjadi kesalahan pada server, coba beberapa saat lagi.'
                                    })
                                    break
                            }
                        }
                    })
                })
            },
            
            hasError(syarat) {
                return 'undefined' !== typeof this.valErrors['syarat.' + syarat]
            },

            getValidationError(syarat) {
                if ('undefined' === typeof this.valErrors['syarat.' + syarat])
                    return null

                return this.valErrors['syarat.' + syarat][0]
            },

            tambahBukti() {
                this.daftarBuktiKompetensi.push({
                    file: null,
                    nama: null
                });
            },

            hapusBukti(index) {
                this.daftarBuktiKompetensi.splice(index, 1)
            },

            ubahFileBukti(e, form) {
                let file = e.target.files[0]

                form.file = file
            }

        },
        computed: {
            
        }
    }
</script>