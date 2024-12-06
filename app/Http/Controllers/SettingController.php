<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Groups;
use App\Models\Users;

class SettingController extends Controller
{

    //セッションチェック
    public function __construct()
    {
        $this->middleware('checkGroupAndUser');
    }

    public function index()
    {
        return view('Homebudget.setting');
    }

    public function updatePersonal(Request $request)
    {
        $validated = $request->validate([
            'u_name' => 'required|string|max:20',
            'u_limit' => 'required|numeric',
            'u_goal' => 'required|numeric',
        ]);

        $userId = session('userId');
        $user = Users::find($userId);

        if ($user) {
            // データベースを更新
            $user->update($validated);

            // 更新後の値をセッションに保存
            session([
                'name' => $user->u_name,
                'limit' => $user->u_limit,
                'savings' => $user->u_goal,
            ]);

            session()->flash('success', '個人設定を更新しました。');
        } else {
            session()->flash('error', 'ユーザーが見つかりませんでした。');
        }

        return redirect()->route('setting.index');
    }


    public function updateGroup(Request $request)
    {
        $validated = $request->validate([
            'g_name' => 'required|string|max:20',
            'g_limit' => 'required|numeric',
            'g_goal' => 'required|numeric',
        ]);

        $groupId = session('groupId');
        $group = Groups::find($groupId);

        if ($group) {
            // データベースを更新
            $group->update($validated);

            // 更新後の値をセッションに保存
            session([
                'group_name' => $group->g_name,
                'group_limit' => $group->g_limit,
                'group_savings' => $group->g_goal,
            ]);

            session()->flash('success', 'グループ設定を更新しました。');
        } else {
            session()->flash('error', 'グループが見つかりませんでした。');
        }

        return redirect()->route('setting.index');
    }

}
