<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <link rel="stylesheet" href="{{ asset('css/balance.css') }}">
    <link rel="icon" href="{{ asset('icons/favicon.ico') }}" type="image/x-icon">

    <title>月別収支詳細</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f0fc;
            color: #333;
            margin: 0;
        }

        .details-container {
            background-color: #fff;
            border: 1px solid #9b59b6;
            padding: 20px;
            width: 80%;
            max-width: 600px;
            margin: 50px auto;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1 {
            font-size: 24px;
            margin-bottom: 20px;
            color: #333;
        }

        .controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
        }

        .control-btn {
            text-decoration: none;
            background: none;
            border: 2px solid #9b59b6;
            padding: 5px 10px;
            border-radius: 4px;
            color: #9b59b6;
            transition: background-color 0.3s, color 0.3s;
            cursor: pointer;
        }

        .control-btn:hover {
            background-color: #9b59b6;
            color: #fff;
        }

        .summary {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            gap: 10px;
        }

        .summary .income, .summary .expenditure {
            flex: 1;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            color: #fff;
            border-radius: 6px;
            border: 1px solid #9b59b6;
            text-align: center;
        }

        .income {
            background-color: #9b59b6;
        }

        .expenditure {
            background-color: #e34b5f;
        }

        .balance {
            font-size: 20px;
            margin: 20px 0;
            font-weight: bold;
            color: #333;
        }

        .entry {
            display: flex;
            justify-content: space-between;
            padding: 10px 0;
            border-bottom: 1px solid #ddd;
            font-size: 14px;
            text-align: left;
        }

        .entry .date,
        .entry .user,
        .entry .amount,
        .entry .category,
        .entry .details {
            width: 20%;
        }

        .income-amount {
            color: #0072b2;
        }

        .expenditure-amount {
            color: red;
        }

        .pagination {
            list-style: none;
            display: flex;
            margin: 10px 0;
        }

        .pagination li {
            margin-right: 5px;
        }

        .pagination li a {
            padding: 8px 12px;
            text-decoration: none;
            background-color: #9b59b6;
            color: #fff;
            border-radius: 4px;
        }

        .pagination li a:hover {
            background-color: #7d3c98;
        }

        /* ユーザー選択フォーム用のスタイル */
        .filter-form {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-bottom: 20px;
        }

        .filter-form select {
            border: 2px solid #9b59b6;
            border-radius: 4px;
            padding: 5px 10px;
            font-size: 14px;
            background-color: #fff;
            color: #333;
            transition: border-color 0.3s;
            cursor: pointer;
        }

        .filter-form select:focus {
            border-color: #7d3c98;
            outline: none;
        }

        .filter-form button.control-btn {
            margin: 0;
        }

    </style>
</head>
<body>
    @include('homebudget.sidebar')
    <div class="details-container">
        <h1>{{ $year }}年 {{ $month }}月の収支</h1>

        <div class="controls">
            <a href="{{ route('balance', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}" class="control-btn">◀ 前月</a>
            <a href="{{ route('balance', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}" class="control-btn">次月 ▶</a>
        </div>

        <!-- ユーザー選択フォーム -->
        <form action="{{ route('balance') }}" method="GET" class="filter-form">
            <input type="hidden" name="month" value="{{ $month }}">
            <input type="hidden" name="year" value="{{ $year }}">
            <select name="user_id">
                <option value="">全ユーザー</option>
                @foreach($users as $user)
                    <option value="{{ $user->user_id }}" {{ request('user_id') == $user->user_id ? 'selected' : '' }}>
                        {{ $user->u_name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="control-btn">絞り込み</button>
        </form>

        <div class="summary">
            <div class="income">+ {{ number_format($totalIncome) }} 円</div>
            <div class="expenditure">- {{ number_format(abs($totalExpenditure)) }} 円</div>
        </div>
        <div class="balance">計 {{ number_format($balance) }} 円</div>

        <div class="entry" style="font-weight:bold;">
            <div class="date">日付</div>
            <div class="user">追加者</div>
            <div class="category">カテゴリ</div>
            <div class="details">詳細</div>
            <div class="amount">金額</div>
        </div>

        @foreach ($entries as $entry)
            <div class="entry">
                <div class="date">{{ $entry->date }}</div>
                <div class="user">{{ htmlspecialchars($entry->user_name) }}</div>
                <div class="category">
                    @if ($entry->price < 0)
                        {{ htmlspecialchars($entry->category_name) }}
                    @else
                        収入
                    @endif
                </div>
                <div class="details">{{ htmlspecialchars($entry->details) }}</div>
                <div class="amount">
                    @if ($entry->price > 0)
                        <span class="income-amount">+ {{ number_format($entry->price) }}</span>
                    @else
                        <span class="expenditure-amount">- {{ number_format(abs($entry->price)) }}</span>
                    @endif
                </div>
            </div>
        @endforeach

        <div class="pagination">
            {{ $entries->appends(['month' => $month, 'year' => $year, 'user_id' => request('user_id')])->links() }}
        </div>
    </div>
</body>
</html>
