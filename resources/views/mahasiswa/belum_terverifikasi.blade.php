@extends('layouts.carbon.app', [
    'sidebar' => false
])

@section('title', 'Email Belum Terverifikasi | LSP Unesa')

@section('content')
@card()
    @slot('title', 'Ups')

    @include('layouts.include.alert')

    @alert(['type' => 'warning'])
        Akun ini belum terverifikasi. Silahkan buka email anda ({{ GlobalAuth::user()->email }}) dan lakukan verifikasi.
    @endalert

    <h4>Alamat email anda salah ?</h4>
    <p>Jika alamat anda salah atau tautan verifikasi tidak terkirim ke email anda, silahkan mengubah atau mengirim ulang email verifikasi.</p>
    <form action="{{ route('email.kirim.ulang') }}" method="post">
        @csrf

        <div class="row">
            <div class="col-lg-5">
                <div class="input-group">
                    <input type="email" name="email" id="email" class="form-control" value="{{ GlobalAuth::user()->email }}" />
                    <button class="btn btn-primary">Kirim ulang link verifikasi</button>
                </div>
            </div>
        </div>

    </form>
@endcard
@endsection