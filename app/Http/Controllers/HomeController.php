<?php

namespace App\Http\Controllers;
use App\Events\Comment;
use App\Models\Category;
use App\Models\Comments;
use App\Models\denynews;
use App\Models\Follow;
use App\Models\News;
use App\Models\Reaction;
use App\Models\Saved;
use App\Models\User;
use DB;
use Http;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;





class HomeController extends Controller
{
    public function __construct()
    {
        $authors = User::select('users.*')
            ->withCount([
                'followers as followers_count' => function ($query) {
                    $query->select(DB::raw('count(*)'));
                }
            ])
            ->orderBy('followers_count', 'desc')
            ->limit(10)
            ->get();
        $categories = Category::where('is_show', true)->orderBy('priority', 'asc')->get();

        view()->share(['authors' => $authors, 'categories' => $categories]);
    }
    public function index(Request $request)
    {
        if ($request->search) {
            return redirect()->route('search', ['search' => $request->search]);
        }

        $news_hot = News::where(['is_delete' => false, 'is_show' => true, 'status' => 'active', 'type' => 'hot'])->with('user', 'category')->orderBy('updated_at', 'desc')->limit(4)->get();

        $news_new = News::where(['is_delete' => false, 'is_show' => true, 'status' => 'active'])->with('user', 'category')->limit(3)->orderBy('updated_at', 'desc')->get();

        $news_views = News::where(['is_delete' => false, 'is_show' => true, 'status' => 'active'])
            ->with('user', 'category')->orderBy('views', 'desc')->limit(6)->get();

        $news_thoisu = News::where(['is_delete' => false, 'is_show' => true, 'status' => 'active', 'category_id' => 3])
            ->with('user', 'category')->limit(6)->orderBy('updated_at', 'desc')->get();
        return view('pages.home', compact('news_hot', 'news_new', 'news_views', 'news_thoisu'));
    }

