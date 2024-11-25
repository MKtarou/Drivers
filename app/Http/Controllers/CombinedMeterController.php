<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class CombinedMeterController extends Controller
{
    public function index()
    {
        $groupData = DB::table('groups')->first();
        $userData = DB::table('users')->first();
        $groupBalances = DB::table('group_balances')->get();
        $userBalances = DB::table('user_balances')->get();

        // 個人データ (仮に categories テーブルを使用)
        $personalData = [
            'categories' => DB::table('categories')->get()->toArray(), // categories テーブル全データ取得
        ];

        // ビューへデータを渡す
        return view('homebudget.combined_meter', compact(
            'groupData', 'userData', 'groupBalances', 'userBalances', 'personalData'
        ));
    }
}
