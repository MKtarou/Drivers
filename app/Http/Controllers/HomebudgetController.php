<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\HomeBudget;
use App\Models\Groups;
use App\Models\Users;

class HomebudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groupId = session('groupId'); // この ID は適宜動的に設定するか、セッションなどで管理する
        $userId = session('userId'); // これでセッションからユーザーIDを取得できます

        // グループを取得
        $group = Groups::where('group_id', $groupId)->first();

        // グループが存在しない場合は `nogroup` ビューを表示
        if (!$group) {
            return view('homebudget.nogroup');
        }

        $groupName = $group->g_name;

        $users = Users::where('group_id', $groupId)->get();

        $homebudgets = HomeBudget::with(['category', 'user'])
            ->where('group_id', $groupId)
            ->orderBy('date', 'desc')
            ->paginate(10);

        // 収入合計と支出合計の取得
        $income = HomeBudget::where('group_id', $groupId)
            ->where('price', '>', 0)
            ->sum('price');
        
        $payment = abs(HomeBudget::where('group_id', $groupId)
            ->where('price', '<', 0)
            ->sum('price'));

        // カテゴリ別のデータ
        $data = DB::table('home_budgets')
            ->join('categories', 'home_budgets.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(home_budgets.price) as total_price'))
            ->where('home_budgets.group_id', $groupId)
            ->groupBy('categories.name')
            ->get();

        $categories = Category::all();

        // ビューにデータを渡す
        return view('homebudget.index', compact('homebudgets', 'income', 'payment', 'data', 'users', 'categories', 'groupName'));
    }





    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'user_id' => 'required|numeric',
            'price' => 'required|numeric',
            'transaction_type' => 'required|string',
            'details' => 'nullable|string',
            'category' => 'required_if:transaction_type,expense|numeric'
        ]);

        $groupId = 1;
        $request->session()->put('group_id', $groupId);

        $homeBudget = new HomeBudget();
        $homeBudget->date = $request->date;
        $homeBudget->group_id = $groupId;
        $homeBudget->user_id = $request->user_id;
        $homeBudget->price = $request->transaction_type === 'income' ? $request->price : -$request->price;
        $homeBudget->details = $request->details;

        // 支出の時のみカテゴリIDを保存
        if ($request->transaction_type === 'expense') {
            $homeBudget->category_id = $request->category;
        }

        $result = $homeBudget->save();
        session()->flash('flash_message', $result ? '収支を登録しました。' : '収支を登録できませんでした。');
        return redirect('/');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $homebudget = HomeBudget::find($id);
        return view('homebudget.edit', compact('homebudget'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'date' => 'required|date',
            'category_id' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $hasData = HomeBudget::where('id', '=', $request->id);
        if ($hasData->exists()) {
            $hasData->update([
                'date' => $request->date,
                'category_id' => $request->category_id,
                'price' => $request->price
            ]);
            session()->flash('flash_message', '収支を更新しました。');
        } else {
            session()->flash('flash_error_message', '収支を更新できませんでした。');
        }
    
        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $homebudget = HomeBudget::find($id);
        $homebudget->delete();
        session()->flash('flash_message', '収支を削除しました。');
        return redirect('/');
    }


    public function dashboard(Request $request)
    {
        $groupId = 1; // セッションからグループIDを取得または固定
        $group = Groups::where('group_id', $groupId)->first();

        $groupName = $group ? $group->g_name : 'グループ名不明';

        // 個人とグループの収支データを取得
        $individualIncome = HomeBudget::where('group_id', $groupId)->where('price', '>', 0)->sum('price');
        $individualExpense = HomeBudget::where('group_id', $groupId)->where('price', '<', 0)->sum('price');

        $groupIncome = $individualIncome; // 例：グループと個人でデータを分ける場合は適切に設定
        $groupExpense = $individualExpense;

        return view('homebudget.dashboard', compact('groupName', 'individualIncome', 'individualExpense', 'groupIncome', 'groupExpense'));

    }


    public function calendar(Request $request)
    {
        $currentMonth = $request->query('month', date('m'));
        $currentYear = $request->query('year', date('Y'));

        $transactions = DB::table('home_budgets as hb')
            ->join('users as u', 'hb.user_id', '=', 'u.user_id')
            ->selectRaw('DAY(hb.date) as day,
                         SUM(CASE WHEN hb.price > 0 THEN hb.price ELSE 0 END) as total_income,
                         SUM(CASE WHEN hb.price < 0 THEN hb.price ELSE 0 END) as total_expenditure,
                         hb.details,
                         u.u_name as user_name')
            ->whereMonth('hb.date', $currentMonth)
            ->whereYear('hb.date', $currentYear)
            ->groupBy('day', 'hb.details', 'u.u_name')
            ->get();

        $totalIncome = $transactions->sum('total_income');
        $totalExpenditure = abs($transactions->sum('total_expenditure'));

        // トランザクションを日付ごとに整形する
        $groupedTransactions = [];
        foreach ($transactions as $transaction) {
            $day = $transaction->day;
            $groupedTransactions[$day][] = [
                'total_income' => (int)$transaction->total_income,
                'total_expenditure' => (int)$transaction->total_expenditure,
                'details' => $transaction->details,
                'user_name' => $transaction->user_name,
            ];
        }

        return view('Homebudget.calendar', [
            'transactions' => $groupedTransactions,
            'totalIncome' => $totalIncome,
            'totalExpenditure' => $totalExpenditure,
            'currentMonth' => $currentMonth,
            'currentYear' => $currentYear,
        ]);
    }

    public function balance(Request $request)
    {
        $month = $request->query('month', date('m'));
        $year = $request->query('year', date('Y'));

        // 月ごとの収支を取得
        $entries = DB::table('home_budgets as hb')
            ->join('users as u', 'hb.user_id', '=', 'u.user_id')
            ->selectRaw("DATE_FORMAT(hb.date, '%Y/%m/%d') as date, hb.price, hb.details, u.u_name as user_name")
            ->whereMonth('hb.date', $month)
            ->whereYear('hb.date', $year)
            ->get();

        $totalIncome = $entries->filter(fn($entry) => $entry->price > 0)->sum('price');
        $totalExpenditure = $entries->filter(fn($entry) => $entry->price < 0)->sum('price');
        $balance = $totalIncome + $totalExpenditure;

        return view('Homebudget.balance', compact('entries', 'totalIncome', 'totalExpenditure', 'balance', 'month', 'year'));
    }

    // public function getCategoryData()
    // {
    //     $data = DB::table('home_budgets')
    //         ->join('categories', 'home_budgets.category_id', '=', 'categories.id')
    //         ->select('categories.name', DB::raw('SUM(home_budgets.price) as total_price'))
    //         ->groupBy('categories.name')
    //         ->get();

    //     return view('homebudget.index', compact('data'));
    // }

    // 参加フォームを表示
    public function participation_form()
    {
        return view('homebudget.participation_form');
    }

    // 確認画面を表示
    public function participation_confirm(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'password' => 'required|string|max:255',
        ]);

        return view('homebudget.participation_confirm', [
            'name' => $validated['name'],
            'password' => $validated['password'],
        ]);
    }

    // 完了画面を表示
    public function participation_complete(Request $request){
        // 入力データを検証
        $validated = $request->validate([
            'name' => 'required|string|max:20', // グループ名
            'password' => 'required|string|max:10', // パスワード
        ]);

        // グループを検索
        $group = \App\Models\Groups::where('g_name', $validated['name'])
            ->where('g_pass', $validated['password'])
            ->first();

            if (!$group) {
                // グループが見つからない場合はエラーを返す
                return redirect()->route('participation_form')
                    ->withErrors(['group' => 'グループ名またはパスワードが間違っています。']);
            }

        // グループIDをセッションに保存
        session(['groupId' => $group->group_id]);

        // グループに属するユーザーを取得
        $users = Users::where('group_id', $group->group_id)->get();

        // 完了画面でユーザーを選択させる
        return view('homebudget.participation_complete', [
            'name' => $group->g_name,
            'users' => $users,
        ]);
    }

    // TOP遷移時にユーザーをセッションに保存
    public function participation_save_user(Request $request){
        // 選択されたユーザーIDを検証
        $validated = $request->validate([
            'user_id' => 'required|exists:users,user_id', // ユーザーIDが存在するか確認
        ]);

        // ユーザーIDをセッションに保存
        session(['userId' => $validated['user_id']]);

        // TOPページへリダイレクト
        return redirect()->route('index')->with('flash_message', 'ユーザーが選択されました。');
    }

}
