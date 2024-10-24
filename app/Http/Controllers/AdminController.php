<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\News;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function index()
    {
        $news_pending = News::where('status', 'pending')->with('user', 'category')->limit(10)->get();
        $data['news_active'] = News::where('status', 'active')->count();
        $data['news_pending'] = News::where('status', 'pending')->count();
        $data['news_deny'] = News::where('status', 'deny')->count();

        $data['user'] = User::count();
        $categories = Category::all();
        return view('pages.admin.dashboard', compact('news_pending', 'data', 'categories'));
    }
    public function categories()
    {
        // $data = Category::query()->paginate(20);
        // dd($data->items());
        $data = Category::limit(20)->get();
        return view('pages.admin.categories', compact('data'));
    }
    public function createcategory($id = null)
    {
        if ($id) {
            $category = Category::find($id);
        } else {
            $category = null;
        }
        return view('pages.admin.createcategory', compact('category'));
    }
    public function _createcategory(Request $request, $id = null)
    {
        if (!$id) {
            $validate = Validator::make($request->all(), [
                // 'icon_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'icon_url' => 'required',
                'name' => 'required|string',
                'priority' => 'required|integer'
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate->errors())->withInput();
            }

            $slug = Str::slug($request->name);
            $checkSlug = Category::where('slug', $slug)->count();
            if ($checkSlug > 0) {
                $slug .= '-' . $checkSlug;
            }
            Category::create([
                'name' => $request->name,
                'slug' => $slug,
                'icon_url' => $request->file('icon_url')->store('categories', 'public'),
                'priority' => $request->priority,
                'is_show' => $request->is_show ? true : false,
            ]);
            return redirect()->back()->with('success', 'Tạo danh mục mới thành công!');
        } else {
            $category = Category::find($id);
            if (!$category) {
                return redirect()->back()->with('error', 'Không tìm thấy danh mục để sửa!');
            }
            $validate = Validator::make($request->all(), [
                'name' => 'required|string',
                'priority' => 'required|integer'
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate->errors())->withInput();
            }
            if ($category->name != $request->name) {
                $slug = Str::slug($request->name);
                $checkSlug = Category::where('slug', $slug)->count();
                if ($checkSlug > 0) {
                    $slug .= '-' . $checkSlug;
                }
                $category->slug = $slug;
                $category->name = $request->name;
            }
            if ($request->hasFile('icon_url')) {
                $category->icon_url = $request->file('icon_url')->store('categories', 'public');
            }
            $category->priority = $request->priority;
            $category->is_show = $request->is_show ? true : false;
            $category->save();
            return redirect()->back()->with('success', 'Sửa danh mục thành công!');

        }

    }
    public function deletecategory($id)
    {
        $category = Category::find($id);
        if ($category) {
            $checkCate = News::where('category_id', $category->id)->exists();
            if ($checkCate) {
                return redirect()->back()->with('error', 'Danh mục đã có tin tức, bạn cần xóa các tin tức thuộc danh mục này trước!');
            }
            $category->delete();
            return redirect()->back()->with('success', 'Xóa danh mục thành công!');
        }
        return redirect()->back()->with('error', 'Không tìm thấy danh mục để xóa!');
    }
    public function action_news($id, $type)
    {
        $news = News::find($id);
        if ($news) {
            if ($type == 'delete') {
                $news->delete();
                return redirect()->back()->with('success', 'Xóa tin tức thành công!');
            }
            switch ($type) {
                case 'active':
                    $news->status = 'active';
                    break;
                case 'deny':
                    $news->status = 'deny';
                    break;
                case 'hot':
                    $news->type = $news->type == 'hot' ? 'news' : 'hot';
                    break;
                default:
                    return redirect()->back()->with('error', 'Không tìm thấy trạng thái!');
            }
            $news->save();
            return redirect()->back()->with('success', 'Thay đổi trạng thái thành công!');
        }
        return redirect()->back()->with('error', 'Không tìm thấy tin tức!');
    }
    public function tags()
    {
        return view('pages.admin.tags');
    }
    public function news()
    {
        $data = News::with('category', 'user')->orderBy('updated_at', 'desc')->paginate(20);
       
        return view('pages.admin.news', compact('data'));
    }
    public function users()
    {
        $data = User::orderBy('created_at','desc')->paginate(20);
        return view('pages.admin.users', compact('data'));
    }
}
