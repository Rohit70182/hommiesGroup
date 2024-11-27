<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;

class SitemapXmlController extends Controller
{
    public function index() 
    {
        try{
            $posts = Blog::all();
            return response()->view('index', [
                'posts' => $posts
            ])->header('Content-Type', 'text/xml');
        }catch (Exception $e) {     
            return redirect()->back()->with($e->getMessage());
        }
    }
}
