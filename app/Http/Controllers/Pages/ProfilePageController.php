<?php

namespace App\Http\Controllers\Pages;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Controllers\Controller;
use App\Models\{
    Event, Skema, Post, Galeri
};

class ProfilePageController extends Controller
{
    
    public function index()
    {
        $daftarPost = Post::orderBy('created_at', 'DESC')->limit(5)->get();
        $daftarPost = parse_post($daftarPost);
        $daftarCarousel = Galeri::where('nama', 'Carousel')->first()->getFoto(false);

        return view('profil.home', [
            'daftarPost' => $daftarPost,
            'daftarCarousel' => $daftarCarousel
        ]);
    }

    public function profil()
    {
        return view('profil.profil');
    }

    public function galeri()
    {
        $daftarGaleri = Galeri::where('nama', '!=', 'Carousel')->get();
        return view('profil.galeri', [
            'daftarGaleri' => $daftarGaleri
        ]);
    }
    
    public function fotoGaleri(Galeri $idgaleri)
    {
        return view('profil.foto_galeri', [
            'galeri' => $idgaleri,
            'daftarFoto' => $idgaleri->getFoto(false)
        ]);
    }
    
    public function berita(Request $request)
    {
        if ($request->has('q')) {
            $daftarPost = Post::searchToEloquent($request->q)->paginate(5)->appends($request->only('q'));
        }
        else {
            $daftarPost = Post::orderBy('created_at', 'DESC')->paginate(5);
        }

        $daftarPost = parse_post($daftarPost);

        return view('profil.berita', [
            'daftarPost' => $daftarPost,
            'beritaTerbaru' => getBeritaTerbaru()
        ]);
    }
    
    public function post($permalink)
    {
        try {
            $post = Post::where('permalink', $permalink)->firstOrFail();
            $post->update([
                'dilihat' => $post->dilihat++
            ]);
        }
        catch (ModelNotFoundException $e) {
            return abort(404);
        }

        return view('profil.post', [
            'post' => $post
        ]);
    }
    
    public function skemaSertifikasi()
    {
        return view('profil.skema_sertifikasi');
    }

    public function detailSkema(Skema $skema)
    {
        return view('profil.detail_skema', [
            'skema' => $skema
        ]);
    }
    
    public function kontak()
    {
        return view('profil.kontak');
    }

    public function event()
    {
        return view('profil.event', [
            'onGoing' => Event::onGoing()->get(),
            'comingSoon' => Event::comingSoon()->get()
        ]);
    }

    public function pengumuman()
    {
        return view('profil.pengumuman');
    }

}
