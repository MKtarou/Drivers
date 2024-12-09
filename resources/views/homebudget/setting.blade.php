<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>設定画面</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
</head>
<body>
    
    <div class="container mt-5" id="app">
        <h1>設定画面</h1>
        <!-- タブで個人とグループを切り替え -->
        <div class="d-flex mb-3">
            <button class="btn btn-primary me-2" v-on:click="activeTab = 'personal'" :class="{ active: activeTab === 'personal' }">個人設定</button>
            <button class="btn btn-secondary" v-on:click="activeTab = 'group'" :class="{ active: activeTab === 'group' }">グループ設定</button>
        </div>

        <!-- 個人設定フォーム -->
        <div v-if="activeTab === 'personal'" class="form-section">
            <form method="POST" action="{{ route('setting.update.personal') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="u_name">ユーザー名</label>
                    <input type="text" id="u_name" name="u_name" value="{{ session('name') }}" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="u_limit">月限度額</label>
                    <input type="number" id="u_limit" name="u_limit" value="{{ session('limit') }}" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="u_goal">目標金額</label>
                    <input type="number" id="u_goal" name="u_goal" value="{{ session('savings') }}" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">個人設定を更新</button>
            </form>
        </div>

        <!-- グループ設定フォーム -->
        <div v-if="activeTab === 'group'" class="form-section">
            <form method="POST" action="{{ route('setting.update.group') }}">
                @csrf
                <div class="form-group mb-3">
                    <label for="g_name">グループ名</label>
                    <input type="text" id="g_name" name="g_name" value="{{ session('group_name') }}" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="g_limit">グループ月限度額</label>
                    <input type="number" id="g_limit" name="g_limit" value="{{ session('group_limit') }}" class="form-control" required>
                </div>
                <div class="form-group mb-3">
                    <label for="g_goal">グループ目標金額</label>
                    <input type="number" id="g_goal" name="g_goal" value="{{ session('group_savings') }}" class="form-control" required>
                </div>
                <button type="submit" class="btn btn-success">グループ設定を更新</button>
            </form>
        </div>

        <!-- 戻るボタン -->
        <div class="mt-4">
            <a href="{{ route('index') }}" class="btn btn-secondary">ホームに戻る</a>
        </div>
    </div>

    <script>
        new Vue({
            el: '#app',
            data: {
                activeTab: 'personal' // 初期タブを個人設定に設定
            }
        });
    </script>

    <style>
        /* 全体のスタイル */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 20px;
    background-color: #f9f9f9;
    color: #333;
}

h1 {
    text-align: center;
    color: #007bff;
    margin-bottom: 30px;
}

/* タブのデザイン */
.tabs {
    display: flex;
    justify-content: center;
    margin-bottom: 20px;
}

.tab {
    padding: 10px 20px;
    cursor: pointer;
    background-color: #f0f0f0;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin: 0 5px;
    font-weight: bold;
    transition: background-color 0.3s, color 0.3s;
}

.tab:hover {
    background-color: #e0e0e0;
}

.tab.active {
    background-color: #007bff;
    color: #fff;
    border-color: #0056b3;
}

/* 設定フォームのスタイル */
.setting-container {
    display: none;
    padding: 20px;
    background-color: #fff;
    border: 1px solid #ccc;
    border-radius: 5px;
    box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
}

.setting-container.active {
    display: block;
}

.setting-form-group {
    margin-bottom: 20px;
}

.setting-form-group label {
    display: block;
    font-weight: bold;
    margin-bottom: 5px;
    color: #555;
}

.setting-form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 14px;
    transition: border-color 0.3s;
}

.setting-form-group input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
}

/* ボタンのスタイル */
button {
    display: block;
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    color: #fff;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s;
}

button:hover {
    background-color: #0056b3;
}

button:active {
    background-color: #003f88;
}

    </style>
</body>
</html>
