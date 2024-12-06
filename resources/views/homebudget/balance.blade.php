<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
        .entry .category {
            width: 20%;
        }

        .entry .category {
            width: 40%;
        }

        .income-amount {
            color: #0072b2;
        }

        .expenditure-amount {
            color: red;
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

        <div class="summary">
            <div class="income">+ {{ number_format($totalIncome) }} 円</div>
            <div class="expenditure">- {{ number_format(abs($totalExpenditure)) }} 円</div>
        </div>
        <div class="balance">計 {{ number_format($balance) }} 円</div>

        @foreach ($entries as $entry)
            <div class="entry">
                <div class="date">{{ $entry->date }}</div>
                <div class="user">{{ htmlspecialchars($entry->user_name) }}</div>
                <div class="amount">
                    @if ($entry->price > 0)
                        <span class="income-amount">+ {{ number_format($entry->price) }}</span>
                    @else
                        <span class="expenditure-amount">- {{ number_format(abs($entry->price)) }}</span>
                    @endif
                </div>
                <div class="category">{{ htmlspecialchars($entry->details) }}</div>
            </div>
        @endforeach
    </div>
</body>
</html>
