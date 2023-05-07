<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::where("type", "dich-vu")->where('status', 'active')->where('state', 'noibat')->orderBy('id', 'ASC')->get();
        return view('service.index', compact('services'));
    }

    public function show($slug)
    {
        if(!empty($slug)) {

            if(!empty(CategoryService::where('status', 'active')->where('type','dich-vu')->where('level',1)->where('slug', $slug)->first())) 
            {
                $parent_id1 = CategoryService::where('status', 'active')->where('type','dich-vu')->where('level',1)->where('slug', $slug)->first()->id;
                $serviceBySlug = Service::where("type", "dich-vu")->where('status', 'active')->where('parent_id1', $parent_id1)->paginate(20);
                if($serviceBySlug->total() == 1) {
                    $serviceBySlug = Service::where("type", "dich-vu")->where('status', 'active')->where('parent_id1', $parent_id1)->first();
                    return view('service.show', compact('serviceBySlug'));
                }
                return view('service.cat_index', compact('serviceBySlug'));
            }

            if(!empty(CategoryService::where('status', 'active')->where('type','dich-vu')->where('level',2)->where('slug', $slug)->first())) 
            {
                $parent_id2 = CategoryService::where('status', 'active')->where('type','dich-vu')->where('level',2)->where('slug', $slug)->first()->id;
                $serviceBySlug = Service::where("type", "dich-vu")->where('status', 'active')->where('parent_id2', $parent_id2)->paginate(20);
                if($serviceBySlug->total() == 1) {
                    $serviceBySlug = Service::where("type", "dich-vu")->where('status', 'active')->where('parent_id2', $parent_id2)->first();
                    return view('service.show', compact('serviceBySlug'));
                }
                return view('service.cat_index', compact('serviceBySlug'));

            }

            if(CategoryService::where('status', 'active')->where('type','dich-vu')->where('level',1)->where('slug', $slug)->first() == '' || CategoryService::where('status', 'active')->where('type','dich-vu')->where('level',2)->where('slug', $slug)->first() == '' )
            {
                $serviceBySlug = Service::where('status', 'active')->where('type', 'dich-vu')->first();
                return view('service.show', compact('serviceBySlug'));
            }
        }               
    }
}
