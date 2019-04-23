<template>
    <div class="text-left card" id="form-tambah-user">
        <div class="card-header border border-top-0 border-left-0 border-right-0">
            Tambah User Baru
        </div>

        <div class="card-body">
            <div class="form-group row">
                <label class="col-lg-4">Nama</label>
                <div class="col-lg-8">
                    <input type="text" v-model="input.nama" class="form-control" autofocus>

                    <p class="alert alert-danger mt-3" v-if="errors.nama != undefined">
                        {{ errors.nama[0] }}
                    </p>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-4">MET</label>
                <div class="col-lg-8">
                    <input type="text" v-model="input.met" class="form-control">

                    <p class="alert alert-danger mt-3" v-if="errors.met != undefined">
                        {{ errors.met[0] }}
                    </p>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-4">Email</label>
                <div class="col-lg-8">
                    <input type="email" v-model="input.email" class="form-control">

                    <p class="alert alert-danger mt-3" v-if="errors.email != undefined">
                        {{ errors.email[0] }}
                    </p>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-4">Kata sandi</label>
                <div class="col-lg-8">
                    <input type="password" v-model="input.password" class="form-control">

                    <p class="alert alert-danger mt-3" v-if="errors.password != undefined">
                        {{ errors.password[0] }}
                    </p>
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-4">Konfirmasi kata sandi</label>
                <div class="col-lg-8">
                    <input type="password" v-model="input.password_confirmation" class="form-control">
                </div>
            </div>
            
            <div class="form-group row">
                <label class="col-lg-4">Role</label>
                <div class="col-lg-8">
                    <select class="custom-select" @change="tambahRole" v-model="role.choosed">
                        <option value="-1">Pilih role</option>
                        <option :value="role.id" v-for="role in roles" :key="role.id">{{ role.nama }}</option>
                    </select>

                    <ul class="list-group">
                        <li class="list-group-item" v-for="role in daftarRole" :key="role.id">
                            {{ role.nama }}

                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="hapus($event, skema, index)">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="form-group row">
                <label class="col-lg-4"></label>
                <div class="col-lg-8">
                    <button class="btn btn-primary" @click="tambah" v-if="!isLoading">Tambah</button>
                    <button class="btn btn-primary" v-if="isLoading" disabled>Sedang menambahkan user ...</button>
                    <button class="btn btn-default" @click="batal">Batal</button>
                </div>
            </div>
        </div>
    </div>
</template>

<style lang="scss">
    #form-tambah-user {
        font-size: 14px;

        .list-group-item {
            font-size: 12px;
        }
    }
    .swal-modal {
        background: none;
        width: 600px;
    }
    .swal-content {
        padding: 0;
        margin: 0
    }
</style>


<script>
export default {
    data () {
        return {
            input: {
                nama: '',
                met: '',
                email: '',
                password: '',
                password_confirmation: '',
                roles: []
            },
            role: {
                choosed: -1
            },
            daftarRole: [],
            roles: [],
            errors: {},
            isLoading: false
        }
    },

    mounted() {
        this.roles = this.$parent.roles
    },

    methods: {
        tambah() {
            let that = this
            that.isLoading = true

            axios.post(this.$parent.url.tambah, this.input).then(response => {
                that.isLoading = false

                if (response.data) {
                    swal({
                        icon: 'success',
                        title: 'Berhasil !',
                        text: response.data.message
                    }).then(() => {
                        window.location.reload()
                    })
                }
            }).catch(error => {
                that.isLoading = false

                if (error.response) {
                    switch (error.response.status) {
                        case 422:
                            that.errors = error.response.data.errors
                            break
                    }
                }
            })
        },

        tambahRole() {
                let that = this

                if (this.role.choosed === -1)
                    return
                
                var role = this.roles.filter(function (value, index) {
                    return value.id === that.role.choosed
                })     

                this.daftarRole.push(role[0])     
                this.generateAvailableRoles()   
                this.role.choosed = -1

                this.generateInpuRole()
            },

            hapus(e, role, index) {
               var deleted = this.daftarRole.splice(index, 1)

               this.roles.push(deleted[0])

               this.generateInpuRole()
            },

            generateInpuRole() {
                let roles = []

                for (let index in this.daftarRole) {
                    roles.push(this.daftarRole[index].id)
                }

                this.input.roles = roles
            },

            generateAvailableRoles() {
                let that = this

                for (var role in this.roles) {
                    var search = this.daftarRole.filter(function (value, index) {
                        return value.id === that.roles[role].id
                    })

                    if (search.length > 0) {
                        this.roles.splice(role, 1)
                    }
                }
            },

            batal() {
                swal.close()
            }
    }
}
</script>
