<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use App\Models\Page;
use App\Models\Photo;
use App\Models\Post;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class IndexController extends Controller
{
    public function index(Request $request)
    {
        if ($request->session()->get('status') === 'Đặt hàng thành công') {
            $request->session()->flush();
        }
        $slogan = Page::where(['type' => 'slogan', 'status' => 'active'])->select('slogan')->first();
        $services = Service::where(['type' => 'dich-vu', 'status' => 'active', 'state' => 'noibat'])->orderBy('id', 'ASC')->get();
        $news = Post::where(['type' => 'tin-tuc', 'status' => 'active', 'state' => 'noibat'])->get();
        $criteria = Post::where(['type' => 'nhan-xet', 'status' => 'active', 'state' => 'noibat'])->get();
        $path = public_path() . "/json/";
        if (!is_dir($path)) {
            mkdir($path, 0777, true);
        }

        File::put($path . 'search.json', json_encode($services));
        return view('home.index', compact('slogan', 'services', 'news', 'criteria'));
    }


    public function load_ajax(Request $request)
    {
        $parent_id2 = $request->get('parentId2');
        $services = Service::where("parent_id2", $parent_id2)->where('status', 'active')->where('state', 'noibat')->get();
        return view('home.load_ajax', compact('services'));
    }
}
