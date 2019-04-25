@if(session()->has('success'))
    @alert(['type' => 'success'])
        {!! session('success') !!}
    @endalert
@endif

@if(session()->has('error'))
    @alert(['type' => 'danger'])
    {!! session('error') !!}
    @endalert
@endif

@if(session()->has('warning'))
    @alert(['type' => 'warning'])
    {!! session('warning') !!}
    @endalert
@endif