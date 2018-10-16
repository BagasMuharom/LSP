<!-- BEGIN PRE-FOOTER -->
<div class="pre-footer">
    <div class="container">
        <div class="row">
            <!-- BEGIN BOTTOM ABOUT BLOCK -->
            <div class="col-md-4 col-sm-6 pre-footer-col">
                <h2>Tentang Kami</h2>
                <p>{{ kustomisasi('profil_singkat') }} ...</p>
                <a href="{{ route('profil.profil') }}">Lihat Selengkapnya</a>
                
            </div>
            <!-- END BOTTOM ABOUT BLOCK -->

            <!-- BEGIN BOTTOM CONTACTS -->
            <div class="col-md-4 col-sm-6 pre-footer-col">
                <h2>Kontak</h2>
                <address class="margin-bottom-40">
                    {{ kustomisasi('alamat') }}
                    <br> Telp: {{ kustomisasi('no_telp') }}
                    <br> Email:
                    <a href="{{ kustomisasi('email') }}">{{ kustomisasi('email') }}</a>
                </address>
            </div>
            <!-- END BOTTOM CONTACTS -->

            <!-- BEGIN TWITTER BLOCK -->
            <div class="col-md-4 col-sm-6 pre-footer-col">
                <div class="photo-stream">
                    <h2>Galeri</h2>
                    <ul class="list-unstyled">
                        @foreach (App\Models\Foto::where('galeri_id', '!=', App\Models\Galeri::where('nama', 'Carousel')->first()->id)->limit(15)->get() as $foto)
                        <li>
                            <a href="{{ route('profil.galeri') }}">
                                <img alt="" src="{{ asset($foto->dir) }}">
                            </a>
                        </li>
                        @endforeach
                    </ul>                    
                </div>
            </div>
            <!-- END TWITTER BLOCK -->
        </div>
    </div>
</div>
<!-- END PRE-FOOTER -->

<!-- BEGIN FOOTER -->
<div class="footer">
    <div class="container">
        <div class="row">
            <!-- BEGIN COPYRIGHT -->
            <div class="col-md-4 col-sm-4 padding-top-10">
                {{ Carbon\Carbon::now()->year }} © LSP Unesa.
            </div>
            <!-- END COPYRIGHT -->
        </div>
    </div>
</div>
<!-- END FOOTER -->