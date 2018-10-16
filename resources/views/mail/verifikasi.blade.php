<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <style>
        html, body {
            background-color: #EFEFEF
        }
    </style>
</head>
<body>
    @card(['title' => 'Pendaftaran akun LSP Unesa'])
        Anda telah berhasil melakukan pendaftaran akun pada web LSP Unesa. Selanjutnya, anda diminta untuk melakukan verifikasi alamat email ini dengan meng-klik tombol verifikasi dibawah ini agar akun anda dapat digunakan sebagai mana mestinya.
        <br>
        <br>
        <a class="btn btn-primary btn-lg" href="{{ route('verifikasi.email', ['token' => $token]) }}">Verifikasi</a>
    @endcard
</body>
</html>