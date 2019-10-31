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

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif