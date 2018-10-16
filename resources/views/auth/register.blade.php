@extends('layouts.carbon.app', [
    'sidebar' => false
])

@section('title', 'Daftar | LSP Unesa')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @card(['title' => 'Pendaftaran Akun'])
                @include('layouts.include.alert')

                <form method="POST" action="{{ route('register') }}">
                    
                    @csrf

                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">NIM</label>

                        <div class="col-md-6">
                            <input id="nim" type="text" class="form-control{{ $errors->has('nim') ? ' is-invalid' : '' }}" name="nim" value="{{ old('nim') }}" required autofocus>

                            @if ($errors->has('nim'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nim') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="name" class="col-md-4 col-form-label text-md-right">NIK</label>

                        <div class="col-md-6">
                            <input id="nik" type="text" class="form-control{{ $errors->has('nik') ? ' is-invalid' : '' }}" name="nik" value="{{ old('nik') }}" required autofocus>

                            @if ($errors->has('nik'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('nik') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="email" class="col-md-4 col-form-label text-md-right">Alamat email</label>

                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                            @if ($errors->has('email'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label for="no_telepon" class="col-md-4 col-form-label text-md-right">No. Telepon</label>

                        <div class="col-md-6">
                            <input id="no_telepon" type="text" class="form-control{{ $errors->has('no_telepon') ? ' is-invalid' : '' }}" name="no_telepon" value="{{ old('no_telepon') }}" required>

                            @if ($errors->has('no_telepon'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('no_telepon') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-md-4 col-form-label text-md-right">Kata sandi</label>

                        <div class="col-md-6">
                            <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                            @if ($errors->has('password'))
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                            @endif
                        </div>
                    </div>

                    

                    <div class="form-group row">
                        <label for="password-confirm" class="col-md-4 col-form-label text-md-right">Konfirmasi kata sandi</label>

                        <div class="col-md-6">
                            <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                        </div>
                    </div>

                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                Daftar
                            </button>
                        </div>
                    </div>
                </form>
            @endcard
        </div>
    </div>
</div>
@endsection
