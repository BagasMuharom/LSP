<template>
    <div>
        <div class="form-group">
            <label>Pilih berkas excel</label>

            <div class="input-group mb-3">
                <div class="input-group-prepend">
                    <button class="btn btn-outline-primary btn-pilih-berkas" type="button">Pilih Berkas</button>
                </div>
                <div class="custom-file">
                    <input class="custom-file-input" type="file" ref="file">
                    <label class="custom-file-label">Anda belum mengunggah berkas</label>
                </div>
            </div>
        </div>

        <button class="btn btn-primary" v-show="!uploading" @click="upload">Impor</button>
        <button class="btn btn-default" v-show="!uploading" @click="cancel">Batal</button>
        <button class="btn btn-primary" v-show="uploading" disabled>Sedang Mengunggah .....</button>
    </div>
</template>

<style lang="scss" scoped>
.custom-file-label::after {
    display: none;
}
</style>


<script>
export default {
    data() {
        return {
            uploading: false
        }
    },

    mounted() {
        
    },

    methods: {
        upload() {
            this.uploading = true
            let that = this
            let data = new FormData()
            data.append('file', this.$refs.file.files[0])
            
            let config = {
                onUploadProgress: progressEvent => {
                    console.log(progressEvent)
                }
            }

            axios.post(that.$parent.url.impor, data, config).then(response => {
                if (response.data.success) {
                    swal({
                        icon: 'success',
                        title: 'Berhasil',
                        text: response.data.message
                    }).then(() => {
                        window.location.reload()
                    })
                }
                that.uploading = false
            }).catch(error => {  
                that.uploading = false
            })
        },

        cancel() {
            swal.close()
        }
    }
}
</script>
