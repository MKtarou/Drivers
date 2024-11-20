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
            border: none; /* ふちを消す */
        }

        .join-button-link:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="join-confirm-container">
        <h1>グループへの参加が完了しました</h1>
        <p>グループ名: {{ $name }}</p>
        <a href="{{ route('index') }}">Topへ</a>
    </div>
</body>
</html>
