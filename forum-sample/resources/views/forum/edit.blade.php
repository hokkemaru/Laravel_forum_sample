@extends('layouts.common')

@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/js/submit_common.js"></script>
@endsection

@section('title')
    {{ 'Forum Edit:' . $post->title }}
@endsection

@section('main')
    <form action={{ route('update') }} method="post">
        @csrf
        <div class="form-group mt-3">
            <input type="hidden" name="id" value="{{ $post->id }}">
            <label for="title" class="form-label">Title</label>
            <input type="text" class="form-control form-control-sm" name="title" id="title" value="{{ old('title', $post->title) }}">
            @error ('title')
                <div class="alert-danger my-alert-height px-3 mt-1">
                                {{ $message }}
                </div>
            @enderror
            <label for="category" class="form-label mt-2">Category</label>
            <select class="form-select form-select-sm" name="category">
                @foreach ($codes as $code)
                    <option value="{{ $code->id }}" @if($code->id == old('category' ,$post->category_id)) selected @endif>{{ $code->name }}</option>
                @endforeach
            </select>
            @error ('category')
                <div class="alert-danger my-alert-height px-3 mt-1">
                    {{ $message }}
                </div>
            @enderror
            <label for="text" class="form-label mt-2">Content</label>
            <textarea class="form-control" name="text" rows="10">{{ old('text', $post->text) }}</textarea>
            @error ('text')
                <div class="alert-danger my-alert-height px-3 mt-1">
                    {{ $message }}
                </div>
            @enderror
            <button type="submit" class="btn btn-primary mt-3">Update</button>
        </div>
    </form>
@endsection
