<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <title>新規ユーザー登録</title>
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

        .registration-container {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            width: 350px;
            text-align: center;
        }

        .registration-container h1 {
            font-size: 1.8em;
            margin-bottom: 20px;
            color: #9b59b6;
        }

        .registration-container form {
            display: flex;
            flex-direction: column;
            align-items: stretch;
        }

        .registration-container input[type="text"],
        .registration-container input[type="password"],
        .registration-container input[type="number"] {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .registration-container label {
            display: flex;
            align-items: center;
            font-size: 14px;
            margin-bottom: 15px;
            color: #333;
        }

        .registration-container label input[type="checkbox"] {
            margin-right: 5px;
        }

        .registration-container button {
            padding: 10px;
            background-color: #9b59b6;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .registration-container button:hover {
            background-color: #7d3c98;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h1>新規ユーザー登録</h1>
        <form action="{{ route('user.register') }}" method="POST">
            @csrf
            <input type="text" name="u_name" placeholder="ユーザー名" required>
            <input type="password" name="u_pass" placeholder="パスワード" required>
            <input type="number" name="u_goal" placeholder="目標金額" required>
            <input type="number" name="u_limit" placeholder="月限度額" required>
            <label>
                <input type="checkbox" name="remember_me" value="1">
                30日間ログイン情報を保持する
            </label>
            <button type="submit">登録</button>
        </form>
    </div>
</body>
</html>
