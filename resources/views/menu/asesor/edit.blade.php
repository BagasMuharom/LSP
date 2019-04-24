@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Edit Asesor | LSP Unesa')

@section('content')

@row
    @col(['size' => 4])
        @card
            @slot('title', 'Data Pengguna ' . $asesor->nama)
                <b>Nama</b>
                <p>{{ $asesor->nama }}</p>
                <b>MET</b>
                <p>{{ $asesor->nip }}</p>
                <b>E-mail</b>
                <p>{{ $asesor->email }}</p>

                <a class="btn btn-primary" href="{{ route('asesor.daftar.uji', ['uji' => encrypt($asesor->id)]) }}">Lihat daftar uji dari asesor ini</a>
        @endcard
    @endcol

    @col(['size' => 8])
        @card(['id' => 'root'])
        @slot('title', 'Edit Daftar Skema')

        @row
            @col(['class' => 'col-md-auto p-3'])
                <div class="form-group">
                    <label>Tambah Skema</label>
                    <div class="dropdown dropdown-suggest">
                        <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                            <span class="choosed">@{{ choosed.nama }}</span>
                        </button>
                        <div class="dropdown-menu">
                            <input type="text" class="form-control" v-model="input.keyword_skema" @keyup="ubahOpsiDaftarSkema">
                            <div style="max-height: 150px;overflow-y:scroll;">
                            <a href="#" :key="skema.id" v-for="skema in daftarSkema" class="dropdown-item" @click.prevent="ubahOpsiSkema($event, skema)">@{{ skema.nama }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endcol
            @col(['class' => 'col-md-auto p-3'])
                <div class="form-group">
                    <label>Simpan Perubahan</label><br>
                    <button class="btn btn-warning" @click="simpan">Simpan</button>
                </div>
            @endcol
        @endrow

        <p class="alert alert-danger" v-show="sudahAda">
            Skema tersebut sudah ada dalam daftar !
        </p>

            @slot('list')
                <div class="list-group list-group-flush">
                    <li class="list-group-item" v-for="(skema, index) in daftarAsesorSkema" :key="skema">
                        @{{ skema.nama }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="hapus($event, skema, index)">
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
            url: {
                edit: '{{ route('asesor.edit', ['asesor' => encrypt($asesor->id)]) }}',
                daftar_skema: '{{ route('skema.daftar') }}'
            },
            daftarAsesorSkema: @json($daftarAsesorSkema),
            input: {
                keyword_skema: ''
            },
            choosed: {
                id: -1,
                nama: 'Pilih Skema'
            },
            daftarSkema: [{id: -1, nama: 'Semua Skema'}],
            sudahAda: false
        },
        methods: {
            ubahOpsiDaftarSkema: function (e) {
                let that = this

                axios.post(this.url.daftar_skema, {
                    keyword: that.input.keyword_skema
                }).then(function (response) {
                    if (response.data.length > 0) {
                        that.daftarSkema = response.data
                    }
                }).catch(function (error) {

                })
            },
            ubahOpsiSkema: function (e, skema) {
                this.choosed = skema

                for (let each of this.daftarAsesorSkema) {
                    if (skema.id === each.id) {
                        this.sudahAda = true
                        return
                    }
                }
                this.sudahAda = false
                this.daftarAsesorSkema.push(skema)
            },
            hapus: function (e, skema, index) {
                this.daftarAsesorSkema.splice(index, 1)
            },
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
                    for(let each of that.daftarAsesorSkema)
                        data.append('skema[]', each.id)

                    axios.post(that.url.edit, data).then(function (response) {
                        if (response.data.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil !',
                                text: response.data.message
                            }).then(function () {
                                window.location.reload()
                            })
                        }
                    }).catch(function (error) {

                    })
                })
            }
        }
    })
</script>
@endpush