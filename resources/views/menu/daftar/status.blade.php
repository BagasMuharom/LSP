@card
    @slot('title', 'Status Pendaftaran Sertifikasi')

    @slot('table')
    <table class="table">
        <thead>
            <tr>
                <th>Skema</th>
                <th>Tanggal Pendaftaran</th>
                <th>TUK</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
        @forelse ($daftaruji as $uji)
            <tr>
                <td>{{ $uji->getSkema(false)->nama }} ({{ $uji->getEvent(false)->getDana(false)->nama }})</td>
                <td>{{ formatDate($uji->created_at)  }}</td>
                <td>{{ $uji->getSkema(false)->getTempatUji(false)->nama }}</td>
                <td><h5><span class="badge badge-{{ $uji->getStatus()['color'] }}">{{ $uji->getStatus()['status'] }}</span></h5></td>
                <td>
                    <a href="{{ route('uji.detail', ['uji' => $uji->pk]) }}" class="btn btn-primary">Detail</a>
                    @if(GlobalAuth::user()->can('asesmenDiri', $uji))
                    <a href="{{ route('sertifikasi.asesmen.diri', ['uji' => $uji->pk]) }}" class="btn btn-success">Isi Asesmen Diri</a>
                    @endif
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <p class="alert alert-info text-center">
                        Tidak ada data.
                    </p>
                </td>
            </tr>
        @endforelse
        </tbody>
    </table>
    @endslot
@endcard