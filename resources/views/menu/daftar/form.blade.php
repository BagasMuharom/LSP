@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Pendaftaran Sertifikasi | LSP Unesa')

@section('content')

    @can('create', App\Models\Uji::class)
        @card(['id' => 'root'])
            @slot('title', 'Pendaftaran Sertifikasi')
            <form-pendaftaran-sertifikasi :daftar-event="daftarEvent" :url="url"></form-pendaftaran-sertifikasi>
        @endcard
    @endcan

    @include('menu.daftar.status')

    @cannot('create', App\Models\Uji::class)
        @card
            @slot('title', 'Tidak bisa mendaftar')

            @alert(['type' => 'warning'])
                Anda tidak bisa melakukan pendaftaran sertifikasi untuk saat ini.
            @endalert
        @endcard
    @endcannot
@endsection

@push('js')
<script>
new Vue({
    el: '#root',
    data: {
        daftarEvent: @json($daftarEvent),
        url: {
            action: '{{ route('uji.pendaftaran') }}',
            daftar_syarat: '{{ route('skema.daftar_syarat') }}'
        }
    }
})
</script>
@endpush