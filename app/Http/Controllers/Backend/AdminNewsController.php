<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\CategoryPost;
use App\Models\Post;
use Illuminate\Http\Request;

class AdminNewsController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(["module_active" => "news"]);
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
            $news = Post::onlyTrashed()->where("name", "LIKE", "%{$keyword}%")->paginate(10);
        } else {
            if ($request->input('keyword')) {
                $keyword = $request->input('keyword');
            }
            $news = Post::where("name", "LIKE", "%{$keyword}%")->paginate(10);
        }
        $countNewActive = Post::count();
        $countNewTrash = Post::onlyTrashed()->count();
        $countNew = [$countNewActive, $countNewTrash];
        return view("admin.news.index", compact("news", "countNew", "act"));
    }


    public function create()
    {
        return view('admin.news.create');
    }


    public function edit($id)
    {
        $newById = Post::find($id);
        $categoryNewLevel1 = CategoryPost::where('status', 'active')->where('type', 'tin-tuc')->where('level', 1)->get();
        $categoryNewLevel2 = CategoryPost::where('status', 'active')->where('type', 'tin-tuc')->where('level', 2)->get();
        return view("admin.news.edit", compact("newById", "categoryNewLevel1", "categoryNewLevel2"));
    }

    public function edit_ajax(Request $request)
    {
        $action = $request->action;
        $id = $request->id;
        if (!empty($action)) {
            $output = '';
            if ($action == 'category_new1') {
                $categoryNewsLevel2 = CategoryPost::where('parent_id', $id)->where('level', 2)->get();
                $output .= '<option>Chọn danh mục cấp 2</option>';
                foreach ($categoryNewsLevel2 as $v2) {
                    $output .= '<option value="' . $v2->id . '">' . $v2->name . '</option>';
                }
            }
            return $output;
        }
    }


    public function store(Request $request, $id = "")
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
                    return redirect('admin/news/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect('admin/news/create')->with('danger', 'File tải lên đã vượt quá 25MB');
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
                    return redirect('admin/news/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile1 > 26214400) {
                        return redirect('admin/news/create')->with('danger', 'File tải lên đã vượt quá 25MB');
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
                    return redirect('admin/news/create')->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile2 > 26214400) {
                        return redirect('admin/news/create')->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file2->move('public/backend/uploads', $nameFile2);
                        $photo2 = $nameFile2;
                    }
                }
            } else {
                $photo2 = "";
            }

            Post::create(
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
                    "slogan" => !empty($request->slogan) ? $request->slogan : '',
                    "state" => !empty($request->state) ? $request->state : '',
                    "view" => !empty($request->view) ? $request->view : '',
                    "office" => !empty($request->office) ? $request->office : '',
                    "number" => !empty($request->number) ? $request->number : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "options" => !empty($request->options) ? $request->options : '',
                    "type" => 'tin-tuc',
                    "status" => 'active'
                ]
            );
            return redirect('admin/news/index')->with('success', 'Thêm dữ liệu thành công');
        }


        if (!empty($id)) {
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
                    return redirect("admin/news/edit/{$id}")->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile > 26214400) {
                        return redirect("admin/news/edit/{$id}")->with('danger', 'File tải lên đã vượt quá 25MB');
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
                    return redirect("admin/news/edit/{$id}")->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile1 > 26214400) {
                        return redirect("admin/news/edit/{$id}")->with('danger', 'File tải lên đã vượt quá 25MB');
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
                    return redirect("admin/news/edit/{$id}")->with('danger', 'File không đúng định dạng jpg, jpeg, .gif, png, webp');
                } else {
                    if ($sizeFile2 > 26214400) {
                        return redirect("admin/news/edit/{$id}")->with('danger', 'File tải lên đã vượt quá 25MB');
                    } else {
                        $file2->move('public/backend/uploads', $nameFile2);
                        $photo2 = $nameFile2;
                    }
                }
            } else {
                $photo2 = "";
            }

            Post::find($id)->update(
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
                    "slogan" => !empty($request->slogan) ? $request->slogan : '',
                    "state" => !empty($request->state) ? $request->state : '',
                    "view" => !empty($request->view) ? $request->view : '',
                    "office" => !empty($request->office) ? $request->office : '',
                    "number" => !empty($request->number) ? $request->number : '',
                    "slug" => !empty($request->slug) ? $request->slug : '',
                    "desc" => !empty($request->desc) ? $request->desc : '',
                    "content" => !empty($request->content) ? $request->content : '',
                    "options" => !empty($request->options) ? $request->options : '',
                    "type" => 'tin-tuc',
                ]
            );
            return redirect("admin/news/edit/{$id}")->with('success', 'Cập nhật dữ liệu thành công');
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
                        Post::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'active']);
                        Post::withTrashed()->whereIn('id', $listCheckbox)->restore();
                        return redirect('admin/news/index')->with('success', 'Khôi phục tin tức thành công');
                        break;


                    case 'delete':
                        Post::withTrashed()->whereIn('id', $listCheckbox)->update(['status' => 'trash']);
                        Post::destroy($listCheckbox);
                        return redirect('admin/news/index')->with('success', 'Xóa tin tức thành công');
                        break;


                    case 'force_delete':
                        Post::withTrashed()->whereIn('id', $listCheckbox)->forceDelete();
                        return redirect('admin/news/index')->with('success', 'Xóa vĩnh viễn tin tức thành công');
                        break;

                    default:
                        break;
                }
            }
        }
    }


    public function delete($id)
    {
        $newById = Post::find($id);
        $newById->update(['status' => 'trash']);
        $newById->delete();
        return redirect('admin/news/index')->with('success', 'Xóa dịch vụ thành công');
    }


    public function copy($id)
    {
        if (!empty($id)) {

            $newById = Post::find($id);
            $num = rand(1, 10);
            $newById->photo !== null ? $photo = $newById->photo : $photo = '';
            $newById->photo1 !== null ? $photo1 = $newById->photo1 : $photo1 = '';
            $newById->photo2 !== null ? $photo2 = $newById->photo2 : $photo2 = '';
            $newById->office !== null ? $office = $newById->office : $office = '';
            $newById->number !== null ? $number = $newById->number : $number = '';
            $newById->slug !== null ? $slug = $newById->slug : $slug = '';
            $newById->slogan !== null ? $slogan = $newById->slogan : $slogan = '';
            $newById->address !== null ? $address = $newById->address : $address = '';
            $newById->desc !== null ? $desc = $newById->desc : $desc = '';
            $newById->content !== null ? $content = $newById->content : $content = '';

            $num = rand(1, 10);
            Post::create(
                [
                    "name" => $newById->name . "({$num})",
                    "photo" => $photo,
                    "photo1" => $photo1,
                    "photo2" => $photo2,
                    "office" => $office,
                    "number" => $number,
                    "slug" => $slug,
                    "slogan" => $slogan,
                    "address" => $address,
                    "desc" => $desc,
                    "content" => $content,
                    "state" => "",
                    "type" => 'dich-vu',
                    "status" => 'active',
                ]
            );
            return redirect("admin/news/index")->with('success', 'Sao chép dữ liệu thành công');
        }
    }


    public function state(Request $request)
    {
        $id = $request->input('id');
        $show = $request->input('show');
        Post::find($id)->update(['state' => $show]);
    }

    public function remove_state(Request $request)
    {
        $id = $request->input('id');
        Post::find($id)->update(['state' => null]);
    }
}
