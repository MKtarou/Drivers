<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>設定更新 - 家計簿アプリ</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            padding: 0;
        }

        h1 {
            text-align: center;
            margin-bottom: 20px;
            margin: 70px;
        }

        /* 設定確認ページのコンテナ */
        .setting-container {
            padding: 20px;
            max-width: 500px;
            margin: 0 auto;
            text-align: center;
        }

        .setting-container p {
            font-size: 1.2em;
            margin: 10px 0;
        }

        /* 入力フォームグループ */
        .setting-form-group {
            margin-bottom: 15px; /* 各グループの間隔 */
        }

        label {
            margin-bottom: 5px; /* ラベルと入力フィールドの間隔 */
        }

        input {
            padding: 8px; /* パディング */
            border: 1px solid #ccc; /* 枠線 */
            border-radius: 4px; /* 角を丸く */
            font-size: 16px; /* フォントサイズ */
            width: 90%; /* 幅を90%に調整 */
            max-width: 300px; /* 最大幅を300pxに設定 */
        }

        button {
            padding: 10px; /* パディング */
            background-color: #007BFF; /* 背景色 */
            color: white; /* 文字色 */
            border: none; /* 枠線なし */
            border-radius: 4px; /* 角を丸く */
            font-size: 16px; /* フォントサイズ */
            cursor: pointer; /* ポインタを表示 */
            width: 100px; /* ボタンの横幅を指定 */
            margin-left: auto; /* 左側の余白を自動で設定して右寄せ */
            margin-top: 10px; /* ボタンの上部に間隔を追加 */
        }

        button:hover {
            background-color: #0056b3; /* ホバー時の背景色 */
        }
    </style>
</head>
<body>
    <div class="setting-container">
        <h1>設定更新</h1>
        
        <?php
        // POSTメソッドでデータが送信されたか確認
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // データを取得し、XSS対策のためにhtmlspecialcharsでエスケープ
            $name = htmlspecialchars($_POST["name"], ENT_QUOTES, 'UTF-8');
            $group_name = htmlspecialchars($_POST["group_name"], ENT_QUOTES, 'UTF-8');
            $limit = htmlspecialchars($_POST["limit"], ENT_QUOTES, 'UTF-8');
            $savings = htmlspecialchars($_POST["savings"], ENT_QUOTES, 'UTF-8');

            // デバッグ用として入力されたデータを表示
            echo "<p>名前: " . $name . "</p>";
            echo "<p>グループ名: " . $group_name . "</p>";
            echo "<p>支出の上限: " . $limit . " 円</p>";
            echo "<p>貯金の目標: " . $savings . " 円</p>";
            echo "<p>設定が正常に更新されました！</p>";
        } else {
            echo "<p>エラーが発生しました。もう一度お試しください。</p>";
        }
        ?>
    </div>
</body>
</html>
