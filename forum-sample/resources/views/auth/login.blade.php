@extends('layouts.common')

@section('title')
    Login
@endsection

@section('main')
<div class="d-flex justify-content-center mt-3">
    <div class="card col-md-6">
        <div class="card-header">
            Please login.
        </div>
        <div class="card-body">
            <form action="{{ route('authenticate') }}" method="post">
                @csrf
                @if (!empty($errors->first('message')))
                    <div class="alert-danger my-alert-height px-3" role="alert">
                        {{ $errors->first('message') }}
                    </div>
                @endif
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="name@example.com">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password" id="password">
                </div>
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
        </div>
    </div>
</div>
@endsection
