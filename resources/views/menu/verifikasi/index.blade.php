@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Verifikasi | '.kustomisasi('nama'))

@section('content')

<style>
    table {
        border-bottom: 1px solid #ddd;
    }
    .dropdown-suggest > button {
        width: 100%;
        text-align: right;
    }
    .dropdown-suggest > button > .choosed {
        float: left;
    }
    .dropdown-suggest > .dropdown-menu {
        min-width: 100%;
        padding-top:0 ;
    }
</style>

@card(['id' => 'root'])
@slot('title', 'Verifikasi')

{{-- Filter --}}
<form action="{{ url()->current() }}">
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label>Status</label>
                <select class="custom-select" name="status" v-model="filter.status">
                    <option value="7">Semua</option>
                    <option value="0">Belum ditanggapi</option>
                    @if(Auth::user()->hasRoleOutside([
                        App\Models\Role::ADMIN,
                        App\Models\Role::SERTIFIKASI]))
                    <option value="3">Terverifikasi Admin</option>
                    <option value="5">Ditolak Admin</option>
                    <option value="6">Ditolak Bag. Sertifikasi</option>
                    <option value="4">Terverifikasi Bag. Sertifikasi</option>
                    @else
                    <option value="1">Terverifikasi</option>
                    <option value="2">Ditolak</option>
                    @endif
                </select>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label>Pencarian</label>
                <input type="text" name="keyword" class="form-control" placeholder="Ketik nama atau nim" v-model="filter.keyword">
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group" style="position: relative">
                <input type="hidden" name="skema" v-model="filter.skema.id">
                <label>Skema</label>
                <div class="dropdown dropdown-suggest">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="choosed">@{{ filter.skema.nama }}</span>
                    </button>
                    <div class="dropdown-menu">
                        <input type="text" class="form-control" v-model="input.keyword_skema" @keyup="ubahOpsiDaftarSkema">
                        <div style="max-height: 150px;overflow-y:scroll;">
                        <a href="#" :key="skema.id" v-for="skema in daftarSkema" class="dropdown-item" @click.prevent="ubahOpsiSkema($event, skema)">@{{ skema.nama }}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3">
            <div class="form-group">
                <label>&nbsp;</label><br>
                <button class="btn btn-primary" type="submit">Lakukan Filter</button>
            </div>
        </div>
    </div>
</form>

@slot('table')
<p class="pl-3">
    Jumlah data : <b>{{ $total }}</b> 
</p>

<table class="table" id="table-uji">
    <thead>
        <tr>
            <th>Skema</th>
            <th>Nama</th>
            <th>NIM</th>
            <th>Prodi</th>
            <th>Tanggal Mendaftar</th>
            @can('verifikasi', App\Models\Uji::class)
            <th>Aksi</th>
            @endcan
        </tr>
    </thead>
    <tbody>
        @forelse ($daftaruji as $uji)
        <tr data-id="{{ $uji->id }}">
                <td>
                    {{ $uji->getSkema(false)->nama }} ({{ $uji->getEvent(false)->getDana(false)->nama }})
                    <br>
                    <span class="badge badge-{{ $uji->getStatus()['color'] }}">{{ $uji->getStatus()['status'] }}</span>
                </td>
                <td>{{ $uji->getMahasiswa(false)->nama }}</td>
                <td>{{ $uji->getMahasiswa(false)->nim }}</td>
                <td>{{ $uji->getMahasiswa(false)->getProdi(false)->nama }}</td>
                <td>{{ formatDate(Carbon\Carbon::parse($uji->created_at)) }}</td>
                @can('verifikasi', App\Models\Uji::class)
                <td>
                    <div class="btn-group">
                        <a class="btn btn-primary" target="_blank" href="{{ route('uji.detail', ['uji' => encrypt($uji->id)]) }}">Detail</a>
                        @if(Auth::user()->hasRole(App\Models\Role::SUPER_ADMIN))
                        {{-- verifikasi --}}
                        <div class="dropdown">
                            <button class="btn btn-success dropdown-toggle" type="button" data-toggle="dropdown">
                                Verifikasi
                            </button>
                            <div class="dropdown-menu">
                                @can('verifikasiAsAdmin', $uji)
                                <a href="#" @click.prevent="verifikasi($event, '{{ encrypt($uji->id) }}', 'admin')" class="dropdown-item">Sebagai Admin</a>
                                @endcan
                                @can('verifikasiAsSertifikasi', $uji)
                                <a href="#" @click.prevent="verifikasi($event, '{{ encrypt($uji->id) }}', 'sertifikasi')" class="dropdown-item">Sebagai Bag. Sertifikasi</a>
                                @endcan
                            </div>
                        </div>
                        {{-- menolak --}}
                        <div class="dropdown">
                            <button class="btn btn-warning dropdown-toggle" type="button" data-toggle="dropdown">
                                Tolak
                            </button>
                            <div class="dropdown-menu">
                                @can('verifikasiAsAdmin', $uji)
                                <a href="#" @click.prevent="tolak($event, '{{ encrypt($uji->id) }}', 'admin')" class="dropdown-item">Sebagai Admin</a>
                                @endcan
                                @can('verifikasiAsSertifikasi', $uji)
                                <a href="#" @click.prevent="tolak($event, '{{ encrypt($uji->id) }}', 'sertifikasi')" class="dropdown-item">Sebagai Bag. Sertifikasi</a>
                                @endcan
                            </div>
                        </div>
                        {{-- reset --}}
                        <button class="btn btn-danger" @click="reset($event, '{{ encrypt($uji->id) }}')">Reset</button>
                        @else
                        @can('verifikasiTertentu', $uji)
                        <button class="btn btn-success" @click="verifikasi($event, '{{ encrypt($uji->id) }}')">Verifikasi</button>
                        <button class="btn btn-danger" @click="tolak($event, '{{ encrypt($uji->id) }}')">Tolak</button>
                        @endcan
                        @endif
                    </div>
                </td>
                @endcan
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <p class="alert alert-primary text-center">
                        Tidak ada data.
                    </p>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
