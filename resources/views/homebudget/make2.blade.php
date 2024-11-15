<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>グループ作成確認画面</title>
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

        /* 共通コンテナスタイル */
        .creation-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 330px;
            text-align: center;
            margin: 0 auto;
        }

        /* タイトル */
        .creation-container h1 {
            font-size: 1.8em;
            color: #3a3a3a;
            margin-bottom: 20px;
        }

        /* アクションボタン */
        .action-button {
            display: inline-block; /* inline-blockで要素サイズを調整 */
            width: 80%;
            background-color: #007BFF;
            color: white;
            border: none;
            padding: 10px;
            border-radius: 5px;
            font-size: 1.1em;
            text-align: center;
            text-decoration: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
            margin: 20px auto;
        }

        /* ホバー時のスタイル */
        .action-button:hover {
            background-color: #2e225e;
        }

        /* リンク要素をボタンとして表示 */
        .action-link {
            display: inline-block; /* 同じくinline-blockで表示 */
            width: 75%;
            background-color: #007BFF;
            color: white;
            padding: 10px;
            border-radius: 5px;
            font-size: 1.1em;
            text-align: center;
            text-decoration: none;
            margin: 20px auto;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .action-link:hover {
            background-color: #2e225e;
        }
    </style>
</head>
<body>
    <div class="creation-container">
        <div class="creation-card">
            <h1>グループを作成しますか？</h1>
            <div class="creation-options">
                <form action="make3.blade.php" method="post" style="display: inline;">
                    <!-- 名前とパスワードを隠しフィールドで転送 -->
                    <input type="hidden" name="name" value="<?php echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8'); ?>">
                    <input type="hidden" name="password" value="<?php echo htmlspecialchars($_POST['password'], ENT_QUOTES, 'UTF-8'); ?>">
                    <button type="submit" class="action-button">はい</button>
                </form>
                <a href="make.blade.php" class="action-link">いいえ</a>
            </div>
        </div>
    </div>
</body>
</html>
