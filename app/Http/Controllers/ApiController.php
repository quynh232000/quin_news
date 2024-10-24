<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Comments;
use App\Models\News;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    public function get_child_comments($id)
    {
        $comments = Comments::where(['entity_id' => $id, 'type' => 'reply'])->with('user')
            ->get()->map(function ($comment) {
                $comment->is_like = $comment->is_like();
                $comment->likes = $comment->likes();
                $comment->replies_count = $comment->replies_count();
                return $comment;
            });
        return response()->json($comments);
    }
    /**
     * @OA\Get(
     *     path="/api/all_categories",
     *      operationId="all_categories",
     *     tags={"Api"},
     *     summary="Get list of categories",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function get_all_categories()
    {
        $data = Category::all();
        return response()->json(['status'=>true, 'message' => 'ok', 'data' => $data]);
    }
    /**
     * @OA\Get(
     *     path="/api/all_news",
     *      operationId="all_news",
     *     tags={"Api"},
     *     summary="Get list of news",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function get_all_news()
    {
        $data = News::with('user', 'category')->limit(20)->get();
        return response()->json(['status' => true, 'message' => 'ok', 'data' => $data]);
    }

    /**
     * @OA\Get(
     *     path="/api/get_news_by_cate/{slug}",
     *      operationId="get_news_by_cate",
     *     tags={"Api"},
     *     summary="",
     *    @OA\Parameter(
     *          name="slug",
     *          description="Category slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function get_news_by_cate($slug)
    {
        $cate = Category::where('slug', $slug)->first();
        if (!$cate) {
            return response()->json(['status' => false, 'message' => 'Danh mục không tồn tại'], 404);
        }
        $data = News::where('category_id', $cate->id)->with('user', 'category')->limit(20)->get();
        return response()->json(data: ['status' => true, 'message' => 'Lấy danh sách tin tức thành công!', 'data' => $data]);
    }
    /**
     * @OA\Get(
     *     path="/api/get_news_detail/{slug}",
     *      operationId="get_news_detail",
     *     tags={"Api"},
     *     summary="",
     *    @OA\Parameter(
     *          name="slug",
     *          description="News slug",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="string"
     *          )
     *      ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=401,
     *         description="Unauthorized"
     *     )
     * )
     */
    public function get_news_detail($slug)
    {
        $news = News::where('slug', $slug)->with('user', 'category')->first();
        if (!$news) {
            return response()->json(['status' => false, 'message' => 'Tin tức không tồn tại'], 404);
        }
        return response()->json(data: ['status' => true, 'message' => 'Lấy thông tin tức thành công!', 'data' => $news]);
    }
}
