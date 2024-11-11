<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

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
        return view('user.create');
    }

    /**
     * 新しいユーザーを保存.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'u_name' => 'required|max:255',
            'u_pass' => 'required|max:255',
            'group_id' => 'required|numeric',
            'u_goal' => 'nullable|numeric',
        ]);

        User::create([
            'u_name' => $request->u_name,
            'u_pass' => bcrypt($request->u_pass), // パスワードをハッシュ化
            'group_id' => $request->group_id,
            'u_goal' => $request->u_goal,
        ]);

        return redirect()->route('user.index')->with('success', 'ユーザーを作成しました。');
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
