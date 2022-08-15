<?php

namespace Modules\Blog\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\News;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        return view('blog::index', [
            'posts' => News::all()
        ]);
    }

    public function post($url)
    {
        $post = News::query()->where('url', '=', $url)->first();

        return view('blog::post', [
            'post' => $post
        ]);
    }
}
