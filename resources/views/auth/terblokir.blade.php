@extends('layouts.carbon.app', [
    'sidebar' => false
])

@section('title', 'Akun Terblokir | LSP Unesa')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header border border-top-0 border-left-0 border-right-0">
                    Akun Terblokir
                </div>

                <div class="card-body">
                    @alert(['type' => 'danger'])
                        Akun anda sedang diblokir oleh pihak LSP. Segera hubungi pihak LSP agar akun anda dapat kembali digunakan
                    @endalert
                </div>
            </div>
        </div>
    </div>
</div>
@endsection