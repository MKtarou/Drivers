<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <title>グループへ参加</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f0fc;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .join-group-container {
            background-color: #fff;
            width: 330px;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .join-group-container h1 {
            color: #9b59b6;
            font-size: 1.8em;
            margin-bottom: 20px;
        }

        .join-input-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .join-input-group label {
            color: #333;
            font-size: 14px;
            display: block;
            margin-bottom: 5px;
        }

        .join-input-group input[type="text"],
        .join-input-group input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius:5px;
            font-size: 1em;
            box-sizing: border-box;
        }

        button {
            background-color: #9b59b6;
            color: white;
            padding: 10px 20px;
            font-size: 14px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            margin-top: 20px;
        }

        button:hover {
            background-color: #7d3c98;
        }

        p.error {
            color: red;
            font-size:14px;
        }
    </style>
</head>
<body>
    <div class="join-group-container">
        <h1>グループへ参加</h1>
        
        <form action="{{ route('participation.complete') }}" method="post">
            @csrf
            <div class="join-input-group">
                <label for="name">グループ名</label>
                <input type="text" id="name" name="name" required>
            </div>
            <div class="join-input-group">
                <label for="password">パスワード</label>
                <input type="password" id="password" name="password" required>
            </div>
            <button type="submit">参加</button>
        </form>
        @if($errors->has('group'))
            <p class="error">{{ $errors->first('group') }}</p>
        @endif
    </div>
</body>
</html>
