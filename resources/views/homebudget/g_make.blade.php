<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="{{ asset('css/g_make.css') }}">
    <title>グループの作成</title>
</head>
<body>
    @if(session('confirmation'))
        <!-- グループ作成確認画面 -->
        <div class="creation-container">
            <h1>グループを作成しますか？</h1>
            <form action="{{ route('groups.confirm') }}" method="post" style="display: inline;">
                @csrf
                <input type="hidden" name="name" value="{{ session('name') }}">
                <input type="hidden" name="password" value="{{ session('password') }}">
                <input type="hidden" name="goal" value="{{ session('goal') }}">
                <button type="submit" class="action-button">はい</button>
            </form>
            <a href="{{ route('groups.create') }}" class="action-link">いいえ</a>
        </div>
    @else
        <!-- グループ作成フォーム -->
        <div class="creation-container">
            <h1>グループの作成</h1>
            <form action="{{ route('groups.store') }}" method="post">
                @csrf
                <div class="creation-field-container">
                    <label for="name">名前</label>
                    <input type="text" id="name" name="name" required>
                </div>
                <div class="creation-field-container">
                    <label for="password">パス</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="creation-field-container">
                    <label for="goal">目標金額</label>
                    <input type="number" id="goal" name="goal" required min="0">
                </div>
                <button type="submit" class="action-button">作成</button>
            </form>
        </div>
    @endif
</body>
</html>
