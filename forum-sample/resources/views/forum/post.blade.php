@extends('layouts.common')

@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/js/submit_common.js"></script>
@endsection

@section('title')
    Forum New Post
@endsection

@section('main')
    <form action={{ route('create') }} method="post">
        @csrf
        <div class="form-group mt-3">
            <input type="hidden" name="user_id" value="{{ \Auth::id() }}">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control form-control-sm" name="title" id="title" placeholder="タイトルを入力してください"
             value="{{ old('title') }}">
            @error ('title')
                <div class="alert-danger my-alert-height px-3 mt-1">
                    {{ $message }}
                </div>
            @enderror
            <label for="category" class="form-label mt-2">Category</label>
            <select class="form-select form-select-sm" name="category">
                @foreach ($codes as $code)
                    <option value="{{ $code->id }}" @if(old('category') == $code->id) selected @endif>{{ $code->name }}</option>
                @endforeach
            </select>
            @error ('category')
                <div class="alert-danger my-alert-height px-3 mt-1">
                    {{ $message }}
                </div>
            @enderror
            <label for="text" class="form-label mt-2">Content</label>
            <textarea class="form-control" name="text" rows="10" placeholder="投稿内容を入力してください">{{ old('text') }}</textarea>
            @error ('text')
                <div class="alert-danger my-alert-height px-3 mt-1">
                    {{ $message }}
                </div>
            @enderror
            <button type="submit" class="btn btn-primary mt-3">Post</button>
        </div>
    </form>
@endsection
