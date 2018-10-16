@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    @row

    @col(['size' => 8])
    @card(['title' => 'Daftar dana'])
    @slot('table')
    <table class="table table-hover">
        <thead>
        <tr>
            <th>Nama</th>
            <th>Berulang</th>
            <th>Keterangan</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $dana)
            <tr>
                <th>
                    <input type="text" class="form-control" id="nama{{ $dana->id }}" value="{{ $dana->nama }}" {{ $dana->nama == 'Mandiri' ? 'readonly' : '' }}>
                </th>
                <th>
                    <input id="berulang{{ $dana->id }}" type="checkbox" {{ $dana->berulang ? 'checked' : '' }} class="form-control">
                </th>
                <th>
                    <textarea class="form-control" id="keterangan{{ $dana->id }}">{{ $dana->keterangan }}</textarea>
                </th>
                <th>
                    <button class="btn btn-success btn-sm" onclick="event.preventDefault(); perbarui('{{ route('dana.update', ['dana' => encrypt($dana->id)]) }}', $('#nama{{ $dana->id }}').val(), $('#berulang{{ $dana->id }}').is(':checked'), $('#keterangan{{ $dana->id }}').val())">Simpan</button>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
    @endslot
    @endcard
    @endcol

    @col(['size' => 4])
    @card(['title' => 'Tambah dana'])
    <form action="{{ route('dana.add') }}" method="post">
        @csrf
        {{ method_field('put') }}
        <div class="form-group">
            <label>Nama</label>
            <input type="text" name="nama" class="form-control">
        </div>
        <div class="form-group">
            <input id="b" type="checkbox" name="berulang"> Berulang
        </div>
        <div class="form-group">
            <label>Keterangan</label>
            <textarea class="form-control" name="keterangan"></textarea>
        </div>
        <button class="btn btn-success">Simpan</button>
    </form>
    @endcard
    @endcol

    @endrow

    <form method="post" id="update">
        @csrf
        {{ method_field('patch') }}
        <input type="hidden" id="nama" name="nama" required>
        <input type="hidden" id="berulang" name="berulang" required>
        <input type="hidden" id="keterangan" name="keterangan" required>
    </form>
@endsection

@push('js')
<script>
    function perbarui(action, nama, berulang, keterangan){
        $('#update').attr('action', action)
        $('#nama').val(nama)
        $('#berulang').val(berulang)
        $('#keterangan').val(keterangan)
        $('#update').submit()
    }
</script>
@endpush