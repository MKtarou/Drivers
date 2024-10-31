<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Category;
use App\Models\HomeBudget;
use App\Models\Group;
use App\Models\User;

class HomebudgetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $groupId = 1;

        // `group_id` カラムを指定して取得
        $group = Group::where('group_id', $groupId)->first();

        $groupName = $group ? $group->g_name : 'グループ名不明';

        $users = User::where('group_id', $groupId)->get();

        $homebudgets = HomeBudget::with(['category', 'user']) 
            ->where('group_id', $groupId)
            ->orderBy('date', 'desc')
            ->paginate(5);

        // 収入合計と支出合計の取得
        $income = HomeBudget::where('group_id', $groupId)
            ->where('price', '>', 0)
            ->sum('price');
        
        $payment = HomeBudget::where('group_id', $groupId)
            ->where('price', '<', 0)
            ->sum('price');
        $payment = abs($payment);

        $data = DB::table('home_budgets')
            ->join('categories', 'home_budgets.category_id', '=', 'categories.id')
            ->select('categories.name', DB::raw('SUM(home_budgets.price) as total_price'))
            ->where('home_budgets.group_id', $groupId)
            ->groupBy('categories.name')
            ->get();

        $categories = Category::all();

        // ビューにグループ名を渡す
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
