<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryService;
use App\Models\Gallery;
use App\Models\Service;
use Illuminate\Http\Request;

class AdminServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(["module_active" => "service"]);
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
            $services = Service::onlyTrashed()->where("name", "LIKE", "%{$keyword}%")->paginate(10);
        } else {
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $services = Service::where("name", "LIKE", "%{$keyword}%")->paginate(10);
        }
        $countServiceActive = Service::count();
        $countServiceTrash = Service::onlyTrashed()->count();
        $countService = [$countServiceActive, $countServiceTrash];
        return view("admin.service.index", compact("services", "countService", "act"));
    }

    public function create()
    {
        return view('admin.service.create');
    }


    public function store(Request $request, $id = "")
    {
        if (empty($id)) {
            $request->validate(
                [
                    "name" => ["required", "string", "max:255"],
                    "slug" => ["required", "string", "max:255"],
                    "brand" => ["required", "string", "max:255"],
                    "price" => ["required"],
                    "price_old" => ["required"],
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute phải ở dạng chuỗi ký tự',
                    'min' => ':attribute nhập vào phải có ít nhất là :min ký tự',
                    'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                ],
                [
                    'name' => 'Tên dịch vụ',
                    'slug' => 'Tên đường dẫn',
                    'brand' => 'Thương hiệu',
                    'price' => 'Giá tiền',
                    'price_old' => 'Giá cũ',
                ]
            );
            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/service/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/service/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            if ($request->hasFile('photo1')) {
                $file1 = $request->photo1;
                $nameFile1 = $file1->getClientOriginalName();
                $typeFile1 = $file1->getClientOriginalExtension();
                $sizeFile1 = $file1->getSize();
                $typeAllow1 = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile1), $typeAllow1)) {
                    return redirect('admin/service/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile1 > 26214400) {
                        return redirect('admin/service/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file1->move('public/backend/uploads', $nameFile1);
                        $photo1 = $nameFile1;
                    }
                }
            } else {
                $photo1 = "";
            }

            if ($request->hasFile('photo2')) {
                $file2 = $request->photo2;
                $nameFile2 = $file2->getClientOriginalName();
                $typeFile2 = $file2->getClientOriginalExtension();
                $sizeFile2 = $file2->getSize();
                $typeAllow2 = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile2), $typeAllow2)) {
                    return redirect('admin/service/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile2 > 26214400) {
                        return redirect('admin/service/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file2->move('public/backend/uploads', $nameFile2);
                        $photo2 = $nameFile2;
                    }
                }
            } else {
                $photo2 = "";
            }

            // Gallery
            if ($request->hasFile('gallery')) {
                $galleryTypeAllows = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                foreach ($request->gallery as $gallery) {
                    $galleryName = time() . rand(1, 50) . "." . $gallery->extension();
                    $galleryType = $gallery->getClientOriginalExtension();
                    $gallerySize = $gallery->getSize();


                    if (in_array(strtolower($galleryType), $galleryTypeAllows) && $gallerySize <= 26214400) {
                        Gallery::create(
                            [
                                'photo' => $galleryName,
                                'name' => $request->name,
                                "type" => $request->type_hidden,
                                "status" => 'active',
                            ]
                        );
                        $gallery->move('public/backend/uploads', $galleryName);
                    } else {
                        return redirect('admin/service/create')->with('danger', 'Album ảnh tải lên chưa đúng định dạng hoặc vượt quá 25MB');
                    }
                }
            }
            Service::create(
                [
                    "name" => $request->name,
                    "photo" => $photo,
                    "photo1" => $photo1,
                    "photo2" => $photo2,
                    "qty" => $request->qty,
                    "slug" => $request->slug,
                    "code" => $request->code,
                    "desc" => $request->desc,
                    "content" => $request->content,
                    "price" => $request->price,
                    "price_old" => $request->price_old,
                    "discount" => $request->discount,
                    "brand" => $request->brand,
                    "type" => 'dich-vu',
                    "status" => 'active',
                ]
            );
            return redirect('admin/service/create')->with('success', 'Thêm dữ liệu thành công');
        }


        if (!empty($id)) {
            $request->validate(
                [
                    "name" => ["required", "string", "max:255"],
                    "slug" => ["required", "string", "max:255"],
                    "brand" => ["required", "string", "max:255"],
                    "price" => ["required"],
                    "price_old" => ["required"],
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute phải ở dạng chuỗi ký tự',
                    'min' => ':attribute nhập vào phải có ít nhất là :min ký tự',
                    'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                ],
                [
                    'name' => 'Tên dịch vụ',
                    'slug' => 'Tên đường dẫn',
                    'brand' => 'Thương hiệu',
                    'price' => 'Giá tiền',
                    'price_old' => 'Giá cũ',
                ]
            );

            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect("admin/service/edit/{$id}")->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect("admin/service/edit/{$id}")->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            if ($request->hasFile('photo1')) {
                $file1 = $request->photo1;
                $nameFile1 = $file1->getClientOriginalName();
                $typeFile1 = $file1->getClientOriginalExtension();
                $sizeFile1 = $file1->getSize();
                $typeAllow1 = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile1), $typeAllow1)) {
                    return redirect("admin/service/edit/{$id}")->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile1 > 26214400) {
                        return redirect("admin/service/edit/{$id}")->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file1->move('public/backend/uploads', $nameFile1);
                        $photo1 = $nameFile1;
                    }
                }
            } else {
                $photo1 = "";
            }

            if ($request->hasFile('photo2')) {
                $file2 = $request->photo2;
                $nameFile2 = $file2->getClientOriginalName();
                $typeFile2 = $file2->getClientOriginalExtension();
                $sizeFile2 = $file2->getSize();
                $typeAllow2 = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile2), $typeAllow2)) {
                    return redirect("admin/service/edit/{$id}")->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile2 > 26214400) {
                        return redirect("admin/service/edit/{$id}")->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file2->move('public/backend/uploads', $nameFile2);
                        $photo2 = $nameFile2;
                    }
                }
            } else {
                $photo2 = "";
            }

            Service::find($id)->update(
                [
                    "name" => !empty($request->name) ? $request->name : '',
                    "parent_id1" => !empty($request->parent_id1) ? $request->parent_id1 : '',
                    "parent_id2" => !empty($request->parent_id2) ? $request->parent_id2 : '',
                    "parent_id3" => !empty($request->parent_id3) ? $request->parent_id3 : '',
                    "parent_id4" => !empty($request->parent_id4) ? $request->parent_id4 : '',
                    "photo" => !empty($photo) ? $photo : '',
                    "photo1" => !empty($photo1) ? $photo1 : '',
                    "photo2" => !empty($photo2) ? $photo2 : '',
                    "slug" => !empty($request->slug) ? $request->slug : '',
                    "code" => !empty($request->code) ? $request->code : '',
                    "qty" => !empty($request->qty) ? $request->qty : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "price" => !empty($request->price) ? $request->price : '',
                    "price_old" => !empty($request->price_old) ? $request->price_old : '',
                    "discount" => !empty($request->discount) ? $request->discount : '',
                    "brand" => !empty($request->brand) ? $request->brand : '',
                    "type" => 'dich-vu',
                ]
            );
            return redirect("admin/service/edit/{$id}")->with('success', 'Cập nhật dữ liệu thành công');
        }
    }

    public function copy($id)
    {
        if (!empty($id)) {

            $serviceById = Service::find($id);
            $num = rand(1, 10);
            $serviceById->photo !== null ? $photo = $serviceById->photo : $photo = '';
            $serviceById->photo1 !== null ? $photo1 = $serviceById->photo1 : $photo1 = '';
            $serviceById->photo2 !== null ? $photo2 = $serviceById->photo2 : $photo2 = '';
            $serviceById->desc !== null ? $desc = $serviceById->desc : $desc = '';
            $serviceById->content !== null ? $content = $serviceById->content : $content = '';
            $serviceById->brand !== null ? $brand = $serviceById->brand : $brand = '';
            $serviceById->price !== null ? $price = $serviceById->price : $price = '';
            $serviceById->price_old !== null ? $price_old = $serviceById->price_old : $price_old = '';
            $serviceById->discount !== null ? $discount = $serviceById->discount : $discount = '';

            $num = rand(1, 10);
            Service::create(
                [
                    "name" => $serviceById->name . "({$num})",
                    "photo" => $photo,
                    "photo1" => $photo1,
                    "photo2" => $photo2,
                    "qty" => $serviceById->qty,
                    "slug" => $serviceById->slug,
                    "code" => $serviceById->code,
                    "desc" => $desc,
                    "content" => $content,
                    "price" => $price,
                    "price_old" => $price_old,
                    "discount" => $discount,
                    "brand" => $brand,
                    "type" => 'dich-vu',
                    "status" => 'active',
                ]
            );
            return redirect("admin/service/index")->with('success', 'Sao chép dữ liệu thành công');
        }
    }

    public function edit($id)
    {
        $serviceById = Service::find($id);
        $categoryServiceLevel1 = CategoryService::where('status', 'active')->where('type', 'dich-vu')->where('level', 1)->get();
        $categoryServiceLevel2 = CategoryService::where('status', 'active')->where('type', 'dich-vu')->where('level', 2)->get();
        return view("admin.service.edit", compact("serviceById", "categoryServiceLevel1", "categoryServiceLevel2"));
    }

    public function edit_ajax(Request $request)
    {
        $action = $request->action;
        $id = $request->id;
        if (!empty($action)) {
            $output = '';
            if ($action == 'category1') {
                $categoryServiceLevel2 = CategoryService::where('parent_id', $id)->where('level', 2)->get();
                $output .= '<option>Chọn danh mục cấp 2</option>';
                foreach ($categoryServiceLevel2 as $v2) {
                    $output .= '<option value="' . $v2->id . '">' . $v2->name . '</option>';
                }
            }
            return $output;
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
                        Service::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'active']);
                        Service::withTrashed()->whereIn('id', $listCheckbox)->restore();
                        return redirect('admin/service/index')->with('success', 'Khôi phục dữ liệu thành công');
                        break;


                    case 'delete':
                        Service::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'trash']);
                        Service::destroy($listCheckbox);
                        return redirect('admin/service/index')->with('success', 'Xóa dữ liệu thành công');
                        break;


                    case 'force_delete':
                        Service::withTrashed()->whereIn('id', $listCheckbox)->forceDelete();
                        return redirect('admin/service/index')->with('success', 'Xóa vĩnh viễn dữ liệu thành công');
                        break;

                    default:
                        break;
                }
            }
        }
    }

    public function delete($id)
    {
        $serviceById = Service::find($id);
        $serviceById->update(['status' => 'trash']);
        $serviceById->delete();
        return redirect('admin/service/index')->with('success', 'Xóa dữ liệu thành công');
    }

    public function state(Request $request)
    {
        $id = $request->input('id');
        $show = $request->input('show');
        Service::find($id)->update(['state' => $show]);
    }

    public function remove_state(Request $request)
    {
        $id = $request->input('id');
        Service::find($id)->update(['state' => null]);
    }
}
