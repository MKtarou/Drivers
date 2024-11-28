<?php

namespace App\Http\Controllers;
use App\Models\HomeBudget;
use App\Models\Groups;
use App\Models\Users;

use Illuminate\Support\Facades\DB;

class CombinedMeterController extends Controller
{
    public function index()
    {
        $groupId = session('groupId', 1); // グループID（例: セッションから取得）
        $userId = session('userId', 1);  // ユーザーID（例: セッションから取得）

        // グループ情報を取得
        $group = Groups::where('group_id', $groupId)->first();
        $g_name = $group->g_name;
        $g_goal = $group->g_goal;
        $g_limit = $group->g_limit;
        $g_savings = $group->g_savings;


        // ユーザー情報を取得
        $user = Users::where('user_id', $userId)->first();
        $u_name = $user->u_name;
        $u_goal = $user->u_goal;
        $u_limit = $user->u_limit;
        $u_savings = $user->u_savings;

        // グループ収支
        $income = HomeBudget::where('group_id', $groupId)
            ->where('price', '>', 0)
            ->sum('price');

        $payment = abs(HomeBudget::where('group_id', $groupId)
            ->where('price', '<', 0)
            ->sum('price'));

        // 個人の収支データ
        $personalIncome = DB::table('home_budgets')
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->where('price', '>', 0)
            ->sum('price');

        $personalExpense = DB::table('home_budgets')
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->where('price', '<', 0)
            ->sum('price');

        $personalCategories = DB::table('home_budgets')
            ->join('categories', 'home_budgets.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(home_budgets.price) as total_price'))
            ->where('home_budgets.group_id', $groupId)
            ->where('home_budgets.user_id', $userId)
            ->groupBy('categories.name')
            ->get();

        // チームの収支データ
        $teamIncome = DB::table('home_budgets')
            ->where('group_id', $groupId)
            ->where('price', '>', 0)
            ->sum('price');

        $teamExpense = DB::table('home_budgets')
            ->where('group_id', $groupId)
            ->where('price', '<', 0)
            ->sum('price');

        $teamCategories = DB::table('home_budgets')
            ->join('categories', 'home_budgets.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(home_budgets.price) as total_price'))
            ->where('home_budgets.group_id', $groupId)
            ->groupBy('categories.name')
            ->get();

        // ビューにデータを渡す
        return view('homebudget.combined_meter', compact(
            'personalIncome', 'personalExpense', 'personalCategories',
            'teamIncome', 'teamExpense', 'teamCategories',
            'income', 'payment', 'g_name', 'u_name', 'u_goal', 'u_limit', 'g_goal', 'g_limit',
            'u_savings', 'g_savings'
        ));
    }


}
