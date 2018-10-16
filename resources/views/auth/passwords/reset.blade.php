@extends('layouts.carbon.app', [
    'sidebar' => false
])

@section('title', 'Reset Kata Sandi')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Reset Kata Sandi</div>

                <div class="card-body">

                    @include('layouts.include.alert')

                    <form method="POST" action="{{ route('reset.kata.sandi') }}" aria-label="Reset Kata Sandi">
                        @csrf

                        <div class="form-group row">
                            <label for="email" class="col-md-4 col-form-label text-md-right">Alamat email</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ $email ?? old('email') }}" required autofocus>

                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <p class="alert alert-warning">
                            Kata sandi baru akan dikirim ke email anda.
                        </p>

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn btn-primary">
                                    Reset Kata Sandi
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
