<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>参加完了</title>
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

        /* グループ参加完了コンテナのスタイル */
        .join-confirm-container {
            background-color: #ffffff;
            width: 330px; /* コンテナの幅 */
            padding: 40px; /* パディング */
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

        select {
            width: 100%;
            padding: 10px;
            font-size: 16px;
            margin-bottom: 20px;
        }

        button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="join-confirm-container">
        <h1>グループへの参加が完了しました</h1>
        <p>グループ名: {{ $name }}</p>

        <!-- ユーザー選択フォーム -->
        <form action="{{ route('participation.save_user') }}" method="post">
            @csrf
            <label for="user_id">ユーザーを選択してください:</label>
            <select id="user_id" name="user_id" required>
                <option value="">-- ユーザーを選択 --</option>
                @foreach ($users as $user)
                    <option value="{{ $user->user_id }}">{{ $user->u_name }}</option>
                @endforeach
            </select>
            <button type="submit">TOPへ</button>
        </form>
    </div>
</body>
</html>
