<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>設定画面</title>
    <style>
        body {
            display flex;
            align-items : center;
            justify-content : center; 
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f8f0fc;
            color: #333;
        }

        .container {
            
            max-width: 600px;
            margin: 50px auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        h1 {
            text-align: center;
            color: #9b59b6;
            margin-bottom: 30px;
        }

        .d-flex {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            justify-content: center;
        }

        .btn {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            border: none;
            border-radius: 5px;
            background-color: #f0f0f0;
            color: #333;
        }

        .btn:hover {
            background-color: #e0e0e0;
        }

        .btn.active, .btn-primary {
            background-color: #9b59b6;
            color: #fff;
        }

        .btn-secondary {
            background-color: #7d3c98;
            color: #fff;
        }

        .form-section {
            display: block;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 15px;
        }

        label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        input.form-control {
            width: 100%;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .btn-success {
            width: 100%;
            padding: 10px;
            background-color: #9b59b6;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }

        .btn-success:hover {
            background-color: #7d3c98;
        }

        .mt-4 {
            margin-top: 20px;
            text-align: center;
        }

        .btn-secondary {
            background-color: #9b59b6;
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 5px;
            display: inline-block;
        }

        .btn-secondary:hover {
            background-color: #7d3c98;
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>
<body>
    <div class="container" id="app">
        <h1>設定画面</h1>
        <div class="d-flex">
            <button class="btn btn-primary" v-on:click="activeTab = 'personal'" :class="{ active: activeTab === 'personal' }">個人設定</button>
            <button class="btn btn-secondary" v-on:click="activeTab = 'group'" :class="{ active: activeTab === 'group' }">グループ設定</button>
        </div>

        <div v-if="activeTab === 'personal'" class="form-section">
            <form method="POST" action="{{ route('setting.update.personal') }}">
                @csrf
                <div class="form-group">
                    <label for="u_name">ユーザー名</label>
                    <input type="text" id="u_name" name="u_name" value="{{ session('name') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="u_limit">月限度額</label>
                    <input type="number" id="u_limit" name="u_limit" value="{{ session('limit') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="u_goal">目標金額</label>
                    <input type="number" id="u_goal" name="u_goal" value="{{ session('savings') }}" class="form-control" required>
                </div>
                <button type="submit" class="btn-success">個人設定を更新</button>
            </form>
        </div>

        <div v-if="activeTab === 'group'" class="form-section">
            <form method="POST" action="{{ route('setting.update.group') }}">
                @csrf
                <div class="form-group">
                    <label for="g_name">グループ名</label>
                    <input type="text" id="g_name" name="g_name" value="{{ session('group_name') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="g_limit">グループ月限度額</label>
                    <input type="number" id="g_limit" name="g_limit" value="{{ session('group_limit') }}" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="g_goal">グループ目標金額</label>
                    <input type="number" id="g_goal" name="g_goal" value="{{ session('group_savings') }}" class="form-control" required>
                </div>
                <button type="submit" class="btn-success">グループ設定を更新</button>
            </form>
        </div>

        <div class="mt-4">
            <a href="{{ route('index') }}" class="btn-secondary">ホームに戻る</a>
        </div>
    </div>
    <script>
        new Vue({
            el: '#app',
            data: {
                activeTab: 'personal'
            }
        });
    </script>
</body>
</html>
