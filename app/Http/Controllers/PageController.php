<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\App;

class PageController extends Controller
{
    public function index(){
        $posts = Post::search()
            ->latest("id")
            ->paginate(10)
            ->withQueryString();

//        return $posts;
        return view('index',compact('posts'));
    }

    public function detail($slug){
//        return $slug;
        $post = Post::where('slug',$slug)->firstOrFail();
        $recentPosts = Post::latest("id")->limit(5)->get();
//        return $post;
        return view('detail',compact('post','recentPosts'));

    }

    public function pdfDownload($slug){

        $post = Post::where('slug',$slug)->firstOrFail();

        $pdf = App::make('dompdf.wrapper');
        $pdf->loadHTML("<h1>$post->title</h1><div>$post->description</div>");
        return $pdf->stream();
    }

    public function postByCategory(Category $category){
//        return $category;
//        $category = Category::where("slug",$slug)->first();

        $posts = Post::where(function ($q){
                $q->when(request('keyword'),function($q){
                    $keyword = request('keyword');
                    $q->orWhere("title","like","%$keyword%")
                        ->orWhere("description","like","%$keyword%");
                });
            })
            ->where("category_id",$category->id)
            ->latest("id")
            ->with(['user','category'])
            ->paginate(10)
            ->withQueryString();

        return view('index',compact('posts','category'));

    }
}
