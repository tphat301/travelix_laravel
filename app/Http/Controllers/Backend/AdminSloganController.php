<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class AdminSloganController extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(["module_active" => "slogan"]);
            return $next($request);
        });
    }

    public function index()
    {
        $slogan = Page::where('status', 'active')->where('type', 'slogan')->first();
        return view('admin.slogan.index', compact('slogan'));
    }


    public function create()
    {
        if (Page::where(['status' => 'active', 'type' => 'slogan'])->first()) {
            return redirect('admin/slogan/index');
        } else {
            return view('admin.slogan.create');
        }
    }

    public function store(Request $request, $slug = "")
    {
        if (empty($slug)) {
            $request->validate(
                [
                    "slogan" => ["required", "string", "max:255"]
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute phải ở dạng chuỗi ký tự',
                    'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                ],
                [
                    'slogan' => 'Tiêu đề',
                ]
            );
            Page::create(
                [
                    "slogan" => $request->slogan,
                    "type" => 'slogan',
                    "slug" => $slug,
                    "status" => 'active',
                ]
            );
            return redirect("admin/slogan/index")->with('success', 'Thêm dữ liệu thành công');
        }

        if (!empty($slug)) {
            $id = Page::where('slug', $slug)->first()->id;
            Page::find($id)->update(
                [
                    "slogan" => $request->slogan,
                    "slug" => $request->slug,
                ]
            );
            return redirect("admin/slogan/index")->with('success', 'Thêm dữ liệu thành công');
        }
    }


    public function edit($slug)
    {
        $sloganBySlug = Page::where('type', 'slogan')->where('slug', $slug)->first();
        return view('admin.slogan.edit', compact('sloganBySlug'));
    }
}
