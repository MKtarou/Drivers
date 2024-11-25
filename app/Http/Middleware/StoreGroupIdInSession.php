<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StoreGroupIdInSession
{
    /**
     * ハンドルメソッドを実行する.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // ユーザーがログインしている場合にグループIDをセッションに保存
        if (Auth::check()) {
            $user = Auth::user();
            session(['group_id' => $user->group_id]);
        }

        return $next($request);
    }
}