<div class="pl-3">
    {{ $daftaruji->links() }}
</div>
@endslot

@endcard

@endsection

@can('verifikasi', App\Models\Uji::class)
@push('js')
<script>
    new Vue({
        el: '#root',
        data: {
            url: {
                verifikasi: '{{ route('verifikasi.terima', ['uji' => '']) }}',
                tolak: '{{ route('verifikasi.tolak', ['uji' => '']) }}',
                daftar_skema: '{{ route('skema.daftar') }}',
                reset: '{{ route('verifikasi.reset', ['uji' => '']) }}'
            },
            filter: {
                status: {{ request()->has('status') ? request('status') : 0 }},
                keyword: '{{ request()->has('keyword') ? request('keyword') : '' }}',
                skema: {!! request()->has('skema') && request('skema') != -1 ? App\Models\Skema::find(request('skema')) : '{id: -1, nama: "Semua Skema"}' !!}
            },
            input: {
                keyword_skema: ''
            },
            daftarSkema: [{id: -1, nama: 'Semua Skema'}]
        },
        methods: {
            verifikasi: function (e, uji, auth) {
                let that = this
                let request = {}

                if ('string' === typeof auth)
                    request.auth = auth
                
                swal({
                    icon: 'warning',
                    title: 'Apa anda yakin ?',
                    closeOnClickOutside: false,
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
                    if (confirm) {
                        axios.post(that.url.verifikasi + '/' + uji, request).then(function (response) {
                            swal.close()
                            swal({
                                icon: 'success',
                                title: 'Berhasil !',
                                text: response.data.message
                            }).then(function () {
                                // menghapus baris tabel
                                that.hapusBaris(e)                           
                            })
                        }).catch(function (error) {
                            
                        })
                    }
                })
            },
            // end verifikasi
            tolak: function (e, uji, auth) {
                let that = this
                let div = document.createElement('div')
                let textarea = document.createElement('textarea')
                let alert = document.createElement('p')
                alert.style.display = 'none'
                alert.innerText = 'Catatan tidak boleh kosong !'
                alert.className = 'alert alert-danger mt-2'
                textarea.className = 'form-control'
                div.appendChild(textarea)
                div.appendChild(alert)

                let request = {}
                if ('string' === typeof auth)
                    request.auth = auth

                swal({
                    title: 'Mohon masukkan catatan',
                    content: div,
                    buttons: {
                        confirm: {
                            text: 'Kirim',
                            closeModal: false
                        },
                        cancel: {
                            text: 'Batal',
                            visible: true
                        }
                    }
                }).then(function (confirm) {
                    if (confirm) {
                        if (textarea.value === '') {
                            alert.style.display = 'block'
                            swal.stopLoading()
                        }
                        else {
                            request.catatan = textarea.value
                            // proses penolakan
                            axios.post(that.url.tolak + '/' + uji, request).then(function (response) {
                                if (response.data.success) {
                                    swal.close()
                                    swal({
                                        icon: 'success',
                                        title: 'Berhasil !',
                                        text: response.data.message
                                    }).then(function () {
                                        // menghapus baris tabel
                                        that.hapusBaris(e) 
                                    })
                                }
                            }).catch(function (error) {

                            })
                        }
                    }
                })
            },
            reset: function (e, uji, auth) {
                let that = this

                swal({
                    icon: 'warning',
                    title: 'Apa anda yakin ?',
                    closeOnClickOutside: false,
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

                    axios.post(that.url.reset + '/' + uji).then(function (response) {
                        if (response.data) {
                            if (response.data.success) {
                                swal({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: response.data.message
                                }).then(function () {
                                    window.location.reload()
                                })
                            }
                        }
                    }).catch(function (error) {

                    })
                })
            },
            // end tolak
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
                this.filter.skema = skema
            },
            hapusBaris: function (e) {
                // menghapus baris tabel
                let elem = e.target
                console.log(e.target)

                while(elem.tagName.toLowerCase() != 'tr') {
                    console.log(elem.tagName)
                    elem = elem.parentNode
                }

                $(elem).remove()

                if ($('#table-uji tbody').find('tr').length === 0)
                    window.location.reload()
            }
        }
        // end methods
    })
</script>
@endpush
@endcan