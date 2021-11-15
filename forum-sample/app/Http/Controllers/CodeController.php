<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Code;
use App\Http\Requests\CodeRequest;

class CodeController extends Controller
{
    public function __construct() {
        $this->middleware('auth');
    }

    public function index() {
        return view('code.index');
    }

    public function create(CodeRequest $request) {
        // コードマスタに既に存在していないかをチェック
        $code = new Code();
        $existing_code = $code->getExistingCode($request->kind, $request->sort);
        // コードマスタに存在した場合はエラー扱いとし、画面を戻す
        if(!$existing_code->isEmpty()) {
            return back()->withErrors(['message' => '既に存在するコードの為、追加できません'],)
                        ->withInput();
        }
        // コードマスタに存在しなかった場合は登録を行う
        Code::create([
            'id' => (int)$request->kind * 100 + (int)$request->sort,
            'kind' => $request->kind,
            'sort' => $request->sort,
            'name' => $request->name,
        ]);
        return redirect(route('code_maintenance'));
    }

    public function update(Request $request) {
        $this->validate($request,[
            'name_edit' . $request->id => 'required|max:100'
        ],[
            'name_edit' . $request->id . '.required' => '名称は入力必須です',
            'name_edit' . $request->id . '.max' => '名称は100文字以内で入力してください',
        ]);
        // コードマスタを更新する
        $code = Code::find($request->id);
        $code->name = $request['name_edit' . $request->id];
        $code->save();
        return redirect(route('code_maintenance'));
    }

    public function destroy(Request $request) {
        // コードマスタを削除する
        $code = Code::find($request->id);
        $code->delete();
        return redirect(route('code_maintenance'));
    }
}
