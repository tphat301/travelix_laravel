<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\Post;

class NewsController extends Controller
{
    public function index()
    {
        $news = Post::where("type", "tin-tuc")->where('status', 'active')->where('state', 'noibat')->orderBy('id', 'ASC')->get();
        return view('news.index', compact('news'));
    }

    public function show($slug)
    {
        if(!empty($slug)) {

            if(!empty(CategoryPost::where(['status'=> 'active','type'=>'tin-tuc','level'=> 1,'slug'=> $slug])->first())) 
            {
                $parent_id1 = CategoryPost::where(['status' => 'active', 'type'=>'tin-tuc', 'level'=> 1, 'slug'=> $slug])->first()->id;
                $newsBySlug = Post::where(['type'=>'tin-tuc', 'status'=>'active', 'parent_id1'=>$parent_id1])->paginate(20);
                if($newsBySlug->total() == 1) {
                    $newsBySlug = Post::where(['type'=>'tin-tuc', 'status'=>'active', 'parent_id1'=>$parent_id1])->first();
                    return view('news.show', compact('newsBySlug'));
                }
                return view('news.cat_index', compact('newsBySlug'));
            }

            if(!empty(CategoryPost::where(['status' => 'active', 'type'=>'tin-tuc', 'level'=> 2, 'slug'=> $slug])->first())) 
            {
                $parent_id2 = CategoryPost::where(['status' => 'active', 'type'=>'tin-tuc', 'level'=> 2, 'slug'=> $slug])->first()->id;
                $newsBySlug = Post::where(['type'=> 'tin-tuc','status'=> 'active','parent_id2'=> $parent_id2])->paginate(20);
                if($newsBySlug->total() == 1) {
                    $newsBySlug = Post::where(['type'=> 'tin-tuc','status'=> 'active','parent_id2'=> $parent_id2])->first();
                    return view('news.show', compact('newsBySlug'));
                }
                return view('news.cat_index', compact('newsBySlug'));
            }

            if(CategoryPost::where(['status'=> 'active','type'=>'tin-tuc','level'=> 1,'slug'=> $slug])->first() == '' || CategoryPost::where(['status'=> 'active','type'=>'tin-tuc','level'=> 2,'slug'=> $slug])->first() == '' )
            {
                $newsBySlug = Post::where(['status'=> 'active','type'=> 'tin-tuc'])->first();
                return view('news.show', compact('newsBySlug'));
            }
        }               
    }
}
