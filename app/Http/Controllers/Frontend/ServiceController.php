<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index($slug)
    {
        if ($slug !== 'dich-vu') {
            if (CategoryService::where('status', 'active')->where('state', 'noibat')->where('level', 1)->where('slug', $slug)->first()) {
                $parent_id1 = CategoryService::where('status', 'active')->where('state', 'noibat')->where('level', 1)->where('slug', $slug)->first()->id;
                $services = Service::where('status', 'active')->where('state', 'noibat')->where('parent_id1', $parent_id1)->orderBy('id', 'ASC')->get();
            }
            if (CategoryService::where('status', 'active')->where('state', 'noibat')->where('level', 2)->where('slug', $slug)->first()) {
                $parent_id2 = CategoryService::where('status', 'active')->where('state', 'noibat')->where('level', 2)->where('slug', $slug)->first()->id;
                $services = Service::where('status', 'active')->where('state', 'noibat')->where('parent_id2', $parent_id2)->orderBy('id', 'ASC')->get();
            }
        }

        if ($slug == 'dich-vu') {
            $services = Service::where("type", $slug)->where('status', 'active')->where('state', 'noibat')->orderBy('id', 'ASC')->get();
        }

        return view('service.index', compact('services'));
    }

    public function show($slug)
    {
        $serviceBySlug = Service::where("type", "dich-vu")->where("slug", $slug)->where('status', 'active')->first();
        return view('service.show', compact('serviceBySlug'));
    }
}
