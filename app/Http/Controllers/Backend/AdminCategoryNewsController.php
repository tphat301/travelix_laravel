<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use Illuminate\Http\Request;

class AdminCategoryNewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'category_news']);
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $keyword = '';
        $act = ['delete' => 'Xóa tạm thời'];
        $status = $request->input('status');
        if ($status === 'trash') {
            $act = ['restore' => 'Khôi phục', 'force_delete' => 'Xóa vĩnh viễn'];
            $categoryNews = CategoryPost::onlyTrashed()->where("name", "LIKE", "%{$keyword}%")->paginate(10);
        } else {
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $categoryNews = CategoryPost::where('status', 'active')->where("name", "LIKE", "%{$keyword}%")->paginate(10);
        }

        $countCategoryNewsActive = CategoryPost::count();
        $countCategoryNewsTrash = CategoryPost::onlyTrashed()->count();
        $countCategoryNews = [$countCategoryNewsActive, $countCategoryNewsTrash];
        return view("admin.category_news.index", compact("categoryNews", "countCategoryNews", "act"));
    }


    public function create()
    {
        return view('admin.category_news.create');
    }


    public function edit($id)
    {
        $categoryNewsLevel1 = CategoryPost::where('status', 'active')->where('type', 'tin-tuc')->where('level', 1)->where('id', $id)->first();
        return view('admin.category_news.edit', compact('categoryNewsLevel1'));
    }


    public function store(Request $request, $id = '')
    {
        if (empty($id)) {
            $request->validate(
                [
                    "name" => ["required", "string", "max:255"],
                    "slug" => ["required", "string", "max:255"],
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute phải ở dạng chuỗi ký tự',
                    'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                ],
                [
                    'name' => 'Tiêu đề',
                    'slug' => 'Tên đường dẫn',
                ]
            );


            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/category_news/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/category_news/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            CategoryPost::create(
                [
                    "parent_id" => 0,
                    "level" => 1,
                    "name" => !empty($request->name) ? $request->name : '',
                    "slug" => !empty($request->slug) ? $request->slug : '',
                    "slogan" => !empty($request->slogan) ? $request->slogan : '',
                    "photo" => !empty($photo) ? $photo : '',
                    "photo1" => !empty($photo1) ? $photo1 : '',
                    "photo2" => !empty($photo2) ? $photo2 : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "options" => !empty($request->options) ? $request->options : '',
                    "type" => 'tin-tuc',
                    "status" => 'active',
                ]
            );
            return redirect('admin/category_news/index')->with('success', 'Thêm dữ liệu thành công');
        }

        if (!empty($id)) {
            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/category_news/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/category_news/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            CategoryPost::find($id)->update(
                [
                    "name" => !empty($request->name) ? $request->name : '',
                    "slug" => !empty($request->slug) ? $request->slug : '',
                    "slogan" => !empty($request->slogan) ? $request->slogan : '',
                    "photo" => !empty($photo) ? $photo : '',
                    "photo1" => !empty($photo1) ? $photo1 : '',
                    "photo2" => !empty($photo2) ? $photo2 : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "options" => !empty($request->options) ? $request->options : '',
                ]
            );
            return redirect('admin/category_news/edit/' . $id)->with('success', 'Thêm dữ liệu thành công');
        }
    }


    public function action(Request $request)
    {
        $listCheckbox = $request->input('check__item');
        if ($listCheckbox) {

            if (!empty($listCheckbox)) {
                $act = $request->input('act');

                switch ($act) {
                    case 'restore':
                        CategoryPost::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'active']);
                        CategoryPost::withTrashed()->whereIn('id', $listCheckbox)->restore();
                        return redirect('admin/category_news/index')->with('success', 'Khôi phục danh mục thành công');
                        break;

                    case 'delete':
                        CategoryPost::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'trash']);
                        CategoryPost::destroy($listCheckbox);
                        return redirect('admin/category_news/index')->with('success', 'Xóa danh mục thành công');
                        break;

                    case 'force_delete':
                        CategoryPost::withTrashed()->whereIn('id', $listCheckbox)->forceDelete();
                        return redirect('admin/category_news/index')->with('success', 'Xóa vĩnh viễn danh mục thành công');
                        break;

                    default:
                        break;
                }
            }
        }
    }


    public function delete($id)
    {
        $categoryNewsById = CategoryPost::find($id);
        $categoryNewsById->update(['status' => 'trash']);
        $categoryNewsById->delete();
        return redirect('admin/category_news/index')->with('success', 'Xóa dữ liệu thành công');
    }


    public function state(Request $request)
    {
        $id = $request->input('id');
        $show = $request->input('show');
        CategoryPost::find($id)->update(['state' => $show]);
    }

    public function remove_state(Request $request)
    {
        $id = $request->input('id');
        CategoryPost::find($id)->update(['state' => null]);
    }

    public function create_level2()
    {
        return view('admin.category_news2.create');
    }

    public function edit_level2($id)
    {
        $categoryNewsLevel1 = CategoryPost::where('status', 'active')->where('type', 'tin-tuc')->where('level', 1)->get();
        $categoryNewsLevel2ById = CategoryPost::where('status', 'active')->where('type', 'tin-tuc')->where('level', 2)->where('id', $id)->first();
        return view('admin.category_news2.edit', compact('categoryNewsLevel1', 'categoryNewsLevel2ById'));
    }

    public function store_level2(Request $request, $id = '')
    {
        if (empty($id)) {
            $request->validate(
                [
                    "name" => ["required", "string", "max:255"],
                    "slug" => ["required", "string", "max:255"],
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute phải ở dạng chuỗi ký tự',
                    'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                ],
                [
                    'name' => 'Tiêu đề',
                    'slug' => 'Tên đường dẫn',
                ]
            );

            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/category_news/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/category_news/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            CategoryPost::create(
                [
                    "parent_id" => '',
                    "level" => 2,
                    "name" => !empty($request->name) ? $request->name : '',
                    "slug" => !empty($request->slug) ? $request->slug : '',
                    "slogan" => !empty($request->slogan) ? $request->slogan : '',
                    "photo" => !empty($photo) ? $photo : '',
                    "photo1" => !empty($photo1) ? $photo1 : '',
                    "photo2" => !empty($photo2) ? $photo2 : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "options" => !empty($request->options) ? $request->options : '',
                    "type" => 'tin-tuc',
                    "status" => 'active',
                ]
            );
            return redirect('admin/category_news/index')->with('success', 'Thêm dữ liệu thành công');
        }

        if (!empty($id)) {
            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/category_news/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/category_news/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            CategoryPost::find($id)->update(
                [
                    "parent_id" => !empty($request->parent_id) ? $request->parent_id : '',
                    "name" => !empty($request->name) ? $request->name : '',
                    "slug" => !empty($request->slug) ? $request->slug : '',
                    "slogan" => !empty($request->slogan) ? $request->slogan : '',
                    "photo" => !empty($photo) ? $photo : '',
                    "photo1" => !empty($photo1) ? $photo1 : '',
                    "photo2" => !empty($photo2) ? $photo2 : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "options" => !empty($request->options) ? $request->options : ''
                ]
            );
            return redirect('admin/category_news2/edit/' . $id)->with('success', 'Thêm dữ liệu thành công');
        }
    }
}
