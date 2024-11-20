<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>グループ未参加</title>
    <style>
        /* 全体のレイアウトを整える */
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'Arial', sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            background: linear-gradient(135deg, #d1e8ff, #a0d3ff, #b4f0c3); /* 背景のグラデーション */
        }

        /* 専用コンテナの設定 */
        .no-group-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            height: 100%;
        }

        /* ボックスのスタイル */
        .no-group-box {
            background-color: white;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        /* タイトルのスタイル */
        .no-group-box h1 {
            font-size: 24px;
            color: #3a3a3a;
            margin-bottom: 20px;
        }

        /* リストのスタイル */
        .no-group-box ul {
            list-style: none;
            padding: 0;
        }

        .no-group-box ul li {
            margin: 10px 0;
        }

        /* リンクのスタイル */
        .no-group-box ul li a {
            text-decoration: none;
            color: #007BFF;
            font-size: 18px;
        }

        .no-group-box ul li a:hover {
            text-decoration: underline;
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="no-group-container">
        <div class="no-group-box">
            <h1>グループに加入していません</h1>
            <ul>
                <li><a href="{{ route('participation.form') }}">グループに参加</a></li>
            </ul>
        </div>
    </div>
</body>
</html>
