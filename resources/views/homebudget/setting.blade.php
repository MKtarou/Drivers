<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>設定画面 - 家計簿アプリ</title>
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

        form {
            display: flex;
            flex-direction: column; /* 縦に配置 */
            max-width: 400px; /* 最大幅を指定 */
            margin: 0 auto; /* 中央揃え */
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
    </style>
</head>
<body>
    <h1>設定</h1>
    
    <form action="setting2.blade.php" method="POST">
        
        <div class="setting-form-group">
            <label for="name">個人の名前</label>
            <input type="text" id="name" name="name" placeholder="名前を入力">
        </div>
        
        <div class="setting-form-group">
            <label for="group_name">グループの名前</label>
            <input type="text" id="group_name" name="group_name" placeholder="グループ名を入力">
        </div>
        
        <div class="setting-form-group">
            <label for="limit">支出の上限 (円)</label>
            <input type="text" id="limit" name="limit" placeholder="上限金額を入力">
        </div>

        <div class="setting-form-group">
            <label for="savings">貯金の目標 (円)</label>
            <input type="text" id="savings" name="savings" placeholder="目標金額を入力">
        </div>

        <button type="submit">更新</button>
    </form>
</body>
</html>
