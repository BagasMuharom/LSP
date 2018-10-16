<!-- BEGIN SLIDER -->
<style>
    .btn-carousel {
        position: absolute;
        bottom: 75px;
        margin: 0 auto;
        left: 0;
        right: 0;
        width: 100px;
        background-color: rgba(0,0,0,0.35);
        text-align: center;
        padding: 10px;
    }
    .btn-carousel:visited,
    .btn-carousel:link {
        color:#fff;
        text-decoration: none;
    }
    .btn-carousel:hover {
        color:#fff;
        text-decoration: underline;
    }
</style>
<div class="page-slider">
    <div id="carousel-example-generic" class="carousel slide carousel-slider">
        <!-- Indicators -->
        <ol class="carousel-indicators carousel-indicators-frontend">
            @foreach ($daftarCarousel as $carousel)
            <li data-target="#carousel-example-generic" data-slide-to="{{ $loop->index }}" class="{{ $loop->first ? 'active' : '' }}"></li>
            @endforeach
        </ol>

        <!-- Wrapper for slides -->
        <div class="carousel-inner" role="listbox">
            @foreach ($daftarCarousel as $carousel)            
            <div class="item carousel-item {{ $loop->first ? 'active' : '' }}" style="background-image: url('{{ asset($carousel->dir) }}')">
                <div class="container">
                    @if (!is_null($carousel->keterangan))
                    <a href="{{ $carousel->keterangan }}" class="btn-carousel">Lihat Detail</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>

        <!-- Controls -->
        <a class="left carousel-control carousel-control-shop carousel-control-frontend" href="#carousel-example-generic" role="button"
            data-slide="prev">
            <i class="fa fa-angle-left" aria-hidden="true"></i>
        </a>
        <a id="controls-right" class="right carousel-control carousel-control-shop carousel-control-frontend" href="#carousel-example-generic" role="button"
            data-slide="next">
            <i class="fa fa-angle-right" aria-hidden="true"></i>
        </a>
    </div>
</div>
<!-- END SLIDER -->