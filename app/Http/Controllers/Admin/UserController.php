<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon; // 追加

class UserController extends Controller
{
    /**
     * ユーザー一覧ページに遷移
     */
    public function index()
    {
        $users = \App\Models\User::whereNull('deleted_at')->get();
        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * ユーザー作成ページに遷移
     */
    public function showCreatePage(Request $request)
    {
        $user = new \App\Models\User;
        return view('admin.user.edit', ['user' => $user, 'create_flag' => true]);
    }

    /**
     * ユーザーを作成
     */
    public function create(Request $request)
    {
        // バリデーション
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email',
            'password' => 'required|max:255',
        ];
        $this->validate($request, $rules);

        DB::transaction(function () use ($request) {
            $users = new \App\Models\User;
            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = Hash::make($request->password);

            if ($request->admin_flg) {
                $users->admin_flg = true;
                // チェックボックスのnull(未チェック)を0にしてDBに保存
            } else {
                $users->admin_flg = false;
            }
            $users->save();
        });

        session()->flash('status', 'ユーザーの作成が完了しました');
        $users = \App\Models\User::whereNull('deleted_at')->get();
        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * 更新ページに遷移処理
     */
    public function showUpdatePage(Request $request)
    {
        // idがとれる
        $user_id = $request->user_id;
        $user = \App\Models\User::find($user_id);
        return view('admin.user.edit', ['user' => $user, 'create_flag' => false]);
    }

    /**
     * ユーザー更新処理
     */
    public function update(Request $request)
    {
        // バリデーション
        $rules = [
            'name' => 'required|max:255',
            'email' => 'required|max:255|unique:users,email,' . $request->user_id . ',id',
            'password' => 'required|max:255',
        ];
        $this->validate($request, $rules);

        DB::transaction(function () use ($request) {
            $users = \App\Models\User::find($request->user_id);
            $users->name = $request->name;
            $users->email = $request->email;
            $users->password = Hash::make($request->password);

            if ($request->admin_flg) {
                $users->admin_flg = true;
                // チェックボックスのnull(未チェック)を0にしてDBに保存
            } else {
                $users->admin_flg = false;
            }
            $users->save();
        });


        session()->flash('status', 'ユーザーの編集が完了しました');
        $users = \App\Models\User::whereNull('deleted_at')->get();
        return view('admin.user.index', ['users' => $users]);
    }

    /**
     * ユーザー削除処理
     */
    public function destroy(Request $request)
    {
        // delete_atをonにする
        DB::transaction(function () use ($request) {
            $user_id = $request->user_id;
            $users = \App\Models\User::where('id', $user_id)->first();
            $users->deleted_at = Carbon::now();
            $users->save();
        });

        $users = \App\Models\User::whereNull('deleted_at')->get();
        session()->flash('status', 'ユーザーを削除しました');
        return view('admin.user.index', ['users' => $users]);
    }
}
