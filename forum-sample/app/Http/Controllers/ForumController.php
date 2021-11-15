<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\GetComments;
use App\Models\Code;
use App\Models\ForumPost;
use App\Models\ForumPostReaction;
use App\Models\ForumPostComment;
use App\Http\Requests\ForumRequest;
use Illuminate\Support\Facades\DB;

class ForumController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index(Request $request) {
        // いいね件数とコメント件数取得のためのサブクエリを作成
        $likeCountQuery = ForumPostReaction::query()
                                            ->select(DB::raw('count(*) AS like_count, forum_post_id'))
                                            ->groupBy('forum_post_id')
                                            ->toSql();

        $commentCountQuery = ForumPostComment::query()
                                            ->select(DB::raw('count(*) AS comment_count, forum_post_id'))
                                            ->groupBy('forum_post_id')
                                            ->toSql();

        // フォーラム記事テーブルの取得
        $query = ForumPost::query();
        $query->select('forum_posts.*', 'codes.name AS category', 'users.name AS user_name', 'like_sum.like_count', 'comment_sum.comment_count')
                ->leftJoin('codes', 'codes.id', '=', 'forum_posts.category_id')
                ->leftJoin('users', 'users.id', '=', 'forum_posts.user_id')
                ->leftJoin(DB::raw('('. $likeCountQuery .') AS like_sum'), 'like_sum.forum_post_id', '=', 'forum_posts.id')
                ->leftJoin(DB::raw('('. $commentCountQuery .') AS comment_sum'), 'comment_sum.forum_post_id', '=', 'forum_posts.id');
        // もしカテゴリの指定があれば絞り込む
        // ※すべて表示の場合、$request->categoryには"0"を渡している
        // ※これはemptyという判定になる為、実質$request->categoryが
        // ※存在しないときと同じ動きをする。
        if(!empty($request->category)) {
            $query->where('codes.id', '=', $request->category);
        }
        if(!empty($request->sort) && !empty($request->order)) {
            $query->orderBy($request->sort, $request->order);
        }
        $query->orderBy('forum_posts.id', 'desc');
        $displayCount = config('const.constant.display_count');
        $posts = $query->paginate($displayCount);

        //test
        /*$forumPost = new ForumPost();
        $tests = $forumPost->select('forum_posts.*')
                        ->get()->all();
        $testCodes = [];
        foreach($tests as $test) {
            array_push($testCodes, $test->code->name);
        }
        dd($testCodes);*/

        // コードマスタを取得
        $code = new Code();
        $codes = $code->getCodes('CATEGORY');

