<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>参加完了</title>
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

        .join-confirm-container p {
            margin-bottom: 20px;
        }

        .join-confirm-container label {
            display: block;
            margin-top: 20px;
            text-align: left;
            font-size:14px;
        }

        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-top: 5px;
            border-radius:5px;
            border:1px solid #ccc;
        }

        .join-confirm-container button {
            background-color: #9b59b6;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top:20px;
            width:100%;
        }

        .join-confirm-container button:hover {
            background-color: #7d3c98;
        }

        .join-confirm-container input[type="checkbox"] {
            margin-right:5px;
        }

        .join-confirm-container a.btn-link {
            display:inline-block;
            margin-top:10px;
            color:#9b59b6;
            text-decoration:none;
            font-size:14px;
            transition: color 0.3s;
        }

        .join-confirm-container a.btn-link:hover {
            color:#7d3c98;
            text-decoration:underline;
        }

    </style>
</head>
<body>
    <div class="join-confirm-container">
        <h1>グループへの参加が完了しました</h1>
        <p>グループ名: {{ $name }}</p>

        <form action="{{ route('participation.save_user') }}" method="post">
            @csrf
            <label for="user_id">ユーザーを選択してください:</label>
            <select id="user_id" name="user_id" required>
                <option value="">-- ユーザーを選択 --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->user_id }}">{{ $user->u_name }}</option>
                @endforeach
            </select>
            <div style="margin-top: 10px; text-align:left;">
                <input type="checkbox" id="remember" name="remember">
                <label for="remember" style="display:inline; font-size:14px;">30日間ログイン情報を保持する</label>
            </div>
            <button type="submit">TOPへ</button>
        </form>

        <a href="{{ route('user.register.form') }}" class="btn-link">新規ユーザー追加</a>
    </div>
</body>
</html>
