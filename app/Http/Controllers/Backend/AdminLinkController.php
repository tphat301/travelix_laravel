<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class AdminLinkController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(["module_active" => "link"]);
            return $next($request);
        });
    }


    public function index()
    {
        $links = Page::where('status', 'active')->where('type', 'link')->paginate(20);
        return view('admin.link.index', compact('links'));
    }


    public function create()
    {
        return view('admin.link.create');
    }

    public function store(Request $request, $id = "")
    {
        if (empty($id)) {
            $request->validate(
                [
                    "link" => ["required", "string", "max:255"]
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute phải ở dạng chuỗi ký tự',
                    'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                ],
                [
                    'link' => 'Link',
                ]
            );
            Page::create(
                [
                    "name" => $request->link,
                    "type" => 'link',
                    "status" => 'active',
                ]
            );
            return redirect("admin/link/index")->with('success', 'Thêm dữ liệu thành công');
        }

        if (!empty($id)) {
            Page::find($id)->update(
                [
                    "name" => $request->link,
                    "slug" => $request->slug,
                ]
            );
            return redirect("admin/link/index")->with('success', 'Thêm dữ liệu thành công');
        }
    }


    public function edit($id)
    {
        $linkById = Page::where('type', 'link')->where('id', $id)->first();
        return view("admin.link.edit", compact("linkById"));
    }

    public function delete($id)
    {
        Page::where('id', $id)->forceDelete();
        return redirect('admin/link/index')->with('success', 'Xóa dữ liệu thành công');
    }
}
