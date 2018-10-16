@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    @row
    @col(['size' => 7])
    <div class="card">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama</th>
                        <th>Class Icon</th>
                        <th>Preview Icon</th>
                        <th>Aksi</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($data as $menu)
                        <tr>
                            <th>
                                {{ ($data->currentpage() * $data->perpage()) + (++$no) - $data->perpage()  }}
                            </th>
                            <th><input class="form-control" value="{{ $menu->nama }}" id="nama-{{ $menu->id }}"></th>
                            <th><input class="form-control" value="{{ $menu->icon }}" id="icon-{{ $menu->id }}"></th>
                            <th class="text-center"><i class="icon {{ $menu->icon }}"></i></th>
                            <th>
                                <button class="btn btn-success btn-sm" onclick="event.preventDefault(); update('{{ encrypt($menu->id) }}',$('#nama-{{ $menu->id }}').val(),$('#icon-{{ $menu->id }}').val())">Simpan</button>
                            </th>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                {{ $data->links() }}
            </div>
        </div>
    </div>
    @endcol

    @col(['size' => 5])
    <div class="card card-body">
        <button onclick="$(this).next().toggle()" class="btn btn-info btn-block">
            Daftar icon
        </button>
        <div style="display: none">
            <br>
            @row
            @foreach($icons as $icon)
                @col(['size' => 6])
                <div class="card card-body">
                    <i class="icon {{ $icon }}"></i>
                    <br>
                    {{ $icon }}
                </div>
                @endcol
            @endforeach
            @endrow
        </div>
    </div>
    @endcol
    @endrow

    <form action="{{ route('menu.update') }}" method="post" style="display: none" id="update">
        @csrf
        {{ method_field('patch') }}
        <input type="hidden" name="id" id="id">
        <input type="hidden" name="icon" id="icon">
        <input type="hidden" name="nama" id="nama">
    </form>
@endsection

@push('js')
<script>
    function update(id, nama, icon) {
        $('#id').val(id)
        $('#icon').val(icon)
        $('#nama').val(nama)
        $('#update').submit()
    }
</script>
@endpush