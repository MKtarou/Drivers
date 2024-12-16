<!-- ファイルパス: resources/views/homebudget/invitationCode.blade.php -->
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>招待コード</title>
    <!-- <link rel="stylesheet" href="{{ asset('css/invitationCode.css') }}"> -->
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <style>
        /* 基本スタイル */
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background: linear-gradient(135deg, #c6e2ff, #9fd8df, #b6d6a8);
            font-family: Arial, sans-serif;
        }

        .invitation-container {
            background-color: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            width: 330px;
            text-align: center;
        }

        .invitation-container h1 {
            font-size: 1.8em;
            color: #3a3a3a;
            margin-bottom: 20px;
        }

        .invitation-code {
            font-size: 1.5em;
            font-weight: bold;
            color: #007BFF;
            margin: 20px 0;
            cursor: pointer;
        }

        .copy-button {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007BFF;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 1em;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .copy-button:hover {
            background-color: #2e225e;
        }

        .success-message {
            color: green;
            margin-top: 10px;
            display: none;
        }
    </style>
</head>
<body>
    <div class="invitation-container">
        <h1>グループ: {{ $groupName }}</h1>
        <div class="invitation-code" id="invitationCode">{{ $invitationCode }}</div>
        <button class="copy-button" onclick="copyToClipboard()">コピーする</button>
        <p class="success-message" id="successMessage">コードがコピーされました！</p>
    </div>

    <script>
        function copyToClipboard() {
            // 招待コードを取得
            const code = document.getElementById('invitationCode').innerText;
            // テキストをクリップボードにコピー
            navigator.clipboard.writeText(code).then(() => {
                // コピー成功メッセージを表示
                const message = document.getElementById('successMessage');
                message.style.display = 'block';
                setTimeout(() => {
                    message.style.display = 'none';
                }, 2000);
            }).catch(err => {
                console.error('コピーに失敗しました: ', err);
            });
        }
    </script>
</body>
</html>
