<?php

namespace App\Http\Controllers;

use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }

    public function upload(Request $request){


        //intervention image
        $newName = uniqid()."_test.".$request->file('upload')->extension();
        $img = Image::make($request->file('upload'));


        //large

        $img->resize(1000,null,fn($constraint)=>$constraint->aspectRatio());
        Storage::makeDirectory('public/1000');

        $img->save("storage/1000/$newName");

        //small
        $img->fit(500,500);
        $img->brightness(10)->contrast(10);
        $img->rotate(45);

        Storage::makeDirectory('public/500');

        $img->save("storage/500/$newName");

        // return $img->response('png');
    }

    public function test(){
        return view('test');
    }
}
