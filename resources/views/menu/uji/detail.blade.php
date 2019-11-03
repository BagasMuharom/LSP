@extends('layouts.carbon.app', [
    'sidebar' => true
])

@push('css')
    <meta name="uji" content="{{ $uji->id }}">
    <link rel="stylesheet" href="{{ asset('css/flatpickr.min.css') }}">
    <style>
        .dropdown-item.disabled, .dropdown-item:disabled {
            cursor: not-allowed
        }
    </style>
@endpush

@section('title', 'Detail')

@section('content')
    @row
        @col(['size' => 5])
            @card(['id' => 'detail'])
            @slot('title', 'Detail')
                @formgroup(['row' => true, 'class' => 'mb-0'])
                <label class="col-lg-4"><b>Skema</b></label>
                <div class="col-lg-8">
                    <p>{{ $skema->nama }}</p>
                </div>
                @endformgroup

                @formgroup(['row' => true, 'class' => 'mb-0'])
                <label class="col-lg-4"><b>Nama Mahasiswa</b></label>
                <div class="col-lg-8">
                    <p>{{ $mahasiswa->nama }}</p>
                </div>
                @endformgroup

                @formgroup(['row' => true, 'class' => 'mb-0'])
                <label class="col-lg-4"><b>NIM</b></label>
                <div class="col-lg-8">
                    <p>{{ $mahasiswa->nim }}</p>
                </div>
                @endformgroup
                
                @formgroup(['row' => true, 'class' => 'mb-0'])
                <label class="col-lg-4"><b>NIK</b></label>
                <div class="col-lg-8">
                    <p>{{ $mahasiswa->nik }}</p>
                </div>
                @endformgroup

                @formgroup(['row' => true, 'class' => 'mb-0'])
                <label class="col-lg-4"><b>Prodi</b></label>
                <div class="col-lg-8">
                    <p>{{ $mahasiswa->getProdi(false)->nama }}</p>
                </div>
                @endformgroup

                @formgroup(['row' => true, 'class' => 'mb-0'])
                <label class="col-lg-4"><b>Jurusan</b></label>
                <div class="col-lg-8">
                    <p>{{ $mahasiswa->getJurusan(false)->nama }}</p>
                </div>
                @endformgroup

                @formgroup(['row' => true, 'class' => 'mb-0'])
                <label class="col-lg-4"><b>Fakultas</b></label>
                <div class="col-lg-8">
                    <p>{{ $mahasiswa->getFakultas(false)->nama }}</p>
                </div>
                @endformgroup

                @formgroup(['row' => true, 'class' => 'mb-0'])
                @isset($uji->tempat_uji_id)
                <label class="col-lg-4"><b>Tempat Uji</b></label>
                <div class="col-lg-8">
                    <p>{{ $uji->getTempatUji(false)->nama }} ({{ $uji->getTempatUji(false)->kode }})</p>
                </div>
                @endisset
                @endformgroup

                @formgroup(['row' => true, 'class' => 'mb-0'])
                <label class="col-lg-4"><b>Asesor</b></label>
                <div class="col-lg-8">
                    {{-- Jika tidak bisa edit asesor --}}
                    @cannot('editAsesor', $uji)
                    @if($uji->hasAsesor())
                    <ol class="pl-3">
                    @foreach ($uji->getAsesorUji(false) as $asesor)
                        <li>{{ $asesor->nama }} {!! $loop->last ? '' : '<br/>' !!}</li>
                    @endforeach
                    </ol>
                    @else
                    -
                    @endif
                    @endcannot

                    {{-- Jika bisa edit asesor --}}
                    @can('editAsesor', $uji)
                    <select v-model="choosed.asesor.id" class="custom-select" @change="tambahAsesor">
                        <option value="-1">Pilih Asesor</option>
                        <option :key="asesor.id" v-for="asesor in daftarAsesor" :value="asesor.id">@{{ asesor.nama }}</option>
                    </select>

                    <ul class="list-group">
                        <li v-for="(asesor, index) in asesorUji" class="list-group-item">
                            @{{ asesor.nama }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close" @click="hapusAsesor($event, asesor, index)">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                        </li>
                    </ul>
                    @endcan
                </div>
                @endformgroup
                
                @formgroup(['row' => true, 'class' => 'mt-3'])
                <label class="col-lg-4"><b>Tanggal Uji</b></label>
                <div class="col-lg-8">
                    @can('editTanggalUji', $uji)
                    <input type="text" id="tanggal_uji" v-model="tanggal_uji">
                    @if(is_null($uji->tanggal_uji))
                        <p class="alert alert-warning p-2">
                            tanggal uji di atas belum disimpan.
                        </p>
                    @endif
                    @endcan

                    @cannot('editTanggalUji', $uji)
                    {{ !is_null($uji->tanggal_uji) ? formatDate(Carbon\Carbon::parse($uji->tanggal_uji), true, false) : '-' }}
                    @endcannot
                </div>
                @endformgroup

                @formgroup(['row' => true, 'class' => 'mb-0 mt-3'])
                <label class="col-lg-4"><b>Status</b></label>
                <div class="col-lg-8">
                    <span class="badge badge-{{ $uji->getStatus()['color'] }}" style="font-size: 15px">
                        {{ $uji->getStatus()['status'] }}
                    </span>
                </div>
                @endformgroup

                @can('editTidakLanjutAsesmen', $uji)
                @if(GlobalAuth::user()->can('editAsesor', $uji) || GlobalAuth::user()->can('editTanggalUji', $uji))
                @formgroup(['row' => true, 'class' => 'mb-0 mt-3'])
                <label class="col-lg-4"><b>Tidak melanjutkan asesmen</b></label>
                <div class="col-lg-8">
                    <div class="custom-control custom-checkbox custom-control-lg">
                        <input type="checkbox" name="tidak_lanjut" id="tidak_lanjut" class="custom-control-input" v-model="tidak_lanjut">
                        <label class="custom-control-label" for="tidak_lanjut"></label>
                    </div>
                </div>
                @endformgroup
                @endcan
                @endcan

                @if($uji->isDitolak())
                <p class="alert alert-warning mb-0 mt-3">
                    <b>Catatan : </b> {{ $uji->catatan }}
                </p>
                @endif
                
                
                @slot('footer')
                        @if(GlobalAuth::user()->can('editAsesor', $uji) || GlobalAuth::user()->can('editTanggalUji', $uji))
                            <button class="btn btn-success mb-1" @click="simpan">Simpan</button>
                        @endif

                        @can('buatSertifikat', $uji)
                            <a href="{{ route('sertifikat.tambah', ['uji' => encrypt($uji->id)]) }}" class="btn btn-success mb-1">Terbitkan Sertifikat</a>
                        @endcan

                        @can('delete', $uji)
                            <button class="btn btn-danger mb-1" @click="hapus">Hapus</button>
                        @endcan

                        @can('troubleshoot', \App\Models\Uji::class)
                            <a target="__blank" href="{{ route('uji.troubleshoot', ['uji' => encrypt($uji->id)]) }}" class="btn btn-warning">Troubleshoot</a>
                        @endcan

                        @can('lihatBerkasSertifikat', $uji->getSertifikat(false))
                            <a href="{{ route('sertifikat.lihat.berkas', ['sertifikat' => encrypt($uji->getSertifikat(false)->id)]) }}" class="btn btn-success mb-1">Lihat Sertifikat</a>
                        @endcan
                @endslot
            @endcard
        @endcol

        @col(['size' => 7])
            @card()
                @slot('title', 'Persyaratan Wajib')

                <a href="{{ route('lihat.syarat', ['jenis' => 'ktp', 'mahasiswa' => encrypt($mahasiswa->nim)]) }}" class="btn btn-primary" target="_blank">Lihat KTP</a>
                <a href="{{ route('lihat.syarat', ['jenis' => 'foto', 'mahasiswa' => encrypt($mahasiswa->nim)]) }}" class="btn btn-primary" target="_blank">Lihat Foto</a>
                <a href="{{ route('lihat.syarat', ['jenis' => 'transkrip', 'mahasiswa' => encrypt($mahasiswa->nim)]) }}" class="btn btn-primary" target="_blank">Lihat Transkrip</a>
            @endcard

            @card(['id' => 'root'])
            @slot('title', 'Persyaratan dan Bukti Kompetensi')
                <label>Berkas Persyaratan</label>
                <div class="dropdown">
                    <button class="btn btn-primary dropdown-toggle" type="button" data-toggle="dropdown">
                        <span class="choosed">@{{ choosed.nama }}</span>
                    </button>
                    <div class="dropdown-menu">
                        <a v-for="syarat in daftarSyarat" :key="syarat.id" href="#" :class="{'dropdown-item': true, 'disabled': (syarat.pivot.filename == null)}" @click.prevent="ubahChoosed(syarat)">
                            @{{ syarat.nama }} 
                            <span class="badge badge-warning float-right ml-3" v-if="syarat.pivot.filename == null && syarat.upload">Tidak diunggah</span> 
                            <span class="badge badge-warning float-right ml-3" v-if="syarat.pivot.filename == null && !syarat.upload">Terlampir dalam transkrip</span>
                        </a>
                    </div>
                </div>

                <div id="berkas-wrapper" class="mt-3">
                    @foreach ($daftarSyarat as $syarat)
                    <div class="berkas" v-show="choosed.id == {{ $syarat->id }}">
                            @if (in_array(pathinfo($syarat->pivot->filename, PATHINFO_EXTENSION), ['jpg', 'jpeg', 'png', 'gif']))
                            <img style="max-width: 100%" src="{{ route('uji.lihat.syarat', ['uji' => encrypt($uji->id), 'syarat' => encrypt($syarat->id)]) }}'">
                            @elseif (pathinfo($syarat->pivot->filename, PATHINFO_EXTENSION) === 'pdf')
                            <embed src="{{ route('uji.lihat.syarat', ['uji' => encrypt($uji->id), 'syarat' => encrypt($syarat->id)]) }}" type="application/pdf" style="width: 100%;height: 500px">
                            @endif
                        </div>
                    @endforeach
                </div>

                <label><b>Bukti Kompetensi</b></label>
                <ul class="list-group">
                    @forelse ($uji->getBuktiKompetensi() as $file => $bukti)
                        <li class="list-group-item">
                            {{ $bukti }}
                            <a class="btn btn-primary float-right" target="_blank" href="{{ route('uji.lihat.bukti.kompetensi', ['uji' => encrypt($uji->id), 'bukti' => $file]) }}">Lihat Berkas</a>
                        </li>
                    @empty
                        <p class="alert alert-info">Tidak ada bukti kompetensi yang diunggah.</p>
                    @endforelse
                </ul>
                
                <label><b>Portofolio</b></label>
                <ul class="list-group">
                    @forelse ($uji->getPortofolio() as $file => $portofolio)
                        <li class="list-group-item">
                            {{ $portofolio }}
                            <a class="btn btn-primary float-right btn-sm" target="_blank" href="{{ route('uji.lihat.portofolio', ['uji' => encrypt($uji->id), 'portofolio' => $file]) }}">Lihat Berkas</a>
                        </li>
                    @empty
                        <p class="alert alert-info">Tidak ada portofolio yang diunggah.</p>
                    @endforelse
                </ul>
            @endcard

            @card()
                @slot('title', 'Pemberkasan')

                @slot('table')
                    <table class="table table-border">
                        <thead>
                            <tr>
                                <th>Nama Berkas/Form</th>
                                <th>Cetak Berkas/Form</th>
                            </tr>
                        </thead>

                        <tbody>
                            @can('cetakFormPendaftaran', $uji)
                            <tr>
                                <td>
                                    Form pendaftaran
                                </td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('uji.cetak.form.pendaftaran', ['uji' => encrypt($uji->id)]) }}" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                </td>
                            </tr>
                            @endcan
                            
                            @can('cetakApl01', $uji)
                            <tr>
                                <td>APL 01</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('uji.cetak.apl01', ['uji' => encrypt($uji->id)]) }}" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                </td>
                            </tr>
                            @endcan
                            
                            @can('cetakApl02', $uji)
                            <tr>
                                <td>APL 02</td>
                                <td>
                                    <a class="btn btn-primary" href="{{ route('uji.cetak.apl02', ['uji' => encrypt($uji->id)]) }}" target="_blank"><i class="fa fa-print"></i> Versi 1</a>
                                    <a class="btn btn-primary" href="{{ route('uji.cetak.apl02v2', ['uji' => encrypt($uji->id)]) }}" target="_blank"><i class="fa fa-print"></i> Versi 2</a>
                                </td>
                            </tr>
                            @endcan

                            @can('cetakMak01', $uji)
                            <tr>
                                <td>MAK 01</td>
                                <td>
                                    <a href="{{ route('uji.cetak.mak01', ['uji' => encrypt($uji->id)]) }}" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                </td>
                            </tr>
                            @endcan
                            
                            @can('cetakMak02', $uji)
                            <tr>
                                <td>MAK 02</td>
                                <td>
                                    <a href="{{ route('uji.cetak.mak02', ['uji' => encrypt($uji->id)]) }}" class="btn btn-primary" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                </td>
                            </tr>
                            @endcan
                            
                            @can('cetakMak04', $uji)
                            <tr>
                                <td>MAK 04</td>
                                <td>
                                    <a href="{{ route('uji.cetak.mak04', ['uji' => encrypt($uji->id)]) }}" class="btn btn-primary" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                </td>
                            </tr>
                            @endcan
                            
                            @can('cetakMpa02', $uji)
                            <tr>
                                <td>MPA 02</td>
                                <td>
                                    <a href="{{ route('uji.cetak.mpa02', ['uji' => encrypt($uji->id)]) }}" class="btn btn-primary" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                </td>
                            </tr>
                            @endcan

                            @can('cetakFRAI02', $uji)
                            <tr>
                                <td>FR AI 02</td>
                                <td>
                                    <a href="{{ route('uji.cetak.frai02', ['uji' => encrypt($uji->id)]) }}" class="btn btn-primary" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                </td>
                            </tr>
                            @endcan
                            
                            @can('cetakKuesioner', $uji)
                            <tr>
                                <td>Kuesioner</td>
                                <td>
                                    <a href="{{ route('sertifikat.kuesioner.cetak', ['sertifikat' => encrypt($uji->getSertifikat(false)->id)]) }}" class="btn btn-primary" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                </td>
                            </tr>
                            @endcan

                            @can('cetakFRAC01', $uji)
                                <tr>
                                    <td>FR.AC.01 Formulir Rekaman Asesmen Kompetensi</td>
                                    <td>
                                        <a href="{{ route('uji.cetak.frac01', ['uji' => encrypt($uji->id)]) }}" class="btn btn-primary" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                    </td>
                                </tr>
                            @endcan

                            <tr>
                                <td>FR.AI.04 Ceklis Evaluasi Portofolio</td>
                                <td>
                                    <a href="{{ route('uji.cetak.frai04', ['uji' => encrypt($uji->id)]) }}" class="btn btn-primary" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                </td>
                            </tr>

                            @foreach($uji->getFRAI05() as $data)
                                <tr>
                                    <td>FR.AI.05 Ceklis Evaluasi Portofolio<br>({{ $data->unit }})</td>
                                    <td>
                                        <a href="{{ route('uji.cetak.frai05', ['uji' => encrypt($uji->id), 'c' => encrypt($loop->iteration - 1)]) }}" class="btn btn-primary" class="btn btn-primary" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
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
            daftarSyarat: @json($daftarSyarat),
            choosed: {
                nama: 'Pilih Persyaratan'
            }
        },
        methods: {
            ubahChoosed: function (syarat) {
                if (syarat.pivot.filename != null)
                    this.choosed = syarat
            },

            getFileFormat(str) {
                var re = /(?:\.([^.]+))?$/;
                var ext = re.exec(str)[1]
                var imageArr = ['jpg', 'png', 'jpeg', 'gif']

                if (imageArr.indexOf(ext) != -1)
                    return 'image'
                else if (ext == 'pdf')
                    return 'pdf'
                
                return null
            }
        }
    })

    new Vue({
        el: '#detail',
        data: {
            url: {
                edit: '{{ route('uji.edit', ['uji' => encrypt($uji->id)]) }}',
                halaman_uji : '{{ route('uji') }}',
                hapus: '{{ route('uji.hapus', ['uji' => encrypt($uji->id)]) }}'
            },
            choosed: {
                asesor: {!! $uji->hasAsesor() ? $uji->getAsesorUji(false) :  '{id: -1,nama: \'Pilih Asessor\'}' !!}
            },
            tanggal_uji: {!! !is_null($uji->tanggal_uji) ? 'new Date(\'' . $uji->tanggal_uji . '\')' : 'new Date(\'' . $uji->getevent(false)->tgl_uji . '\')' !!},
            // daftar asesor yang tersedia
            daftarAsesor: @json($daftarAsesor),
            // daftar asesor dari uji saat ini
            asesorUji: @json($daftarAsesorUji),
            tidak_lanjut: {{ $uji->tidak_melanjutkan_asesmen ? 'true' : 'false' }}
        },

        mounted: function () {
            let that = this
            let config = {
                defaultDate: that.tanggal_uji,
                altInput: true,
                altFormat: 'l, d F Y',
                locale: 'id'
            }

            flatpickr(document.getElementById('tanggal_uji'), config);
        },

        methods: {
            tambahAsesor: function () {
                let that = this

                if (this.choosed.asesor.id === -1)
                    return

                asesor = this.daftarAsesor.filter(function (value, index) {
                    return value.id === that.choosed.asesor.id
                })     

                this.asesorUji.push(asesor[0])     
                this.generateAvailableAsesor()   
                this.choosed.asesor.id = -1
            },

            hapusAsesor: function (e, asesor, index) {
                var deleted = this.asesorUji.splice(index, 1)

                this.daftarAsesor.push(deleted[0])
            },

            generateAvailableAsesor: function () {
                let that = this

                for (var role in this.daftarAsesor) {
                    search = this.asesorUji.filter(function (value, index) {
                        return value.id === that.daftarAsesor[role].id
                    })

                    if (search.length > 0) {
                        this.daftarAsesor.splice(role, 1)
                    }
                }
            },

            simpan: function () {
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

                    let asesoruji = []

                    for (let asesor of that.asesorUji)
                        asesoruji.push(asesor.id)

                    axios.post(that.url.edit, {
                        asesor: asesoruji,
                        tanggal_uji: that.tanggal_uji,
                        tidak_lanjut: that.tidak_lanjut
                    }).then(function (response) {
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
                        if (error.response) {
                            if (error.response.status == 422) {
                                swal({
                                    icon: 'danger',
                                    title: 'Gagal',
                                    text: error.response.data.errors.asesor[0]
                                })
                            }
                        }
                    })
                })
            },

            hapus: function () {
                let that = this

                swal({
                    icon: 'warning',
                    title: 'Apa anda yakin ?',
                    text: 'Penghapusan tidak bisa diurungkan',
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

                    axios.post(that.url.hapus, {
                        '_method': 'delete'
                    }).then(function (response) {
                        if (response.data.success) {
                            swal({
                                icon: 'success',
                                title: 'Berhasil !',
                                text: response.data.message
                            }).then(function () {
                                window.location.replace(that.url.halaman_uji)
                            })
                        }
                    })
                })
            }
            // end function

        }
    })
</script>
@endpush