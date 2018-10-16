@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title','Detail Pengguna | '.kustomisasi('nama'))

@section('content')

@row

@col(['size' => 8])
    @card(['id' => 'root'])
        @slot('title', 'Detail User')

        @can('update', $user)
            @slot('action')
            <button class="btn text-primary" @click="editMode = !editMode"><i class="fa fa-pencil-alt"></i> @{{ editMode ? 'Batalkan Edit' : 'Edit Data' }}</button>
            @endslot
        @endcan

        <div class="form-group row">
            <label class="col-lg-3">Nama</label>
            <div class="col-lg-9">
                <span v-if="!editMode">@{{ user.nama }}</span>
                <input type="text" v-model="user.nama" class="form-control" v-if="editMode">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-3">NIP/NIDN</label>
            <div class="col-lg-9">
                <span v-if="!editMode">@{{ user.nip != null ? user.nip : '-' }}</span>
                <input type="text" v-model="user.nip" class="form-control" v-if="editMode">
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-lg-3">Email</label>
            <div class="col-lg-9">
                <span v-if="!editMode">@{{ user.email }}</span>
                <input type="text" v-model="user.email" class="form-control" v-if="editMode">
            </div>
        </div>

        <div class="form-group row">
            <label class="col-lg-3"></label>
            <div class="col-lg-9">
                <button class="btn btn-primary" @click="simpan" v-if="!sedangMenyimpan && editMode">Simpan</button>
                <button class="btn btn-primary" v-if="sedangMenyimpan" disabled>Sedang Menyimpan ...</button>
                <button class="btn btn-danger" @click="hapus" v-if="!sedangMenghapus">Hapus</button>
            </div>
        </div>
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
@endcol

@col(['size' => 4])
    @card(['id' => 'role'])
        @slot('title', 'Role User')

        <div class="form-group">
            <label>Pilih role untuk ditambah</label>
            <select class="custom-select" @change="tambahRole" v-model="choosed">
                <option value="-1">Pilih role</option>
                <option :value="role.id" v-for="role in roles" :key="role.id">@{{ role.nama }}</option>
            </select>
        </div>

        <button class="btn btn-primary" @click="simpan">Simpan</button>

        @slot('list')
            <div class="list-group list-group-flush">
                <li class="list-group-item" v-for="(role, index) in daftarRole" :key="role.id">
                    @{{ role.nama }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="hapus($event, role, index)">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </li>
            </div>
        @endslot
    @endcard
@endcol

@endrow

@endsection

@push('js')
<script>
    new Vue({
        el: '#root',
        data: {
            user: @json($user),
            editMode: false,
            url: {
                simpan: '{{ route('user.edit', ['user' => encrypt($user->id)]) }}',
                hapus: '{{ route('user.hapus', ['user' => encrypt($user->id)]) }}'
            },
            sedangMenyimpan: false,
            sedangMenghapus: false
        },
        methods: {
            simpan: function () {
                this.sedangMenyimpan = true
                let that = this
                let data = {
                    nama: this.user.nama,
                    email: this.user.email,
                    nip: this.user.nip,
                    '_method': 'put'
                }

                axios.post(this.url.simpan, data).then(function (response) {
                    if (response.data.success) {
                        swal({
                            icon: 'success',
                            title: 'Berhasil',
                            text: response.data.message
                        })
                    }
                    that.sedangMenyimpan = false
                }).catch(function (error) {
                    that.sedangMenyimpan = false
                })
            },

            hapus: function () {
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

                    axios.post(that.url.hapus, {
                        '_method': 'delete'
                    }).then(function (response) {
                        if (response.data.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.data.message
                            }).then(function (confirm) {
                                window.location.replace(response.data.redirect)
                            })
                        }
                    }).catch(function (error) {

                    })
                })
            }
        }
    })

    new Vue({
        el: '#role',
        data: {
            roles: @json($roles),
            daftarRole: @json($daftarRole),
            choosed: -1,
            url: {
                update: '{{ route('user.update.role', ['user' => encrypt($user->id) ]) }}'
            }
        },
        mounted: function () {
            this.generateAvailableRoles()
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

                    let data = new FormData()
                    data.append('_method', 'put')
                    
                    for(let role of that.daftarRole) 
                        data.append('roles[]', role.id)

                    axios.post(that.url.update, data).then(function (response) {
                        if (response.data.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.data.message
                            })
                        }
                    }).catch(function (error) {

                    })
                }).catch(function (error) {

                })
            },

            tambahRole: function () {
                let that = this

                if (this.choosed === -1)
                    return

                role = this.roles.filter(function (value, index) {
                    return value.id === that.choosed
                })     

                this.daftarRole.push(role[0])     
                this.generateAvailableRoles()   
                this.choosed = -1
            },

            hapus: function (e, role, index) {
               var deleted = this.daftarRole.splice(index, 1)

               this.roles.push(deleted[0])
            },

            generateAvailableRoles: function () {
                let that = this

                for (var role in this.roles) {
                    search = this.daftarRole.filter(function (value, index) {
                        return value.id === that.roles[role].id
                    })

                    if (search.length > 0) {
                        this.roles.splice(role, 1)
                    }
                }
            }
        }
    })

    new Vue({
        el: '#reset',
        data: {
            url: {
                reset: '{{ route('user.reset.katasandi', ['user' => encrypt($user->id)]) }}'
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
            password: function () {
                // this.generatedRandom = this.password === this.generated
            } 
        }
    })
</script>
@endpush