<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class UserController extends Controller
{
    /**
     * ユーザー一覧を表示.
     */
    public function index()
    {
        $users = Users::all();
        return view('user.index', compact('users'));
    }

    /**
     * ユーザー作成フォームを表示.
     */
    public function create()
    {
        // セッションからgroup_idを取得
        $groupId = session('groupId');
        if (!$groupId) {
            return redirect()->route('nogroup')->withErrors('グループIDが見つかりません。');
        }

        // ビューをhomebudgetフォルダ内のcreate_user.blade.phpに変更
        return view('homebudget.create_user', compact('groupId'));
    }

    /**
     * 新規ユーザー登録処理
     */
    public function store(Request $request)
    {
        $groupId = session('groupId');
        if (!$groupId) {
            return redirect()->route('nogroup')->withErrors('グループIDが見つかりません。');
        }

        $validated = $request->validate([
            'u_name' => 'required|string|max:20',
            'u_pass' => 'required|string|max:10',
            'u_goal' => 'nullable|numeric',
            'u_limit' => 'nullable|numeric',
            'remember_me' => 'nullable|boolean', // Remember Me のバリデーション
        ]);

        $user = new Users();
        $user->group_id = $groupId;
        $user->u_name = $validated['u_name'];
        $user->u_pass = $validated['u_pass']; 
        $user->u_goal = $validated['u_goal'];
        $user->u_limit = $validated['u_limit'];
        $user->save();

        // Remember Me 機能の処理
        if ($request->filled('remember_me')) {
            $rememberTime = 60 * 24 * 30; // 30日間（分単位）
            Cookie::queue('userId', $user->user_id, $rememberTime); // ユーザーIDを保存
            Cookie::queue('groupId', $groupId, $rememberTime); // グループIDを保存
        }

        session([
            'userId' => $user->user_id,
            'name' => $user->u_name,
            'limit' => $user->u_limit,
            'savings' => $user->u_goal,
        ]);

        return redirect()->route('index')->with('success', '新規ユーザーを追加しました。');
    }

    /**
     * ユーザー編集フォームを表示.
     */
    public function edit($id)
    {
        $user = Users::findOrFail($id);
        return view('user.edit', compact('user'));
    }

    /**
     * ユーザー情報を更新.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'u_name' => 'required|max:255',
            'u_pass' => 'nullable|max:255',
            'group_id' => 'required|numeric',
            'u_goal' => 'nullable|numeric',
        ]);

        $user = Users::findOrFail($id);
        $user->u_name = $request->u_name;
        if ($request->filled('u_pass')) {
            $user->u_pass = bcrypt($request->u_pass);
        }
        $user->group_id = $request->group_id;
        $user->u_goal = $request->u_goal;
        $user->save();

        return redirect()->route('user.index')->with('success', 'ユーザー情報を更新しました。');
    }

    /**
     * ユーザーを削除.
     */
    public function destroy($id)
    {
        $user = Users::findOrFail($id);
        $user->delete();

        return redirect()->route('user.index')->with('success', 'ユーザーを削除しました。');
    }
}
