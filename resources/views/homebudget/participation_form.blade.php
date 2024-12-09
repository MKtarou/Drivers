<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <title>グループへ参加</title>
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
        .join-group-container {
            background-color: #ffffff;
            width: 330px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* タイトルのスタイル */
        .join-group-container h1 {
            color: #0d0d0e;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        /* 入力フィールドグループのスタイル */
        .join-input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        /* ラベルのスタイル */
        .join-input-group label {
            color: #090909;
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        /* テキストボックスのスタイル */
        .join-input-group input[type="text"],
        .join-input-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #007BFF;
            border-radius: 5px;
            font-size: 1em;
            color: #000;
            box-sizing: border-box;
        }

        /* ボタンのスタイル */
        button {
            background-color: #007BFF;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            width: 100%;
        }

        button:hover {
            background-color: #6a1b9a;
        }
    </style>
</head>
<body>
    <div class="join-group-container">
        <h1>グループへ参加</h1>
        @if($errors->has('group'))
            <p style="color: red;">{{ $errors->first('group') }}</p>
        @endif
        <form action="{{ route('participation.complete') }}" method="post">
            @csrf
            <div>
                <label for="name">グループ名</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div>
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">参加</button>
        </form>
    </div>
</body>
</html>
