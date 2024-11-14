<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>グループの作成</title>
    <style>
        /* ベースのスタイル */
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

        /* ラベルとインプットフィールドの親コンテナ */
        .creation-field-container {
            width: 85%;
            margin: 0 auto;
            text-align: left;
        }

        /* ラベルのスタイル */
        label {
            font-size: 1em;
            color: #3a3a3a;
            margin-top: 10px;
            margin-bottom: 5px;
            display: block;
        }

        /* 入力フィールドのスタイル */
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #007BFF;
            border-radius: 5px;
            font-size: 1em;
            color: #000;
            box-sizing: border-box;
        }

        /* ボタンのスタイル */
        .action-button {
            display: block;
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

        .action-button:hover {
            background-color: #2e225e;
        }
    </style>
</head>
<body>
<div class="creation-container">
    <h1>グループの作成</h1>
    
    <form action="make2.blade.php" method="post">
        <div class="creation-field-container">
            <label for="name">名前</label>
            <input type="text" id="name" name="name" required>
        </div>

        <div class="creation-field-container">
            <label for="password">パス</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="action-button">作成</button>
    </form>
</div>
</body>
</html>
