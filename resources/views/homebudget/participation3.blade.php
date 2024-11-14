<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>参加確認</title>
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
        <?php
        // フォームから送信されたデータを取得
        if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["name"]) && isset($_POST["password"])) {
            $name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
            
            // ユーザー情報を表示
            echo "<p>名前: " . $name . "</p>";
            echo "<p>パス: " . $password . "</p>";
            echo "<p>グループに参加しました！</p>";
        } else {
            echo "<p>エラーが発生しました。もう一度お試しください。</p>";
        }
        ?>
    </div>
</body>
</html>
