<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規ユーザー登録</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #f9f9f9, #c6e2ff);
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }

        .registration-container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1);
            width: 350px;
            text-align: center;
        }

        .registration-container h1 {
            font-size: 1.8em;
            margin-bottom: 20px;
            color: #007bff;
        }

        .registration-container form {
            display: flex;
            flex-direction: column;
        }

        .registration-container input {
            margin-bottom: 15px;
            padding: 10px;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        .registration-container button {
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 16px;
            cursor: pointer;
        }

        .registration-container button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="registration-container">
        <h1>新規ユーザー登録</h1>
        <form action="{{ route('user.register') }}" method="POST">
            @csrf
            <input type="text" name="u_name" placeholder="ユーザー名" required>
            <input type="password" name="u_pass" placeholder="パスワード" required>
            <input type="number" name="u_goal" placeholder="目標金額" required>
            <input type="number" name="u_limit" placeholder="月限度額" required>
            <button type="submit">登録</button>
        </form>
    </div>
</body>
</html>
