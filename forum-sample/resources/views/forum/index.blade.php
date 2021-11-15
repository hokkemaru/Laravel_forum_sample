@extends('layouts.common')

@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/js/category_search.js"></script>
@endsection

@section('title')
    Forum Top
@endsection

@section('main')
    <div class="mt-3">
        <form action="/" method="get" id="submit_form">
            <label for="category" class="form-label">▼Category Search</label>
            <select class="form-select form-select-sm my-form-select" name="category" id="submit_select">
                {{-- 全選択に戻す用のoptionを一つ用意しておく --}}
                <option value="0">全てのカテゴリ</option>
                @foreach ($codes as $code)
                    <option value="{{ $code->id }}" @if(request()->category == $code->id) selected @endif>{{ $code->name }}</option>
                @endforeach
            </select>
        </form>
    </div>
    <table class="table mt-3 my-post-table">
        <thead>
            <tr>
                <th class="col my-post-table-title my-post-table-th">
                    @if(mb_strtolower(request()->get('sort')) == "title")
                        @if(mb_strtolower(request()->get('order')) == "asc")
                            <a href="{{ '/?sort=title&order=desc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-down"></i>
                        @else
                            <a href="{{ '/?sort=title&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-up"></i>
                        @endif
                    @else
                        <a href="{{ '/?sort=title&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                    @endif
                    Title
                    </a>
                </th>
                <th class="col my-post-table-category my-post-table-th">
                    @if(mb_strtolower(request()->get('sort')) == "category")
                        @if(mb_strtolower(request()->get('order')) == "asc")
                            <a href="{{ '/?sort=category&order=desc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-down"></i>
                        @else
                            <a href="{{ '/?sort=category&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-up"></i>
                        @endif
                    @else
                        <a href="{{ '/?sort=category&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                    @endif
                    Category
                    </a>
                </th>
                <th class="col my-post-table-author my-post-table-th">
                    @if(mb_strtolower(request()->get('sort')) == "user_name")
                        @if(mb_strtolower(request()->get('order')) == "asc")
                            <a href="{{ '/?sort=user_name&order=desc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-down"></i>
                        @else
                            <a href="{{ '/?sort=user_name&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-up"></i>
                        @endif
                    @else
                        <a href="{{ '/?sort=user_name&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                    @endif
                    Author
                    </a>
                </th>
                <th class="col my-post-table-like my-post-table-th">
                    @if(mb_strtolower(request()->get('sort')) == "like_count")
                        @if(mb_strtolower(request()->get('order')) == "asc")
                            <a href="{{ '/?sort=like_count&order=desc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-down"></i>
                        @else
                            <a href="{{ '/?sort=like_count&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-up"></i>
                        @endif
                    @else
                        <a href="{{ '/?sort=like_count&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                    @endif
                    Like
                    </a>
                </th>
                <th class="col my-post-table-reply my-post-table-th">
                    @if(mb_strtolower(request()->get('sort')) == "comment_count")
                        @if(mb_strtolower(request()->get('order')) == "asc")
                            <a href="{{ '/?sort=comment_count&order=desc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-down"></i>
                        @else
                            <a href="{{ '/?sort=comment_count&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-up"></i>
                        @endif
                    @else
                        <a href="{{ '/?sort=comment_count&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                    @endif
                    Reply
                    </a>
                </th>
                <th class="col my-post-table-post my-post-table-th">
                    @if(mb_strtolower(request()->get('sort')) == "created_at")
                        @if(mb_strtolower(request()->get('order')) == "asc")
                            <a href="{{ '/?sort=created_at&order=desc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-down"></i>
                        @else
                            <a href="{{ '/?sort=created_at&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-up"></i>
                        @endif
                    @else
                        <a href="{{ '/?sort=created_at&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                    @endif
                    Post
                    </a>
                </th>
                <th class="col my-post-table-update my-post-table-th">
                    @if(mb_strtolower(request()->get('sort')) == "updated_at")
                        @if(mb_strtolower(request()->get('order')) == "asc")
                            <a href="{{ '/?sort=updated_at&order=desc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-down"></i>
                        @else
                            <a href="{{ '/?sort=updated_at&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                            <i class="fas fa-sort-up"></i>
                        @endif
                    @else
                        <a href="{{ '/?sort=updated_at&order=asc' . (!empty(request()->get('category')) ? '&category=' . request()->get('category') : '') }}">
                    @endif
                    Update
                    </a>
                </th>
            </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
            <tr>
                <td class="col my-post-table-title ellipsis"><a href="{{ '/forum_detail/?id=' . $post->id }}">{{ $post->title }}</a></td>
                <td class="col my-post-table-category ellipsis">{{ $post->category }}</td>
                <td class="col my-post-table-author ellipsis">{{ $post->user_name }}</td>
                <td class="col my-post-table-like">{{ $post->like_count == null ? 0 : $post->like_count }}</td>
                <td class="col my-post-table-reply">{{ $post->comment_count == null ? 0 : $post->comment_count }}</td>
                <td class="col my-post-table-post">{{ $post->created_at }}</td>
                <td class="col my-post-table-update">{{ $post->updated_at }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
    {{ $posts->appends(request()->query())->links() }}
@endsection
