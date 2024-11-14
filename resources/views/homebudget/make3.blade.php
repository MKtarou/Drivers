<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>作成確認</title>
    <style>
        /* 背景と中央配置 */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #c6e2ff, #9fd8df, #b6d6a8);
            font-family: Arial, sans-serif;
        }

        /* 完了メッセージのコンテナ */
        .creation-complete-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 330px;
            text-align: center;
            margin: 0 auto;
        }

        /* タイトル */
        .creation-complete-container h1 {
            font-size: 1.8em;
            color: #3a3a3a;
            margin-bottom: 20px;
        }

        /* メッセージのスタイル */
        .creation-complete-container p {
            font-size: 1em;
            color: #3a3a3a;
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="creation-complete-container">
        <h1>グループの作成が完了しました</h1>
        <?php
        // フォームから送信されたデータを取得
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
            $password = htmlspecialchars($_POST["password"], ENT_QUOTES, 'UTF-8');
            
            // ユーザー情報を表示（パスワードはそのまま表示）
            echo "<p>グループ名: " . $name . "</p>";
            echo "<p>パス: " . $password . "</p>";  // パスワードではなくパスを表示
            echo "<p>グループが正常に作成されました！</p>";
        } else {
            echo "<p>エラーが発生しました。もう一度お試しください。</p>";
        }
        ?>
    </div>
</body>
</html>
