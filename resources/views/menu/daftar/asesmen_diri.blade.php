@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Asesmen Diri | '.kustomisasi('nama'))

@section('content')
<div id="root">
    <form-asesmen-diri></form-asesmen-diri>
</div>
@endsection

@push('js')
<script>
    let app = new Vue({
        el: '#root',
        data: {
            skema: @json($skema),
            daftarUnit: @json($daftarUnit),
            url: {
                asesmendiri: '{{ route('uji.update.nilai.asesmendiri', ['uji' => encrypt($uji->id)]) }}'
            }
        },
        methods: {

        }
    })
</script>
@endpush