<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        // $categoryLevel1 = CategoryService::where('state', 'noibat')->where('status', 'active')->where('level', 1)->get();
        // $categoryLevel2 = CategoryService::where('state', 'noibat')->where('status', 'active')->where('level', 2)->get();
        // return $categoryLevel2;
        $services = Service::where("type", "dich-vu")->where('status', 'active')->where('state', 'noibat')->orderBy('id', 'ASC')->get();
        return view('service.index', compact('services'));
    }

    public function show($slug)
    {
        $serviceBySlug = Service::where("type", "dich-vu")->where("slug", $slug)->where('status', 'active')->first();
        return view('service.show', compact('serviceBySlug'));
    }
}
