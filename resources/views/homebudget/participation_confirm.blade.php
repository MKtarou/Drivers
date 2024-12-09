<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <title>グループ参加確認</title>
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

        .join-confirm-container {
            background-color: #fff;
            width: 330px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .join-confirm-container h1 {
            color: #9b59b6;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .join-button-link, .join-confirm-container button[type="submit"] {
            display: inline-flex;
            justify-content: center;
            align-items: center;
            width: 100px;
            height: 40px;
            font-size: 16px;
            color: white;
            background-color: #9b59b6;
            border-radius: 5px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            margin: 10px;
            transition: background-color 0.3s;
        }

        .join-button-link:hover, .join-confirm-container button[type="submit"]:hover {
            background-color: #7d3c98;
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
                <button type="submit">はい</button>
            </form>
            <a href="{{ route('participation.form') }}" class="join-button-link">いいえ</a>
        </div>
    </div>
</body>
</html>
