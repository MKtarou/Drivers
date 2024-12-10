<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="{{ asset('css/g_make.css') }}">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <title>グループの作成</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f0fc;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .creation-container {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            width: 330px;
            text-align: center;
        }

        .creation-container h1 {
            font-size: 1.8em;
            color: #9b59b6;
            margin-bottom: 20px;
        }

        .creation-field-container {
            text-align: left;
            margin-bottom: 15px;
        }

        .creation-field-container label {
            display: block;
            margin-bottom: 5px;
            font-size:14px;
        }

        .creation-field-container input[type="text"],
        .creation-field-container input[type="password"],
        .creation-field-container input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        .action-button, .action-link, .creation-container button[type="submit"] {
            display: inline-block;
            width: 80%;
            background-color: #9b59b6;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 1.1em;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin-top: 20px;
        }

        .action-button:hover, .action-link:hover, .creation-container button[type="submit"]:hover {
            background-color: #7d3c98;
        }

        .creation-container input[type="checkbox"] {
            margin-right: 5px;
        }
    </style>
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
            <a href="{{ route('groups.create') }}" class="action-link" style="display:inline-block;">いいえ</a>
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
                <label style="font-size:14px;">
                    <input type="checkbox" name="remember_me" value="1"> 30日間ログイン情報を保持する
                </label>
                <button type="submit" class="action-button">作成</button>
            </form>
        </div>
    @endif
</body>
</html>
