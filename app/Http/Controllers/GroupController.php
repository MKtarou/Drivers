<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    // ページを表示するメソッド
    public function create()
    {
        return view('homebudget.g_make');
    }

    // フォーム送信を処理するメソッド
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:20',
            'password' => 'required|string|max:10',
            'goal' => 'required|integer|min:0',
        ]);

        // データをセッションに保存して確認ページへ
        session([
            'name' => $request->input('name'),
            'password' => $request->input('password'),
            'goal' => $request->input('goal'), // goalをセッションに保存
        ]);

        return redirect()->route('groups.create')->with('confirmation', true);
    }

    // 確認後にデータを保存するメソッド
    public function confirm(Request $request)
    {
        // セッションからデータを取得
        $name = session('name');
        $password = session('password');
        $goal = session('goal');

        // 新しいグループを作成して保存
        $group = new Groups();
        $group->g_name = $name;
        $group->g_pass = $password;
        $group->g_goal = $goal;
        $group->save();

        return redirect()->route('groups.create')->with([
            'complete' => true,
            'name' => $name,
            'password' => $password,
            'goal' => $goal,
        ]);
    }
}


