@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Riwayat Sertifikasi')

@section('content')
@card(['id' => 'root'])
    @slot('title', 'Riwayat Sertifikasi')

    @slot('table')
        <table class="table">
            <thead>
                <tr>
                    <th>Skema</th>
                    <th>Tanggal Uji</th>
                    <th>Tempat Uji</th>
                    <th>Asesor</th>
                    <th>Status</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($daftarUji as $uji)
                    <tr>
                        <td>{{ $uji->getSkema(false)->nama }}</td>
                        <td>{{ formatDate(Carbon\Carbon::parse($uji->tanggal_uji)) }}</td>
                        <td>{{ $uji->getTempatUji(false)->nama }}</td>
                        <td>
                            @if($uji->hasAsesor())
                            <ol class="p-0">
                                @foreach ($uji->getAsesorUji(false) as $asesor)
                                    <li>{{ $asesor->nama }}</li>
                                @endforeach
                            </ol>
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <h5><span class="badge badge-{{ $uji->getStatus()['color'] }}">{{ $uji->getStatus()['status'] }}</span></h5>
                        </td>
                        <td>
                            <a href="{{ route('uji.detail', ['uji' => encrypt($uji->id)]) }}" class="btn btn-primary btn-sm mb-1">Detail</a>

                            @can('isiKuesioner', $uji)
                            <a href="{{ route('sertifikat.kuesioner.isi', ['sertifikat' => encrypt($uji->getSertifikat(false)->id)]) }}" class="btn btn-success btn-sm mb-1">Isi Kuesioner</a>
                            @endif

                            @can('isimak4', $uji)
                            {{-- <a href="{{ route('uji.isi.mak4', ['uji' => encrypt($uji->id)]) }}" class="btn btn-primary btn-sm mb-1">Isi Form MAK 04</a> --}}
                            @endif
                        </td>
                    </tr>
                @endforeach
                <tr v-if="daftarUji.length == 0">
                    <td colspan="6">
                        <p class="alert alert-info text-center">
                            Tidak ada data.
                        </p>
                    </td>
                </tr>
            </tbody>
        </table>
    @endslot
@endcard
@endsection

@push('js')
<script>
    new Vue({
        el: '#root',
        data: {
            url: {
                detail: '{{ route('uji.detail', ['uji' => '']) }}'
            },
            daftarUji: @json($daftarUji)
        }
    })
</script>
@endpush