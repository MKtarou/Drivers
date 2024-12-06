<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckGroupAndUser
{
    public function handle(Request $request, Closure $next)
    {
        if (!session('groupId') || !session('userId')) {
            return redirect()->route('nogroup'); // 未参加画面へリダイレクト
        }

        return $next($request);
    }
}
