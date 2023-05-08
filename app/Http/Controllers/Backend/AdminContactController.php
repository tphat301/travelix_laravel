<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Page;
use Illuminate\Http\Request;

class AdminContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(["module_active" => "contact"]);
            return $next($request);
        });
    }


    public function index()
    {
        $contact = Page::where(['status' => 'active', 'type' => 'lien-he'])->first();
        return view('admin.contact.index', compact('contact'));
    }


    public function create()
    {
        if (Page::where(['status' => 'active', 'type' => 'lien-he'])->first()) {
            return redirect('admin/contact/index');
        } else {
            return view('admin.contact.create');
        }
    }

    public function store(Request $request, $id = "")
    {
        if (empty($id)) {
            $request->validate(
                [
                    "name" => ["required", "string", "max:255"]
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute phải ở dạng chuỗi ký tự',
                    'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                ],
                [
                    'name' => 'Tiêu đề',
                ]
            );
            Page::create(
                [
                    "name" => !empty($request->name) ? $request->name : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "type" => 'lien-he',
                    "status" => 'active',
                ]
            );
            return redirect("admin/contact/index")->with('success', 'Thêm dữ liệu thành công');
        }

        if (!empty($id)) {
            Page::find($id)->update(
                [
                    "name" => !empty($request->name) ? $request->name : '',
                    "content" => !empty($request->content) ? $request->content : '',
                ]
            );
            return redirect("admin/contact/index")->with('success', 'Thêm dữ liệu thành công');
        }
    }


    public function edit($id)
    {
        $contactById = Page::where('type', 'lien-he')->where('id', $id)->first();
        return view('admin.contact.edit', compact('contactById'));
    }
}
