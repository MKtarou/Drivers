<?php

namespace App\Http\Controllers;
use App\Models\HomeBudget;
use App\Models\Groups;
use App\Models\Users;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CombinedMeterController extends Controller
{
    //セッションチェック
    public function __construct()
    {
        $this->middleware('checkGroupAndUser');
    }

    public function index(Request $request)
    {
        $groupId = session('groupId'); // グループID
        $userId = session('userId');   // ユーザーID

        $activeTab = $request->query('tab', 'personal');

        // リクエストから月と年を取得（デフォルトは現在の月と年）
        $month = $request->query('month', date('m'));
        $year = $request->query('year', date('Y'));

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

        // 個人の収支データ（指定された月と年でフィルタリング）
        $personalIncome = DB::table('home_budgets')
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->where('price', '>', 0)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('price');

        $personalExpense = DB::table('home_budgets')
            ->where('group_id', $groupId)
            ->where('user_id', $userId)
            ->where('price', '<', 0)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('price');

        $personalCategories = DB::table('home_budgets')
            ->join('categories', 'home_budgets.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(home_budgets.price) as total_price'))
            ->where('home_budgets.group_id', $groupId)
            ->where('home_budgets.user_id', $userId)
            ->whereMonth('home_budgets.date', $month)
            ->whereYear('home_budgets.date', $year)
            ->groupBy('categories.name')
            ->get();

        // チームの収支データ（指定された月と年でフィルタリング）
        $teamIncome = DB::table('home_budgets')
            ->where('group_id', $groupId)
            ->where('price', '>', 0)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('price');

        $teamExpense = DB::table('home_budgets')
            ->where('group_id', $groupId)
            ->where('price', '<', 0)
            ->whereMonth('date', $month)
            ->whereYear('date', $year)
            ->sum('price');

        $teamCategories = DB::table('home_budgets')
            ->join('categories', 'home_budgets.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(home_budgets.price) as total_price'))
            ->where('home_budgets.group_id', $groupId)
            ->whereMonth('home_budgets.date', $month)
            ->whereYear('home_budgets.date', $year)
            ->groupBy('categories.name')
            ->get();

        // ビューにデータを渡す
        return view('homebudget.combined_meter', compact(
            'activeTab',
            'personalIncome', 'personalExpense', 'personalCategories',
            'teamIncome', 'teamExpense', 'teamCategories',
            'g_name', 'u_name', 'u_goal', 'u_limit', 'g_goal', 'g_limit',
            'u_savings', 'g_savings', 'month', 'year'
        ));
    }


    public function addPersonalSaving(Request $request)
    {
        // バリデーション
        $request->validate([
            'addedSaving' => 'required|integer',  //|min:1',
            'month' => 'required|integer',
            'year' => 'required|integer'
        ]);

        $userId = session('userId');
        $user = Users::find($userId);
        if (!$user) {
            return redirect()->route('nogroup')->withErrors('ユーザーが見つかりません');
        }

        // 既存のu_savingsに加算
        $addedAmount = (int)$request->input('addedSaving');
        $user->u_savings = $user->u_savings + $addedAmount;  // 負の値なら減額
        $user->save();

        // month, yearを維持してリダイレクト
        return redirect()->route('combined.meter', [
            'month' => $request->input('month'),
            'year' => $request->input('year')
        ])->with('flash_message', '貯金額を追加しました。');
    }


    public function addGroupSaving(Request $request)
    {
        $request->validate([
            'groupAddedSaving' => 'required|integer',
            'month' => 'required|integer',
            'year' => 'required|integer',
            'tab' => 'nullable|string' // 追加
        ]);

        $groupId = session('groupId');
        $group = Groups::find($groupId);
        if (!$group) {
            return redirect()->route('nogroup')->withErrors('グループが見つかりません');
        }

        // 貯金額の更新
        $addedAmount = (int)$request->input('groupAddedSaving');
        $group->g_savings += $addedAmount; 
        $group->save();

        // tabパラメータを維持してリダイレクト
        return redirect()->route('combined.meter', [
            'month' => $request->input('month'),
            'year' => $request->input('year'),
            'tab' => $request->input('tab') ?? 'team'
        ])->with('flash_message', 'グループ貯金額を追加しました。');
    }

}
