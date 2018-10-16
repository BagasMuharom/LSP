@extends('layouts.carbon.app', [
    'sidebar' => true
])

@section('title', $menu->nama.' | '.kustomisasi('nama'))

{{--@push('css')--}}
    {{--<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/css/select2.min.css" rel="stylesheet"/>--}}
{{--@endpush--}}

@section('content')
    @include('layouts.include.alert')

    @card(['title' => 'Daftar unit'])

    @alert(['type' => 'info'])
    Terdapat {{ $data->total() }} skema sesuai filter
    @endalert

    <form action="{{ url()->current() }}">
        <div class="input-group">
            <input type="text" id="input-group-2" name="q" class="form-control"
                   placeholder="Cari berdasarkan kode atau judul" value="{{ $q }}">
            <span class="input-group-btn">
                    <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search"></i> Cari
                    </button>
                </span>
        </div>
    </form>

    @slot('table')
    <table class="table table-hover">
        <thead>
        <tr>
            <th>No</th>
            <th>Kode</th>
            <th>Judul</th>
            <th>Aksi</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $unit)
            <tr>
                <th>
                    {{ ($data->currentpage() * $data->perpage()) + (++$no) - $data->perpage()  }}
                </th>
                <th>{{ $unit->kode }}</th>
                <th>{{ $unit->nama }}</th>
                <th>
                    @if(!$unit->trashed())
                        <div class="btn-group">
                            <button class="btn btn-warning btn-sm"
                                    onclick="event.preventDefault(); $(this).parent().parent().parent().next().toggle()">
                                Edit/Detail
                            </button>
                            <a href="{{ route('unit.elemen', ['id' => $eu = encrypt($unit->id)]) }}"
                               class="btn btn-info btn-sm">Lihat
                                Elemen</a>
                            <button class="btn btn-danger btn-sm"
                                    onclick="event.preventDefault();hapus('{{ $eu }}', '{{ $unit->nama }}')">Hapus
                            </button>
                        </div>
                    @else
                        <form action="{{ route('unit.restore') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ encrypt($unit->id) }}">
                            <button type="submit" class="btn btn-success btn-sm">Kembalikan Data</button>
                        </form>
                    @endif
                </th>
            </tr>
            <tr style="display: none">
                <th colspan="4">
                    @row

                    @col(['size' => 5])
                    <form action="{{ route('unit.update') }}" method="post">
                        @csrf
                        {{ method_field('patch') }}
                        <input type="hidden" name="id" value="{{ encrypt($unit->id) }}">
                        @formgroup
                        <label>Kode</label>
                        <input type="text" name="kode" value="{{ $unit->kode }}" class="form-control" required>
                        @endformgroup
                        @formgroup
                        <label>Nama</label>
                        <input type="text" name="nama" value="{{ $unit->nama }}" class="form-control" required>
                        @endformgroup
                        <button class="btn btn-success btn-sm">Simpan</button>
                    </form>
                    @endcol

                    @col(['size' => 7])
                    Skema
                    <ul>
                        @foreach($unit->getSkemaUnit(false) as $skema)
                            <li>{{ $skema->kode }}, {{ $skema->nama }}</li>
                        @endforeach
                    </ul>
                    @endcol

                    @endrow
                </th>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $data->links() }}
    @endslot
    @endcard

    <form id="hapus" action="{{ route('unit.delete') }}" method="post">
        @csrf
        {{ method_field('delete') }}
        <input type="hidden" name="id" id="id-delete">
    </form>

    {{--<select class="form-control cari"></select>--}}
@endsection

@push('js')
    {{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}
    {{--<script type="text/javascript">--}}
        {{--function initialize() {--}}
            {{--$('.cari').select2({--}}
                {{--placeholder: 'Cari berdasarkan kode atau judul skema...',--}}
                {{--ajax: {--}}
                    {{--url: '{{ route('unit.daftarskema') }}',--}}
                    {{--dataType: 'json',--}}
                    {{--delay: 250,--}}
                    {{--processResults: function (data) {--}}
                        {{--return {--}}
                            {{--results: $.map(data, function (item) {--}}
                                {{--return {--}}
                                    {{--text: item.kode + ', ' + item.nama,--}}
                                    {{--id: item.id--}}
                                {{--}--}}
                            {{--})--}}
                        {{--};--}}
                    {{--},--}}
                    {{--cache: true--}}
                {{--}--}}
            {{--});--}}
        {{--}--}}

        {{--initialize();--}}
    {{--</script>--}}
    <script>
        function hapus(id, nama) {
            swal({
                title: "Anda yakin ingin menghapus " + nama + "?",
                icon: "warning",
                buttons: true,
                dangerMode: true,
            }).then((choice) => {
                if (choice) {
                    swal('Sedang memuat. . .', {
                        buttons: false,
                        closeOnClickOutside: false
                    })
                    $('#id-delete').val(id)
                    $('#hapus').submit()
                }
            })
        }
    </script>
@endpush

{{--@push('js')--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.6-rc.0/js/select2.min.js"></script>--}}
{{--<script type="text/javascript">--}}
{{--function initialize(){--}}
{{--$('.cari').select2({--}}
{{--placeholder: 'Cari berdasarkan kode atau judul skema...',--}}
{{--ajax: {--}}
{{--url: '{{ route('unit.daftarskema') }}',--}}
{{--dataType: 'json',--}}
{{--delay: 250,--}}
{{--processResults: function (data) {--}}
{{--return {--}}
{{--results:  $.map(data, function (item) {--}}
{{--return {--}}
{{--text: item.kode + ', ' + item.nama,--}}
{{--id: item.id--}}
{{--}--}}
{{--})--}}
{{--};--}}
{{--},--}}
{{--cache: true--}}
{{--}--}}
{{--});--}}
{{--}--}}

{{--initialize();--}}

{{--function tambah(id) {--}}
{{--$(id).append('' +--}}
{{--'<tr>\n' +--}}
{{--'                                    <th>\n' +--}}
{{--'                                        <select class="cari form-control" name="skema_id[]">\n' +--}}
{{--'                                            <option value="{{ $skema->id }}">{{ $skema->kode }}, {{ $skema->nama }}</option>\n' +--}}
{{--'                                        </select>\n' +--}}
{{--'                                    </th>\n' +--}}
{{--'                                    <th>\n' +--}}
{{--'                                        <button class="btn btn-danger btn-sm" onclick="event.preventDefault(); $(this).parent().parent().remove()">Hapus</button>\n' +--}}
{{--'                                    </th>\n' +--}}
{{--'                                </tr>' +--}}
{{--'')--}}

{{--initialize();--}}
{{--}--}}

{{--</script>--}}
{{--@endpush--}}