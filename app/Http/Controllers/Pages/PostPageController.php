<?php

namespace App\Http\Controllers\Pages;

use App\Models\Menu;
use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostPageController extends Controller
{
    public function __construct()
    {
        $this->middleware([
            'auth:user',
            'menu:blog'
        ]);
    }

    public function index(Request $request)
    {
        if ($request->has('q') && !empty($request->q)){
            $data = Post::searchToEloquent($request->q);
        }
        else{
            $data = Post::orderByDesc('created_at');
        }
        return view('menu.blog.post.index', [
            'data' => $data->paginate(10)->appends($request->only('q')),
            'no' => 0,
            'q' => $request->q,
            'menu' => Menu::findByRoute(Menu::BLOG)
        ]);
    }

    public function detail(Post $post)
    {
        return view('menu.blog.post.detail', [
            'post' => $post
        ]);
    }

    public function tambah()
    {
        return view('menu.blog.post.tambah', [
            'menu' => Menu::findByRoute(Menu::BLOG)
        ]);
    }
}
