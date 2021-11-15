@extends('layouts.common')

@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/js/forum_detail_common.js"></script>
    <script src="/js/submit_common.js"></script>
@endsection

@section('title')
    {{ 'Forum Detail:' . $post->title }}
@endsection

@section('main')
    <div class="col-sm-12 col-md-12 p-0">
        <div class="card text-white bg-secondary mt-3">
            <div class="card-header d-flex justify-content-between">
                <h3>{{ $post->title }}({{ $post->user_name }}さん)</h3>
                {{-- @if ($post->user_id == \Auth::id()) --}}
                    @can('isAuthor', $post)
                    <div class="d-flex justify-content-right">
                        <a href="{{ '/edit?id=' . $post->id }}"><i class="fas fa-pen pointer"></i></a>
                        <div class="mx-2"></div>
                        <form action={{ route('destroy') }} method="post" id="delete_submit">
                            @csrf
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <i class="fas fa-trash pointer" id="trashbox"></i>
                        </form>
                    </div>
                    @endcan
                {{-- @endif --}}
            </div>
            <div class="card-body my-card-body">
                <p class="mt-2">(投稿日時：{{ $post->created_at }}/更新日時：{{ $post->updated_at }})</p>
                <p class="mt-2">【カテゴリ：{{ $post->category }}】</p>
                <p>{!! nl2br(e($post->text)) !!}</p>
                <form action="{{ route('detail_good') }}" method="post" id="good_submit">
                    @csrf
                    <input type="hidden" name="id" value="{{ $post->id }}">
                    <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                    <input type="hidden" name="favorite" value="{{ isset($post->reaction) ? 1 : 0 }}">
                    @if (isset($post->reaction))
                        <i class="fas fa-heart pointer" id="submit_heart"></i>
                    @else
                        <i class="far fa-heart pointer" id="submit_heart"></i>
                    @endif
                    <span>{{ $likeCount }}</span>
                </form>
                <div class="d-flex mt-3">
                    <form action="{{ route('comment') }}" method="post">
                        @csrf
                        <input type="hidden" name="id" value="{{ $post->id }}">
                        <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                        <textarea class="form-control my-comment-text" name="comment" rows="5" placeholder="コメント内容を入力してください"></textarea>
                        @error ('comment')
                        <div class="alert-danger my-alert-height px-3 mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                        <button type="submit" class="btn btn-primary mt-3">Post</button>
                    </form>
                </div>
            </div>
        </div>
        @php
            $bef_id = 0
        @endphp
        @foreach ($comments as $comment)
            <div class="card text-white bg-success margin-left{{ $comment->hierarchy}} @if(!isset($comment->parent_id)) mt-1 @endif">
                <div class="card-header">
                    <h5>{{$comment->user->name }}さん</h5>
                </div>
                <div class="card-body my-card-body">
                    <p class="mt-2">(投稿日時：{{ $comment->created_at }})</p>
                    <p>{!! nl2br(e($comment->comment)) !!}</p>
                    <div class="d-flex mt-3">
                        <form action="{{ route('child_comment') }}" method="post">
                            @csrf
                            <input type="hidden" name="id" value="{{ $post->id }}">
                            <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                            <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
                            <textarea class="form-control my-comment-text" name="{{ 'comment' . $comment->id }}" rows="5" placeholder="コメント内容を入力してください"></textarea>
                            @error ('comment' . $comment->id)
                            <div class="alert-danger my-alert-height px-3 mt-1">
                                {{ $message }}
                            </div>
                            @enderror
                            <button type="submit" class="btn btn-primary mt-3">Post</button>
                        </form>
                    </div>
                </div>
                {{-- @foreach($comment->children as $child)
                    <div class="card text-white bg-success mt-1">
                        <div class="card-header">
                            <h5>{{ $loop->iteration . '.' . $child->user->name }}さん</h5>
                        </div>
                        <div class="card-body my-card-body">
                            <p class="mt-2">(投稿日時：{{ $child->created_at }})</p>
                            <p>{!! nl2br(e($child->comment)) !!}</p>
                        </div>
                    </div>
                @endforeach --}}
            </div>
            @php
                $bef_id = $comment->id
            @endphp
        @endforeach
    </div>
@endsection
