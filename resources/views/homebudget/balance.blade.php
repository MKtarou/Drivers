<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/balance.css') }}">
    <title>月別収支詳細</title>
</head>
<body>
    @include('homebudget.sidebar')
    <div class="details-container">
        <h1>{{ $year }}年 {{ $month }}月の収支</h1>

        <!-- 前月と次月のボタン -->
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
