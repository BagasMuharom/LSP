@php
$daftarBerkas = GlobalAuth::user()->getDaftarBerkas();   
@endphp

@card
    @slot('title', 'Daftar Berkas')
    
    @slot('list')
    <div class="list-group list-group-flush">
        @forelse($daftarBerkas as $dir => $judul)
            <li class="list-group-item">
                <div class="d-flex justify-content-between">
                    <div>
                        {{ $judul }}
                    </div>
                    <div>
                        <div class="btn-group btn-group-sm">
                            <a href="{{ route('asesor.berkas.lihat', [
                                'asesor' => encrypt(GlobalAuth::user()->id),
                                'dir' => encrypt($dir)
                            ]) }}" class="btn btn-primary">Lihat</a>
                        </div>
                    </div>
                </div>
            </li>
            @empty
            <p class="alert alert-info mr-3 ml-3 mb-3">
                Tidak ada berkas.
            </p>
        @endforelse
    </div>
    @endslot
@endcard