    public function collection(Request $request, $slug_cate = null)
    {
        $viewTitle = '';
        $query = News::where(['is_delete' => false, 'is_show' => true, 'status' => 'active'])->with('user', 'category');
        if ($slug_cate) {
            $category = Category::where('slug', $slug_cate)->first();
            if (!$category) {
                return redirect()->route('home')->with('error', 'Danh mục không tồn tại!');
            }
            $viewTitle = $category->name;
            $query->where('category_id', $category->id);
        }

        if ($request->search && $request->search != '') {
            $viewTitle = 'Tìm kiếm: ' . $request->search;
            $query->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('subtitle', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->sort && $request->sort != '') {
            switch ($request->sort) {
                case 'view':
                    $query->orderBy('views', 'DESC');
                    break;
                case 'latest':
                    $query->orderBy('updated_at', 'DESC');
                    break;
                case 'oldest':
                    $query->orderBy('updated_at', 'asc');
                    break;
            }
        }
        $data = $query->paginate(6);
        return view('pages.collection', compact('data', 'viewTitle'));
    }
    public function following()
    {
        if(!auth()->check()){
            return redirect()->route('login')->with('error', 'Bạn phải đăng nhập để xem trang này!');
        }
        $follower_ids = Follow::where('from_user_id',auth()->id())->pluck('to_user_id')->all();
        
        $query = News::where(['is_delete' => false, 'is_show' => true, 'status' => 'active'])->with('user', 'category');
        $query->whereIn('user_id', $follower_ids);
        $data = $query->paginate(6);
        $viewTitle = 'Tin đang theo dõi';
        return view('pages.collection', compact('data', 'viewTitle'));
    }
    public function saved()
    {
        $has_cate = false;
        $news_ids = Saved::where(['user_id' => auth()->id()])->pluck('news_id')->all();
        $data = News::whereIn('id', $news_ids)->with('user', 'category')->paginate(6);
        return view('pages.saved', compact('data', 'has_cate'));
    }

    public function detail($slug_news)
    {
        $news = News::where(['is_delete' => false, 'is_show' => true, 'status' => 'active', 'slug' => $slug_news])->with('user', 'category')->first();
        if (!$news) {
            return redirect()->route('home')->with('error', 'Tin tức không tồn tại!');
        }
        if (!session('post_id_' . $news->id)) {
            Session::put('post_id_' . $news->id, true);
            $news->views += 1;
            $news->save();
        }

        $news_hot = News::where(['is_delete' => false, 'is_show' => true, 'status' => 'active'])
            ->with('user', 'category')->orderBy('views', 'desc')->limit(5)->get();
        $comments = Comments::where(['entity_id' => $news->id, 'type' => 'news'])->orderBy('created_at', 'desc')
            ->with('user')
            ->paginate(5);
            $total_comment = Comments::count();
        return view('pages.detail', compact('news', 'news_hot', 'comments','total_comment'));
    }
    public function author(Request $request, $uuid)
    {
        $author = User::where('uuid', $uuid)->first();
        if (!$author) {
            return redirect()->route('error')->with('error', 'Tác giả không tồn tại!');
        }
        $author->news_count = $author->news_count();

        $query = News::where(['is_delete' => false, 'is_show' => true, 'status' => 'active', 'user_id' => $author->id])
            ->with('user', 'category');

        if ($request->search && $request->search != '') {
            $viewTitle = 'Tìm kiếm: ' . $request->search;
            $query->where('title', 'LIKE', '%' . $request->search . '%')
                ->orWhere('subtitle', 'LIKE', '%' . $request->search . '%');
        }
        if ($request->sort && $request->sort != '') {
            switch ($request->sort) {
                case 'view':
                    $query->orderBy('views', 'DESC');
                    break;
                case 'latest':
                    $query->orderBy('updated_at', 'DESC');
                    break;
                case 'oldest':
                    $query->orderBy('updated_at', 'asc');
                    break;
            }
        }
        $data = $query->paginate(6);

        $comments = Comments::where('user_id', $author->id)->orderBy('created_at', 'desc')->paginate(5);

        return view('pages.author', compact('author', 'data', 'comments'));
    }
    public function follow_user($user_id)
    {
        $user = User::where('id', $user_id)->first();
        if (!$user) {
            return redirect()->back()->with('error', 'Tác giả không tồn tại!');
        }
        $follow = Follow::where(['from_user_id' => auth()->id(), 'to_user_id' => $user_id])->first();
        if ($follow) {
            $follow->delete();
            return redirect()->route('author', ['uuid' => $user->uuid])->with('success', 'Bạn đã bỏ theo dõi tác giả này.');
        } else {
            Follow::create(['from_user_id' => auth()->id(), 'to_user_id' => $user_id]);
            return redirect()->route('author', ['uuid' => $user->uuid])->with('success', 'Bạn đã theo dõi tác giả này.');
        }


    }
    public function save_news($id, Request $request)
    {
        $news = News::where('id', $id)->first();
        if (!$news) {
            return redirect()->back()->with('error', 'Tin không tồn tại!');
        }
        $saved = Saved::where(['user_id' => auth()->id(), 'news_id' => $id])->first();
        if ($saved) {
            $saved->delete();
            if ($request->type && $request->type == 'unsaved') {
                return redirect()->route('saved')->with('success', 'Hủy lưu thành công.');

            }
            return redirect()->route('detail', ['slug_news' => $news->slug])->with('success', 'Hủy lưu thành công.');
        } else {
            Saved::create(['user_id' => auth()->id(), 'news_id' => $id]);
            return redirect()->route('detail', ['slug_news' => $news->slug])->with('success', 'Lưu tin thành công.');
        }


    }
    public function like(Request $request, $id)
    {
        if ($request->from && $request->from == 'comment') {
            $entity = Comments::where('id', $id)->first();
            if (!$entity) {
                return redirect()->back()->with('error', 'Tin không tồn tại!');
            }
        } else {
            $entity = News::where('id', $id)->first();
            if (!$entity) {
                return redirect()->back()->with('error', 'Tin không tồn tại!');
            }

        }
        $like = Reaction::where([
            'user_id' => auth()->id(),
            'entity_id' => $entity->id,
            'from' => $request->from ? $request->from : 'news'
        ])->first();
        $type = $request->type ?? 'like';
        if ($like) {
            if ($like->type == $type) {
                $like->delete();
                return redirect()->back()->with('success', 'Bỏ thích thành công.');
            }
            $like->type = $type;
            $like->save();
            return redirect()->back()->with('success', 'Cập nhật thành công.');
        }
        Reaction::create([
            'user_id' => auth()->id(),
            'entity_id' => $entity->id,
            'type' => $type,
            'from' => $request->from ? $request->from : 'news'
        ]);
        return redirect()->back()->with('success', 'Thích thành công.');

    }
    public function comment(Request $request, $id)
    {
        if ($request->from && $request->from == 'news') {
            $entity = News::where('id', $id)->first();
            if (!$entity) {
                return redirect()->back()->with('error', 'Tin không tồn tại!');
            }

        } else {
            $entity = Comments::find($id);
            if (!$entity) {
                return redirect()->back()->with('error', 'Comment id k tồn tại');
            }
        }
        if (!$request->comment || $request->comment == '') {
            return redirect()->back()->with('error', 'Bạn cần nhập nội dung bình luận.');
        }
        $comment_new = Comments::create([
            'comment' => $request->comment,
            'type' => $request->from,
            'user_id' => auth()->id(),
            'entity_id' => $entity->id
        ]);
        $comment_new->user = $comment_new->user;
        // send comment  
        $news_info =$request->from == 'news' ? $entity : $comment_new->news();
      
        event(new Comment($news_info->id,$comment_new));

        return redirect()->route('detail', ['slug_news' => ($request->from == 'news' ? $entity->slug : $comment_new->news()->slug) . '#comment'])->with('success', 'Bình luận thành công.');

    }

    public function mynews()
    {
        $has_cate = false;
        $data = News::where(['user_id' => auth()->id(), 'is_delete' => false])->with('category')->limit(20)->orderBy('updated_at', 'desc')->paginate();
        return view('pages.mynews', compact('has_cate', 'data'));
    }
    public function addnews($id = null)
    {
        $has_cate = false;
        $categories = Category::all();
        if ($id) {
            $news = News::find($id);
            if (!$news) {
                return redirect()->back()->with('error', 'Tin tức không tồn tại!');
            }
            if ($news->user_id != auth()->id()) {
                return redirect()->back()->with('error', 'Bạn không có quyền xóa tin tức này!');
            }
            return view('pages.addnews', compact('has_cate', 'categories', 'news'));
        } else {
            return view('pages.addnews', compact('has_cate', 'categories'));

        }
    }
    public function _addnews(Request $request, $id = null)
    {
        if (!$id) {
            $validate = Validator($request->all(), [
                'image' => 'required|image',
                'title' => 'required|string|max:255',
                'subtitle' => 'required|string',
                'description' => 'required|string',
                'category_id' => 'required|string',
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }

            $slug = Str::slug($request->title);
            $checkSlug = News::where('slug', $slug)->count();
            if ($checkSlug > 0) {
                $slug = $slug . '-' . $checkSlug;
            }
            $news = News::create([
                'slug' => $slug,
                'title' => $request->title,
                'subtitle' => $request->subtitle,
                'image' => $request->file('image')->store('news', 'public'),
                'content' => $request->description,
                'category_id' => $request->category_id,
                'user_id' => auth()->id(),
                'type' => 'new',
                'status' => 'pending',
                'views' => 0,
                'is_show' => $request->is_show ? true : false
            ]);


            return redirect()->back()->with('success', 'Thêm tin tức thành công!');
        } else {
            $news = News::find($id);
            if (!$news) {
                return redirect()->back()->with('error', 'Tin tức không tồn tại!');
            }
            if ($news->user_id != auth()->id()) {
                return redirect()->back()->with('error', 'Bạn không có quyền sửa tin tức này!');
            }
            $validate = Validator($request->all(), [
                'title' => 'required|string',
                'description' => 'required|string',
                'category_id' => 'required|string',
            ]);
            if ($validate->fails()) {
                return redirect()->back()->withErrors($validate)->withInput();
            }
            if ($request->title != $news->title) {
                $slug = Str::slug($request->title);
                $checkSlug = News::where('slug', $slug)->count();
                if ($checkSlug > 0) {
                    $slug = $slug . '-' . $checkSlug;
                }
                $news->title = $request->title;
                $news->slug = $slug;
            }
            if ($request->hasFile('image')) {
                $news->image = $request->file('image') ? $request->file('image')->store('news', 'public') : $news->image;
            }
            $news->subtitle = $request->subtitle;
            $news->content = $request->description;
            $news->category_id = $request->category_id;
            $news->is_show = $request->is_show ? true : false;
            $news->status = 'pending';
            $news->updated_at = time();


            $news->save();
            return redirect()->back()->with('success', 'Sửa tin tức thành công!');

        }

    }


    public function deletenews($id)
    {
        $news = News::find($id);
        if (!$news) {
            return redirect()->back()->with('error', 'Tin tức không tồn tại!');
        }
        if ($news->user_id == auth()->id()) {
            $news->is_delete = true;
            $news->save();
            return redirect()->back()->with('success', 'Xóa tin tức thành công!');
        } else {
            return redirect()->back()->with('error', 'Bạn không có quyền xóa tin tức này!');
        }
    }
    public function test()
    {
        // check text
        //  $response = $this->api_check($request->title . ' ' . $request->subtitle);
        //  $bad_words = json_decode($response);
        //  if ($bad_words->bad_words_total > 0) {
        //      $news->status = 'deny';
        //      denynews::updateOrCreate(
        //          ['news_id' => $news->id],
        //          [
        //              'news_id' => $news->id,
        //              'bad_words_total' => $bad_words->bad_words_total,
        //              'bad_words_list' => json_encode($bad_words->bad_words_list)
        //          ]
        //      );
        //      $news->save();
        //  }
        // check text 
        //  $response = $this->api_check($request->title . ' ' . $request->subtitle);
        //  $bad_words = json_decode($response);
        //  if ($bad_words->bad_words_total > 0) {
        //      $news->status = 'deny';
        //      denynews::updateOrCreate(
        //          ['news_id' => $news->id],
        //          [
        //              'news_id' => $news->id,
        //              'bad_words_total' => $bad_words->bad_words_total,
        //              'bad_words_list' => json_encode($bad_words->bad_words_list)
        //          ]
        //      );
        //  } else {
        //      $deny = denynews::where('news_id', $news->id)->first();
        //      if ($deny) {
        //          $deny->delete();
        //      }
        //  }
    }
    // ================================== TESTING =================================
    // ================================== TESTING =================================
    // ================================== TESTING =================================
    public function test_final(){
        dd('123');
    }








    // ================================== TESTING =================================

}
