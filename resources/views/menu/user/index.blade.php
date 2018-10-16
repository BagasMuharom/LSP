@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', 'Daftar User')

@section('content')

@card(['id' => 'root'])
    @slot('title', 'Daftar User')

    <button class="btn btn-primary" @click="form">Tambah User Baru</button>

    @slot('table')
        <p class="pl-3">
            Jumlah data : <b>{{ $total }}</b> 
        </p>

        <table class="table">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>

            <tbody>
                @forelse ($daftarUser as $user)
                <tr>
                    <td>{{ $user->nama }}</td>
                    <td>{{ $user->nip }}</td>
                    <td>{{ $user->email }}</td>
                    <td style="width: 20%">
                        @forelse ($user->getUserRole(false) as $index => $role)
                        <span class="badge badge-{{ $colorlist[$index % 4] }}">{{ $role->nama }}</span>
                        @empty
                        <span>Tidak memiliki role</span>
                        @endforelse
                    </td>
                    <td>
                        <a href="{{ route('user.detail', ['user' => encrypt($user->id)]) }}" class="btn btn-primary">
                            Detail
                        </a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3">
                        <p class="alert alert-info text-center">
                            Tidak ada data.
                        </p>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>

        <div class="pl-3">
            {{ $daftarUser->links() }}
        </div>
    @endslot
@endcard

@endsection

@push('js')
<script>
    new Vue({
        el: '#root',
        data: {

        },
        methods: {
            form: function () {
                let root = document.createElement('div')
                let child = document.createElement('form-tambah-user')
                root.appendChild(child)

                swal({
                    buttons: false,
                    content: root
                })

                new Vue({
                    el: root,
                    data: {
                        roles: @json(App\Models\Role::all()),
                        url: {
                            tambah: '{{ route('user.tambah') }}'
                        }
                    }
                })
            }
        }
    })
</script>
@endpush