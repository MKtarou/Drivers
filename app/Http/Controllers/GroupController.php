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

        // ランダムな6文字の大文字英数字を生成
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        $invitationCode = '';
        for ($i = 0; $i < 6; $i++) {
            $invitationCode .= $characters[rand(0, strlen($characters) - 1)];
        }

        // 新しいグループを作成して保存
        $group = new Groups();
        $group->g_name = $name;
        $group->g_pass = $password;
        $group->g_goal = $goal;
        $group->Invitation_code = $invitationCode; // Invitation_codeを設定
        $group->save();

        // 作成したグループIDをセッションに保存
        session([
            'groupId' => $group->group_id,
        ]);

        // 新規ユーザー登録画面にリダイレクト
        return redirect()->route('user.register.form')->with([
            'success' => 'グループが正常に作成されました。新規ユーザーを登録してください。',
        ]);


        // リメンバー機能をチェック
        if ($request->has('remember_me')) {
            $rememberTime = 60 * 24 * 30; // 30日間（分単位）
            Cookie::queue('groupId', $group->group_id, $rememberTime); // グループIDをクッキーに保存
        }

        
        return redirect()->route('groups.create')->with([
            'complete' => true,
            'name' => $name,
            'password' => $password,
            'goal' => $goal,
            'invitationCode' => $invitationCode, // Invitation_codeをセッションに追加

            
        ]);
    }

}

