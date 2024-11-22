<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>グループ参加確認</title>
    <style>
        /* 背景と全体のレイアウト */
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #c6e2ff, #9fd8df, #b6d6a8);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        /* グループ参加コンテナのスタイル */
        .join-confirm-container {
            background-color: #ffffff;
            width: 330px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* タイトルのスタイル */
        .join-confirm-container h1 {
            color: #0d0d0e;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        /* ボタンリンクの共通スタイル */
        .join-button-link {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 100px;
            height: 40px;
            font-size: 16px;
            color: white;
            background-color: #007bff;
            border-radius: 5px;
            text-decoration: none;
            box-sizing: border-box;
            margin: 10px;
            border: none; /* ふちの黒色を消す */
        }

        .join-button-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="join-confirm-container">
        <h1>グループに参加しますか？</h1>
        <div class="join-options">
            <form action="{{ route('participation.complete') }}" method="post" style="display: inline;">
                @csrf
                <input type="hidden" name="name" value="{{ $name }}">
                <input type="hidden" name="password" value="{{ $password }}">
                <button type="submit" class="join-button-link">はい</button>
            </form>
            <a href="{{ route('participation.form') }}" class="join-button-link">いいえ</a>
        </div>
    </div>
</body>
</html>
