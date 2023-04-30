<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Photo;
use App\Models\Service;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    // public function index(Request $request)
    // {
    //     $services = Service::all();
    //     if ($request->session()->get('status') === 'Đặt hàng thành công') {
    //         $request->session()->flush();
    //     }
    //     return view("home.index", compact("services"));
    // }


    public function index()
    {
        $slideshows = Photo::where('type', 'slideshow')->orderBy('id', 'ASC')->get();
        $slogan = Page::where('type', 'slogan')->where('status', 'active')->select('slogan')->first();
        $services = Service::where("type", "dich-vu")->where('status', 'active')->where('state', 'noibat')->orderBy('id', 'ASC')->get();
        // return $services;
        return view('home.index', compact('slideshows', 'slogan', 'services'));
    }
}
