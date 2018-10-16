@extends('layouts.carbon.app', [
    'sidebar' => false
])

@section('title', 'Tidak Diizinkan | LSP Unesa')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border border-top-0 border-left-0 border-right-0">
                    Aksi Dicekal
                </div>

                <div class="card-body">
                    @alert(['type' => 'danger'])
                        Anda tidak tidak diizinkan untuk melakukan aksi atau tindakan ini.
                    @endalert
                </div>
            </div>
        </div>
    </div>
</div>
@endsection