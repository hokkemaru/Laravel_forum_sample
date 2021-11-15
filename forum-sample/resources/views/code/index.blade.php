@extends('layouts.common')

@section('javascript')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="/js/submit_common.js"></script>
@endsection

@section('title')
    Code Maintenance
@endsection

@section('main')
    {{--@if(\Auth::user()->role_id ==
        \App\Models\Code::select('id')->where('code','ROLE')->where('sort',2)->first()->id)--}}
    @can('isAdmin')
        <div class="mt-3">
            <form action="{{ route('code_create') }}" method="post">
                @csrf
                <table class="table my-table">
                    <thead>
                        <tr>
                            <th class="col my-col">kind</th>
                            <th class="col my-col">sort</th>
                            <th class="col my-col">name</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="my-col">
                                <select class="form-select form-select-sm" name="kind">
                                    @foreach ($kinds as $kind)
                                        <option value="{{ $kind->kind }}" @if(old('kind') == $kind->kind) selected @endif>{{ $kind->name }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td class="my-col">
                                <input type="text" class="form-control form-control-sm" name="sort" id="sort" value="{{ old('sort') }}">
                            </td>
                            <td class="my-col">
                                <input type="text" class="form-control form-control-sm" name="name" id="name" value="{{ old('name') }}">
                            </td>
                        </tr>
                    </tbody>
                </table>
                <button type="submit" class="btn btn-primary">Register</button>
            </form>
            @foreach($errors->all() as $error)
                <div class="alert-danger my-alert-height px-3 mt-1">
                    {{ $error }}
                </div>
            @endforeach
        </div>
        <div class="mt-3">
            <table class="table my-table-edit">
                <thead>
                    <tr>
                        <th class="col my-col">kind</th>
                        <th class="col my-col">sort</th>
                        <th class="col my-col">name</th>
                        <th class="col">edit</th>
                        <th class="col">delete</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($codes as $code)
                        <tr>
                            <td class="col my-col">
                                {{ $code->codeKind->name }}
                            </td>
                            <td class="col my-col">
                                {{ $code->sort }}
                            </td>
                            <td class="col my-col" colspan="2">
                                <form action="{{ route('code_update') }}" method="post" class="row row-cols-lg-auto g-3 align-items-left">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $code->id }}">
                                    <div class="form-group">
                                        <input type="text" class="form-control form-control-sm" name="{{'name_edit'. $code->id }}" id="{{'name_edit'. $code->id }}" value="{{ old('name_edit' . $code->id, $code->name) }}">
                                    </div>
                                        <button type="submit" class="btn btn-primary">Edit</button>
                                </form>
                            </td>
                            <td class="col">
                                <form action="{{ route('code_destroy') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $code->id }}">
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            {{ $codes->links() }}
        </div>
    @else
        <p class="text-center mt-3">権限がありません。</p>
        <p class="text-center mt-3">管理者権限でアクセスしてください。</p>
    {{--@endif--}}
    @endcan
@endsection