        return view('forum.index', compact('posts','codes'));
    }

    public function post() {
        // コードマスタを取得
        $code = new Code();
        $codes = $code->getCodes('CATEGORY');
        return view('forum.post', compact('codes'));
    }

    public function create(ForumRequest $request) {
        ForumPost::create([
            'user_id' => $request->user_id,
            'category_id' => $request->category,
            'title' => $request->title,
            'text' => $request->text,
        ]);
        return redirect(route('home'));
    }

    public function detail(Request $request) {
        // idが指定されていなければトップにリダイレクト
        if(empty($request->id)) {
            return redirect(route('home'));
        } else {
            // idは指定されているが、該当記事が無ければトップにリダイレクト
            $post = ForumPost::select('forum_posts.*', 'codes.name AS category', 'users.name AS user_name','forum_post_reactions.id AS reaction')
                            ->leftJoin('codes', 'codes.id', '=', 'forum_posts.category_id')
                            ->leftJoin('users', 'users.id', '=', 'forum_posts.user_id')
                            ->leftJoin('forum_post_reactions', function ($join) {
                                $join->on('forum_post_reactions.forum_post_id', '=' , 'forum_posts.id')
                                    ->where('forum_post_reactions.user_id', '=', \Auth::id());
                                })
                            ->where('forum_posts.id', '=', $request->id)
                            ->first();
            if(empty($post)) {
                return redirect(route('home'));
            } else {
                // すべての表示条件を満たした場合、コメントといいね数を取得し画面遷移する。
                /*$comments = ForumPostComment::select('forum_post_comments.*', 'users.name AS user_name')
                                            ->leftJoin('users', 'forum_post_comments.user_id', '=', 'users.id')
                                            ->orderBy('forum_post_comments.id', 'asc')
                                            ->where('forum_post_comments.forum_post_id', '=', $request->id)
                                            ->whereNull('forum_post_comments.parent_id')
                                            ->get();
                */
                $getComments = new GetComments($request->id);
                $comments = $getComments->list_page_render();
                $likeCount = ForumPostReaction::where('forum_post_id', '=', $request->id)
                                            ->count();
                return view('forum.detail', compact('post', 'comments', 'likeCount'));
            }
        }
    }

    public function edit(Request $request) {
        // idが指定されていなければトップにリダイレクト
        if(empty($request->id)) {
            return redirect(route('home'));
        } else {
            // idは指定されているが、該当記事が無い場合はトップにリダイレクト
            $post = ForumPost::find($request->id);
            if(empty($post)) {
                return redirect(route('home'));
            } else {
                // ユーザが異なる場合はトップにリダイレクト
                if($post->user_id != \Auth::id()) {
                    return redirect(route('home'));
                } else {
                    // コードマスタを取得
                    $code = new Code();
                    $codes = $code->getCodes('CATEGORY');
                    return view('forum.edit', compact('post','codes'));
                }
            }
        }
    }

    public function update(ForumRequest $request) {
        // 該当フォーラム記事を取得しupdateする
        $post = ForumPost::find($request->id);
        $post->title = $request->title;
        $post->category_id = $request->category;
        $post->text = $request->text;
        $post->save();
        return redirect(route('home'));
    }

    public function destroy(Request $request) {
        // フォーラム記事テーブルを削除する
        $post = ForumPost::find($request->id);
        $post->delete();

        return redirect(route('home'));
    }

    public function good(Request $request) {
        // 削除かinsertかを判断する、"0"=insert、"1"=delete
        if($request->favorite == "1") {
            $reaction = ForumPostReaction::where('forum_post_id', '=', $request->id)
                            ->where('user_id', '=', $request->user_id)
                            ->first();
            $reaction->delete();
        } else {
            // 登録時はリアクションIDを取得する
            $code = new Code();
            $codes = $code->getCodes('REACTION');
            $reaction = ForumPostReaction::create([
                'forum_post_id' => $request->id,
                'user_id' => $request->user_id,
                // 表示順にソートされている最初のものをセット(仮対応)
                'reaction_id' => $codes[0]->id,
            ]);
        }
        return redirect()->route('detail',['id' => $request->id]);
    }

    public function comment(Request $request) {
        // validationを行う
        $this->validate($request, [
            'comment' => 'required|max:16383',
        ],[
            'comment.required' => 'コメント内容は入力必須です',
            'comment.max' => 'コメントは16,383文字以内で入力してください',
        ]);

        ForumPostComment::create([
            'forum_post_id' => $request->id,
            'user_id' => $request->user_id,
            'comment' => $request->comment,
        ]);
        return redirect()->route('detail',['id' => $request->id]);
    }

    public function childComment(Request $request) {
        // validationを行う
        $this->validate($request, [
            'comment' . $request->parent_id => 'required|max:16384',
        ],[
            'comment' . $request->parent_id . '.required' => 'コメント内容は入力必須です',
            'comment' . $request->parent_id . '.max' => 'コメントは16,384文字以内で入力してください',
        ]);

        ForumPostComment::create([
            'forum_post_id' => $request->id,
            'user_id' => $request->user_id,
            'parent_id' => $request->parent_id,
            'comment' => $request['comment' . $request->parent_id] ,
        ]);
        return redirect()->route('detail',['id' => $request->id]);
    }
}
