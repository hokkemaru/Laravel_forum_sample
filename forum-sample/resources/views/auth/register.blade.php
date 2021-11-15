@extends('layouts.common')

@section('title')
    Register
@endsection

@section('main')
<div class="d-flex justify-content-center mt-3">
    <div class="card col-md-6">
        <div class="card-header">
            Please input areas, and sign up.
        </div>
        <div class="card-body">
            <form action="{{ route('signup') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control form-control-sm" name="name" id="name" placeholder="username" value="{{ old('name') }}">
                    @error('name')
                        <div class="alert-danger my-alert-height px-3" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control form-control-sm" name="email" id="email" placeholder="name@example.com" value="{{ old('email') }}">
                    @error('email')
                        <div class="alert-danger my-alert-height px-3" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="email_confirmation" class="form-label">Email(再入力)</label>
                    <input type="email" class="form-control form-control-sm" name="email_confirmation" id="email_confirmation" placeholder="name@example.com" value="{{ old('email_confirmation') }}">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control form-control-sm" name="password" id="password">
                    @error('password')
                        <div class="alert-danger my-alert-height px-3" role="alert">
                            {{ $message }}
                        </div>
                    @enderror
                </div>
                <div class="mb-3">
                    <label for="password_confirmation" class="form-label">Password(再入力)</label>
                    <input type="password" class="form-control form-control-sm" name="password_confirmation" id="password_confirmation">
                </div>
                <button type="submit" class="btn btn-primary">Sign up</button>
            </form>
        </div>
    </div>
</div>
@endsection
