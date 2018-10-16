@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Asesmen Diri | LSP Unesa')

@section('content')
    @can('penilaianDiri', $uji)
        <div id="root">
            <form-asesmen-diri-asesor></form-asesmen-diri-asesor>
        </div>
    @endcan

    @cannot('penilaianDiri', $uji)
        @card
            @alert(['type' => 'info'])
                Anda sudah tidak bisa mengisi asesmen diri untuk uji terkait. Mohon kembali ke halaman daftar penilaian.
            @endalert
        @endcard
    @endcannot
@endsection

@push('js')
<script>
    new Vue({
        el: '#root',
        data: {
            uji: @json($uji),
            skema: @json($skema),
            daftarUnit: @json($daftarUnit),
            mahasiswa: @json($uji->getMahasiswa(false)),
            daftarNilai: @json($daftarNilai),
            url: {
                asesmendiri: '{{ route('uji.update.asesmendiri.asesor', ['uji' => encrypt($uji->id)]) }}'
            }
        }
    })
</script>
@endpush