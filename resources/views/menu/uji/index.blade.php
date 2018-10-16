@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Daftar Uji | LSP Unesa')

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
@slot('title', 'Daftar Uji')

{{-- Filter --}}
<form action="{{ url()->current() }}">
    <div class="row">
        <div class="col-lg-3">
            <div class="form-group">
                <label>Status</label>
                <select class="custom-select" name="status" v-model="filter.status">
                    <option value="7">Semua</option>
                    <option value="8">Telah mengisi asesmen diri</option>
                    <option value="17">Lulus asesmen diri</option>
                    <option value="18">Tidak lulus asesmen diri</option>
                    <option value="9">Belum memiliki asesor</option>
                    <option value="13">Belum memiliki tanggal uji</option>
                    <option value="10">Belum dinilai/diuji</option>
                    <option value="14">Dalam proses penilaian</option>
                    <option value="11">Lulus</option>
                    <option value="15">Tidak Lulus</option>
                    <option value="16">Tidak Lanjut Asesmen</option>
                    <option value="12">Memiliki sertifikat</option>
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

<button class="btn btn-success" onclick="$(event.target).next().submit()">Ekspor Daftar Uji untuk BNSP</button>
<form ref="ekspor" action="{{ route('uji.ekspor', request()->all()) }}" method="post">
    @csrf
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
            <th>Tanggal Uji</th>
            @can('verifikasi', App\Models\Uji::class)
            <th>Opsi</th>
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
                @if($uji->getAsesorUji()->count() == 0)
                <br>
                <span class="badge badge-danger">Belum memiliki asesor</span>
                @endif
            </td>
            <td>{{ $uji->getMahasiswa(false)->nama }}</td>
            <td>{{ $uji->getMahasiswa(false)->nim }}</td>
            <td>{{ $uji->getMahasiswa(false)->getProdi(false)->nama }}</td>
            <td>{{ !is_null($uji->tanggal_uji) ? formatDate(Carbon\Carbon::parse($uji->tanggal_uji)) : '-' }}</td>
            @can('verifikasi', App\Models\Uji::class)
            <td>
                <div class="btn-group">
                    <a class="btn btn-primary" target="_blank" href="{{ route('uji.detail', ['uji' => encrypt($uji->id)]) }}">Detail</a>
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

@push('js')
<script>
    new Vue({
        el: '#root',
        data: {
            url: {
                daftar_skema: '{{ route('skema.daftar') }}',
            },
            filter: {
                status: {{ request()->has('status') ? request('status') : 7 }},
                keyword: '{{ request()->has('keyword') ? request('keyword') : '' }}',
                skema: {!! request()->has('skema') && request('skema') != -1 ? App\Models\Skema::find(request('skema')) : '{id: -1, nama: "Semua Skema"}' !!}
            },
            input: {
                keyword_skema: ''
            },
            daftarSkema: [{id: -1, nama: 'Semua Skema'}]
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
                this.filter.skema = skema
            }
        }
    })
</script>
@endpush