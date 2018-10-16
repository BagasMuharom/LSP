@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

@section('content')
    @include('layouts.include.alert')

    <button class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">Tambah hak akses</button>
    <div class="collapse" id="collapseExample">
        <div class="card card-body">
            <form action="{{ route('role.add') }}" method="post">
                @csrf
                {{ method_field('put') }}
                @row

                @col(['size' => 4])
                @formgroup
                <label>Nama hak akses</label>
                <input class="form-control" type="text" name="nama" required>
                @endformgroup
                @endcol

                @col(['size' => 8])
                <label>Menu</label>
                @row
                @foreach($listmenu as $menu)
                    @col(['size' => 3])
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group form-check">
                                <input class="form-check-input" type="checkbox" name="menu[{{ $menu->id }}]">
                                <label class="form-check-label">{{ $menu->nama }}</label>
                            </div>
                        </div>
                    </div>
                    @endcol
                @endforeach
                @endrow
                @endcol

                @endrow
                <button class="btn btn-success" type="submit">Simpan</button>
            </form>
        </div>
    </div>
    @card(['title' => 'Daftar hak akses'])

    @alert(['type' => 'info'])
    Terdapat {{ $data->total() }} hak akses
    @endalert
    @slot('table')
    <table class="table table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Nama</th>
            <th>Jumlah User</th>
            <th>Jumlah Menu</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $role)
            <tr>
                <th>
                    {{ ($data->currentpage() * $data->perpage()) + (++$no) - $data->perpage()  }}
                </th>
                <th>
                    <form action="{{ route('role.update') }}" method="post" id="update-{{ $role->id }}">
                        {{ method_field('patch') }}
                        <input type="hidden" name="id" value="{{ $er = encrypt($role->id) }}">
                        <input class="form-control" name="nama" type="text" value="{{ $role->nama }}" {{ ($cek = in_array($role->nama, \App\Models\Role::ALL)) ? 'disabled' : '' }}>
                        @if(!$cek) @csrf @endif
                    </form>
                </th>
                <th>{{ $role->getUserRole()->count() }}</th>
                <th>{{ $role->getRoleMenu()->count() }}</th>
                <th>
                    <div class="btn-group">
                        @if(!$cek)
                            <button class="btn btn-success btn-sm" onclick="event.preventDefault(); $('#update-{{ $role->id }}').submit()">Simpan</button>
                        @endif
                        <button class="btn btn-warning btn-sm" onclick="event.preventDefault(); $(this).parent().parent().parent().next().toggle()">Edit/Detail menu</button>
                        @if(!$cek)
                            <button class="btn btn-danger btn-sm" onclick="$(this).next().submit()">Hapus</button>
                                <form action="{{ route('role.delete') }}" method="post" style="display: none">
                                    @csrf
                                    {{ method_field('delete') }}
                                    <input type="hidden" name="id" value="{{ $er }}">
                                </form>
                        @endif
                    </div>
                </th>
            </tr>
            <tr style="display: none">
                <th colspan="5">
                    <form action="{{ route('role.menu.update') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $er }}">
                        @row
                        @foreach($listmenu as $menu)
                            @col(['size' => 3])
                            <div class="card">
                                <div class="card-body">
                                    <div class="form-group form-check">
                                        <input class="form-check-input" type="checkbox" name="menu[{{ $menu->id }}]" {{ ($role->hasMenu($menu->route) ? 'checked' : '') }} {{ ($role->nama == \App\Models\Role::SUPER_ADMIN && $menu->route == \App\Models\Menu::ROLE) ? 'disabled' : '' }}>
                                        <label class="form-check-label">{{ $menu->nama }}</label>
                                    </div>
                                </div>
                            </div>
                            @endcol
                        @endforeach
                        @endrow
                        <button class="btn btn-success">Simpan</button>
                    </form>
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
    @endslot
    @endcard
@endsection