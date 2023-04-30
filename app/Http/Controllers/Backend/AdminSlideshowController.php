<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Photo;
use Illuminate\Http\Request;

class AdminSlideshowController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'slideshow']);
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
            $slideshows = Photo::onlyTrashed()->where("name", "LIKE", "%{$keyword}%")->where('type', 'slideshow')->orderBy('id', 'ASC')->paginate(10);
            // return $slideshows;
        } else {
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $slideshows = Photo::where("name", "LIKE", "%{$keyword}%")->where('type', 'slideshow')->orderBy('id', 'ASC')->paginate(10);
        }
        $countSlideshowActive = Photo::count();
        $countSlideshowTrash = Photo::onlyTrashed()->count();
        $countSlideshow = [$countSlideshowActive, $countSlideshowTrash];
        return view('admin.slideshow.index', compact('slideshows', 'countSlideshow', 'act'));
    }


    public function create()
    {
        return view('admin.slideshow.create');
    }


    public function store(Request $request, $id = '')
    {
        if (empty($id)) {
            $request->validate(
                [
                    "name" => ["required", "string", "max:255"],
                    "link" => ["required", "string", "max:255"],
                ],
                [
                    'required' => ':attribute không được để trống',
                    'string' => ':attribute phải ở dạng chuỗi ký tự',
                    'max' => ':attribute chỉ cho phép nhập vào tối đa là :max ký tự',
                ],
                [
                    'name' => 'Tiêu đề',
                    'link' => 'Tên đường dẫn',
                ]
            );
            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/slideshow/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/slideshow/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = 'public/backend/uploads/' . $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            Photo::create(
                [
                    "name" => $request->name,
                    "link" => $request->link,
                    "photo" => $photo,
                    "type" => 'slideshow',
                    "status" => 'active',
                ]
            );
            return redirect('admin/slideshow/create')->with('success', 'Thêm dữ liệu thành công');
        }


        if (!empty($id)) {
            if ($request->hasFile('photo')) {
                $file = $request->photo;
                $nameFile = $file->getClientOriginalName();
                $typeFile = $file->getClientOriginalExtension();
                $sizeFile = $file->getSize();
                $typeAllow = ['jpg', 'jpeg', 'png', 'webp', 'gif'];
                if (!in_array(strtolower($typeFile), $typeAllow)) {
                    return redirect('admin/slideshow/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/slideshow/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file->move('public/backend/uploads', $nameFile);
                        $photo = 'public/backend/uploads/' . $nameFile;
                    }
                }
            } else {
                $photo = "";
            }

            Photo::find($id)->update(
                [
                    "name" => $request->name,
                    "link" => $request->link,
                    "photo" => $photo,
                ]
            );
            return redirect("admin/slideshow/edit/{$id}")->with('success', 'Cập nhật dữ liệu thành công');
        }
    }


    public function copy($id)
    {
        if (!empty($id)) {

            $slideshowById = Photo::find($id);
            $num = rand(1, 10);

            Photo::create(
                [
                    "name" => $slideshowById->name . "({$num})",
                    "link" => $slideshowById->link,
                    "photo" => $slideshowById->photo,
                    "type" => 'slideshow',
                    "status" => 'active',
                ]
            );
            return redirect("admin/slideshow/index")->with('success', 'Sao chép dữ liệu thành công');
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
                        Photo::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'active']);
                        Photo::withTrashed()->whereIn('id', $listCheckbox)->restore();
                        return redirect('admin/slideshow/index')->with('success', 'Khôi phục dữ liệu thành công');
                        break;


                    case 'delete':
                        Photo::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'trash']);
                        Photo::destroy($listCheckbox);
                        return redirect('admin/slideshow/index')->with('success', 'Xóa dữ liệu thành công');
                        break;


                    case 'force_delete':
                        Photo::withTrashed()->whereIn('id', $listCheckbox)->forceDelete();
                        return redirect('admin/slideshow/index')->with('success', 'Xóa vĩnh viễn dữ liệu thành công');
                        break;

                    default:
                        break;
                }
            }
        }
    }

    public function edit($id)
    {
        $slideshowById = Photo::find($id);
        return view("admin.slideshow.edit", compact("slideshowById"));
    }

    public function delete($id)
    {
        $slideshowById = Photo::find($id);
        $slideshowById->update(['status' => 'trash']);
        $slideshowById->delete();
        return redirect('admin/slideshow/index')->with('success', 'Xóa slide thành công');
    }
}
