<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;

class AdminCategoryService extends Controller
{

    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'category_service']);
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
            $categoryServices = CategoryService::onlyTrashed()->where("name", "LIKE", "%{$keyword}%")->paginate(10);
        } else {
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $categoryServices = CategoryService::where("name", "LIKE", "%{$keyword}%")->paginate(10);
        }

        $countCategoryServiceActive = CategoryService::count();
        $countCategoryServiceTrash = CategoryService::onlyTrashed()->count();
        $countCategoryService = [$countCategoryServiceActive, $countCategoryServiceTrash];
        return view("admin.category_service.index", compact("categoryServices", "countCategoryService", "act"));
    }


    public function action(Request $request)
    {
        $listCheckbox = $request->input('check__item');
        if ($listCheckbox) {

            if (!empty($listCheckbox)) {
                $act = $request->input('act');

                switch ($act) {
                    case 'restore':
                        CategoryService::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'active']);
                        CategoryService::withTrashed()->whereIn('id', $listCheckbox)->restore();
                        return redirect('admin/category_service/index')->with('success', 'Khôi phục danh mục thành công');
                        break;


                    case 'delete':
                        CategoryService::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'trash']);
                        CategoryService::destroy($listCheckbox);
                        return redirect('admin/category_service/index')->with('success', 'Xóa danh mục thành công');
                        break;


                    case 'force_delete':
                        CategoryService::withTrashed()->whereIn('id', $listCheckbox)->forceDelete();
                        return redirect('admin/category_service/index')->with('success', 'Xóa vĩnh viễn danh mục thành công');
                        break;

                    default:
                        break;
                }
            }
        }
    }


    public function delete($id)
    {
        $categoryServiceById = CategoryService::find($id);
        $categoryServiceById->update(['status' => 'trash']);
        $categoryServiceById->delete();
        return redirect('admin/category_service/index')->with('success', 'Xóa dữ liệu thành công');
    }


    public function create()
    {
        return view('admin.category_service.create');
    }

    public function create_level2()
    {
        return view('admin.category_service2.create');
    }

    public function edit($id)
    {
        $categoryServiceLevel1 = CategoryService::where('status', 'active')->where('type', 'dich-vu')->where('level', 1)->where('id', $id)->first();
        return view('admin.category_service.edit', compact('categoryServiceLevel1'));
    }


    public function edit_level2($id)
    {
        $categoryServiceLevel1 = CategoryService::where('status', 'active')->where('type', 'dich-vu')->where('level', 1)->get();
        $categoryServiceLevel2ById = CategoryService::where('status', 'active')->where('type', 'dich-vu')->where('level', 2)->where('id', $id)->first();
        return view('admin.category_service2.edit', compact('categoryServiceLevel1', 'categoryServiceLevel2ById'));
    }


    public function store_level2(Request $request, $id = '')
    {
        if (empty($id)) {
            $request->validate(
                [
                    "name" => ["required", "string", "max:255"],
                    "slug" => ["required", "string", "max:255"],
                    "brand" => ["required", "string", "max:255"]
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute phải ở dạng chuỗi ký tự',
                    'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                ],
                [
                    'name' => 'Tiêu đề',
                    'slug' => 'Tên đường dẫn',
                    'brand' => 'Thương hiệu',
                ]
            );

            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/category_service/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/category_service/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            CategoryService::create(
                [
                    "parent_id" => '',
                    "level" => 2,
                    "name" => !empty($request->name) ? $request->name : '',
                    "slug" => !empty($request->slug) ? $request->slug : '',
                    "brand" => !empty($request->brand) ? $request->brand : '',
                    "photo" => !empty($photo) ? $photo : '',
                    "photo1" => !empty($photo1) ? $photo1 : '',
                    "photo2" => !empty($photo2) ? $photo2 : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "options" => !empty($request->options) ? $request->options : '',
                    "type" => 'dich-vu',
                    "status" => 'active',
                ]
            );
            return redirect('admin/category_service/index')->with('success', 'Thêm dữ liệu thành công');
        }

        if (!empty($id)) {
            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/category_service/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/category_service/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            CategoryService::find($id)->update(
                [
                    "parent_id" => !empty($request->parent_id) ? $request->parent_id : '',
                    "name" => !empty($request->name) ? $request->name : '',
                    "slug" => !empty($request->slug) ? $request->slug : '',
                    "brand" => !empty($request->brand) ? $request->brand : '',
                    "photo" => !empty($photo) ? $photo : '',
                    "photo1" => !empty($photo1) ? $photo1 : '',
                    "photo2" => !empty($photo2) ? $photo2 : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "options" => !empty($request->options) ? $request->options : ''
                ]
            );
            return redirect('admin/category_service2/edit/' . $id)->with('success', 'Thêm dữ liệu thành công');
        }
    }


    public function store(Request $request, $id = '')
    {
        if (empty($id)) {
            $request->validate(
                [
                    "name" => ["required", "string", "max:255"],
                    "slug" => ["required", "string", "max:255"],
                    "brand" => ["required", "string", "max:255"]
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute phải ở dạng chuỗi ký tự',
                    'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                ],
                [
                    'name' => 'Tiêu đề',
                    'slug' => 'Tên đường dẫn',
                    'brand' => 'Thương hiệu',
                ]
            );
            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/category_service/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/category_service/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            CategoryService::create(
                [
                    "parent_id" => 0,
                    "level" => 1,
                    "name" => !empty($request->name) ? $request->name : '',
                    "slug" => !empty($request->slug) ? $request->slug : '',
                    "brand" => !empty($request->brand) ? $request->brand : '',
                    "photo" => !empty($photo) ? $photo : '',
                    "photo1" => !empty($photo1) ? $photo1 : '',
                    "photo2" => !empty($photo2) ? $photo2 : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "options" => !empty($request->options) ? $request->options : '',
                    "type" => 'dich-vu',
                    "status" => 'active',
                ]
            );
            return redirect('admin/category_service/index')->with('success', 'Thêm dữ liệu thành công');
        }

        if (!empty($id)) {
            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/category_service/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/category_service/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            CategoryService::find($id)->update(
                [
                    "name" => !empty($request->name) ? $request->name : '',
                    "slug" => !empty($request->slug) ? $request->slug : '',
                    "brand" => !empty($request->brand) ? $request->brand : '',
                    "photo" => !empty($photo) ? $photo : '',
                    "photo1" => !empty($photo1) ? $photo1 : '',
                    "photo2" => !empty($photo2) ? $photo2 : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "options" => !empty($request->options) ? $request->options : '',
                ]
            );
            return redirect('admin/category_service/edit/' . $id)->with('success', 'Thêm dữ liệu thành công');
        }
    }

    public function state(Request $request)
    {
        $id = $request->input('id');
        $show = $request->input('show');
        CategoryService::find($id)->update(['state' => $show]);
    }

    public function remove_state(Request $request)
    {
        $id = $request->input('id');
        CategoryService::find($id)->update(['state' => null]);
    }
}
