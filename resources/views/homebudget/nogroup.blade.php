<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>グループ未参加</title>
    <style>
        body, html {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: Arial, sans-serif;
            background-color: #f8f0fc;
            color: #333;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .no-group-box {
            background-color: #fff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        .no-group-box h1 {
            font-size: 24px;
            color: #9b59b6;
            margin-bottom: 20px;
        }

        .no-group-box ul {
            list-style: none;
            padding: 0;
            margin:0;
        }

        .no-group-box ul li {
            margin: 10px 0;
        }

        .no-group-box ul li a {
            text-decoration: none;
            color: #9b59b6;
            font-size: 18px;
            transition: color 0.3s;
        }

        .no-group-box ul li a:hover {
            color: #7d3c98;
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="no-group-box">
        <h1>グループに加入していません</h1>
        <ul>
            <li><a href="{{ route('groups.create') }}">グループ作成</a></li>
            <li><a href="{{ route('participation.form') }}">グループに参加</a></li>
        </ul>
    </div>
</body>
</html>
