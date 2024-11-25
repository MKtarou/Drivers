<?php

namespace App\Http\Controllers;

use App\Models\Groups;
use Illuminate\Http\Request;

class InvitationController extends Controller
{
    public function show($groupId)
    {
        $groupId = 1; // グループIDを取得するロジック
        return view('homebudget.sidebar', compact('groupId'));

        // グループが存在するか確認
        if (!$group) {
            return redirect()->back()->with('error', '指定されたグループが見つかりませんでした。');
        }

        // 招待コードを取得
        $invitationCode = $group->Invitation_code;

        return view('homebudget.invitationCode', [
            'invitationCode' => $invitationCode,
            'groupName' => $group->g_name, // グループ名を渡す
        ]);
    }
}
