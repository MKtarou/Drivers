<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>アカウント作成</title>
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <div class="container">
            <h1>アカウント新規作成</h1>
            <form action="submit.php" method="post">
                <div class="field-container">
                    <label for="name">名前</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="field-container">
                    <label for="password">パスワード</label>
                    <input type="password" id="password" name="password" required>
                </div>

                <button type="submit">作成</button>
            </form>
        </div>
    </body>
</html>
