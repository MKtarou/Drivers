<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\HomeBudget;
use App\Models\User;

class HomebudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // セッションからグループIDを取得（デフォルトで1とする）
        $groupId = $request->session()->get('group_id', 1);

        // グループに属するユーザーを取得
        $users = User::where('group_id', $groupId)->get();

        // 選択されたグループの収支データを取得
        $homebudgets = HomeBudget::with('category')
            ->where('group_id', $groupId)
            ->orderBy('date', 'desc')
            ->paginate(5);

        $income = HomeBudget::where('group_id', $groupId)
            ->where('category_id', 6) // 収入カテゴリ
            ->sum('price');
        
        $payment = HomeBudget::where('group_id', $groupId)
            ->where('category_id', '!=', 6) // 収入以外
            ->sum('price');

        // カテゴリごとの合計を取得
        $data = DB::table('home_budgets')
            ->join('categories', 'home_budgets.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(home_budgets.price) as total_price'))
            ->where('home_budgets.group_id', $groupId)
            ->groupBy('categories.name')
            ->get();

        //return view('homebudget.index', compact('homebudgets', 'income', 'payment', 'data'));
        return view('homebudget.index', compact('homebudgets', 'income', 'payment', 'data', 'users'));
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
            'category' => 'required|numeric',
            'user_id' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $groupId = $request->session()->get('group_id', 1); // セッションからグループIDを取得

        $result = HomeBudget::create([
            'date' => $request->date,
            'category_id' => $request->category,
            'user_id' => $request->user_id, // ユーザーを選択
            'group_id' => $groupId, // グループIDを設定
            'price' => $request->price
        ]);

        if (!empty($result)) {
            session()->flash('flash_message', '収支を登録しました。');
        } else {
            session()->flash('flash_error_message', '収支を登録できませんでした。');
        }

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

    // public function getCategoryData()
    // {
    //     $data = DB::table('home_budgets')
    //         ->join('categories', 'home_budgets.category_id', '=', 'categories.id')
    //         ->select('categories.name', DB::raw('SUM(home_budgets.price) as total_price'))
    //         ->groupBy('categories.name')
    //         ->get();

    //     return view('homebudget.index', compact('data'));
    // }

}
