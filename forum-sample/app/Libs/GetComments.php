<?php
namespace App\Libs;
use App\Models\ForumPostComment;

class GetComments {
    private $comments;
    private $children;
    public function __construct($id)
    {
        //対象のコメントを全件取得
        $this->comments = collect(ForumPostComment::orderBy('id', 'asc')
                                            ->where('forum_post_id', '=', $id)
                                            ->whereNull('parent_id')
                                            ->get());
        $this->children = collect(ForumPostComment::orderBy('id', 'asc')
                                            ->where('forum_post_id', '=', $id)
                                            ->whereNotNull('parent_id')
                                            ->get());

    }

    public function list_page_render() {
        $collectAll = collect();
        foreach($this->comments as $comment) {
            $collectOne = collect();
            //コメントの階層
            $hierarchy = 0;
            $comment['hierarchy'] = $hierarchy;
            //collectOneには一つの最上層コメントと、それに紐づく全てのコメントを抽出する
            $collectOne->push($comment);
            //最初は必ず1。末尾に追加されるたびにカウントを更新する
            $count = $collectOne->count();
            for($i = 0; $i < $count; $i++) {
                //最初の子供を取得する
                $firstChild = $this->children->where('parent_id', $collectOne[$i]->id)->first();
                if(!is_null($firstChild)) {
                    //子供が見つかった場合、階層値に+1してkeyとして追加する
                    $hierarchy += 1;
                    $firstChild['hierarchy'] = $hierarchy;
                    $collectOne->push($firstChild);
                    //要素を追加したので追加した要素分をループに入れるためにカウントを更新
                    $count = $collectOne->count();
                    //コレクション上から追加した要素を除外する
                    $this->children = $this->children->where('id', '<>', $firstChild->id);
                } else {
                    //子供が見つからない(最下層)に到達したら次の処理へ
                    $hierarchy = 0;
                    $newChild = $this->children->where('parent_id', $collectOne[0]->id)->first();
                    if(!is_null($newChild)) {
                        //子供が見つかった場合、階層値に+1してkeyとして追加する
                        $hierarchy += 1;
                        $newChild['hierarchy'] = $hierarchy;
                        $collectOne->push($newChild);
                        //要素を追加したので追加した要素分をループに入れるためにカウントを更新
                        $count = $collectOne->count();
                        //コレクション上から追加した要素を除外する
                        $this->children = $this->children->where('id', '<>', $newChild->id);
                    }
                }
            }
            foreach($collectOne as $obj) {
                $collectAll->push($obj);
            }
        }
        return $collectAll;
    }
}