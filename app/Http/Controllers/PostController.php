<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\Facades\GlobalAuth;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth:user', 'menu:blog']);
    }

    public function tinymceUpload(Request $request)
    {
        $image = $request->file('image');

        if (($image->getSize() / 1024) > 1024)
            return "<script>alert('Ukuran maksimal file 1MB untuk post!')</script>";

        $filename = 'image_'.time().'_'.$image->hashName();
        $image = $image->move(public_path('images/bantuan'), $filename);
        return ('
            <script>
            top.$(".mce-btn.mce-open").parent().find(".mce-textbox").val("'.asset('images/bantuan/'. $filename ).'").closest(".mce-window").find(".mce-primary").click();
            </script>
        ');
    }

    public function update(Request $request, Post $post)
    {
        $post->update([
            'judul' => $request->judul,
            'permalink' => Post::generatePermalink($request->judul),
            'isi' => $request->isi,
            'penulis_id' => GlobalAuth::user()->id
        ]);

        return back()->with('success', 'Berhasil memperbarui post');
    }

    /**
     * @param Post $post
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(Post $post)
    {
        $post->delete();
        return back()->with('success', 'Berhasil menghapus post yang berjudul '.$post->judul);
    }

    public function add(Request $request)
    {
        $this->validate($request, [
            'judul' => 'required',
            'isi' => 'required'
        ]);

        try{
            $post = Post::create([
                'judul' => $request->judul,
                'permalink' => Post::generatePermalink($request->judul),
                'isi' => $request->isi,
                'penulis_id' => GlobalAuth::user()->id
            ]);

            return redirect()->route('blog');
        }
        catch (QueryException $exception){
            return back()->with('error', 'Terdapat duplikasi permalink<br>'.$exception->getMessage());
        }
    }
    
}
