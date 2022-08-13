<?php

namespace Modules\Site\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Blog\Entities\News;

class SiteController extends Controller
{
    public function index()
    {
        return view('app', [
            'posts' => News::all()
        ]);
    }
}
