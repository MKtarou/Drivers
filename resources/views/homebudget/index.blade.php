<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>家計簿アプリ</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <header>
        <h1>{{ $groupName }}の家計簿</h1>
        <!-- <nav>
            <a href="{{ route('dashboard') }}">ダッシュボード</a>
        </nav> -->
    </header>

    <section class="container chart-container">

        <div class="balance">
            
            <h3>収支一覧</h3>
            @if(session('flash_message'))
                <div class="flash_message">
                    {{ session('flash_message') }}
                </div>
            @endif
            @if(session('flash_error_message'))
                <div class="flash_error_message">
                    {{ session('flash_error_message') }}
                </div>
            @endif

            <table>
                <thead>
                    <tr>
                        <th>日付</th>
                        <th>登録者</th>
                        <th>カテゴリ</th>
                        <th>詳細</th>
                        <th>金額</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($homebudgets as $homebudget)
                        <tr>
                            <td>{{ $homebudget->date }}</td>
                            <td>{{ $homebudget->user->u_name ?? '不明なユーザー' }}</td>
                            <td>{{ $homebudget->category->name ?? '収入' }}</td>
                            <td>{{ $homebudget->details ?? 'なし' }}</td>
                            <td>
                                @if($homebudget->price > 0)
                                    <span class="income">+{{ $homebudget->price }}</span>
                                @else
                                    <span class="payment">-{{ abs($homebudget->price) }}</span>
                                @endif
                            </td>
                            <td class="button-td">
                                <form action="{{ route('homebudget.edit', ['id' => $homebudget->id]) }}" method="">
                                    <input type="submit" value="更新" class="edit-button">
                                </form>
                                <form action="{{ route('homebudget.destroy', ['id' => $homebudget->id]) }}" method="POST">
                                    @csrf
                                    <input type="submit" value="削除" class="delete-button">
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="flex">
                <div class="pagination">
                    {{ $homebudgets->links() }}
                </div>
                <div class="flex total">
                    <p>収入合計：{{ $income }}円</p>
                    <p>支出合計：{{ $payment }}円</p>
                </div>
            </div>
        </div>

        <div class="add-balance">
            <h3>収支の追加</h3>
            <div class="toggle-container">
                <input type="checkbox" id="transactionToggle" onchange="toggleTransactionType()" />
                <label for="transactionToggle" class="toggle-label">
                    <span class="toggle-income">収入</span>
                    <span class="toggle-slider"></span>
                    <span class="toggle-expense">支出</span>
                </label>
            </div>

            <form id="balanceForm" action="{{ route('store') }}" method="POST">
                @csrf
                <input type="hidden" id="transactionType" name="transaction_type" value="expense">
                <label for="date">日付:</label>
                <input type="date" id="date" name="date">
                @if($errors->has('date')) <span class="error">{{ $errors->first('date') }}</span> @endif

                <div id="categorySection">
                    <label for="category">カテゴリ:</label>
                    <br>
                    <select name="category" id="category">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('category')) <span class="error">{{ $errors->first('category') }}</span> @endif
                </div>

                <label for="details">詳細:</label>
                <textarea id="details" name="details"></textarea>
                @if($errors->has('details')) <span class="error">{{ $errors->first('details') }}</span> @endif

                <label for="user">ユーザー:</label>
                <select name="user_id" id="user_id">
                    @foreach($users as $user)
                        <option value="{{ $user->user_id }}">{{ $user->u_name }}</option>
                    @endforeach
                </select>
                @if($errors->has('user_id')) <span class="error">{{ $errors->first('user_id') }}</span> @endif

                <label for="price">金額:</label>
                <input type="text" id="price" name="price">
                @if($errors->has('price')) <span class="error">{{ $errors->first('price') }}</span> @endif

                <button type="submit">追加</button>
            </form>

            <canvas id="categoryChart" ></canvas>
        </div>
    </section>
</body>
</html>

<script>

    // カテゴリごとのデータと色分けを設定
    // Chart.jsを用いた円グラフのスクリプト
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('categoryChart').getContext('2d');

        // データのラベルと値
        var labels = @json(array_column($data->toArray(), 'name'));
        var values = @json(array_column($data->toArray(), 'total_price'));

        // カテゴリに対応した色を設定
        var categoryColors = {
            '住居費': 'rgba(0, 114, 178, 0.7)',
            '食費': 'rgba(230, 159, 0, 0.7)',
            '交通費': 'rgba(240, 228, 66, 0.7)',
            '水道・光熱費': 'rgba(86, 180, 233, 0.7)',
            '日用品': 'rgba(213, 94, 0, 0.7)',
            '通信費': 'rgba(204, 121, 167, 0.7)',
            '医療費': 'rgba(0, 158, 115, 0.7)',
            'その他': 'rgba(153, 153, 153, 0.7)'
        };

        var borderColors = {
            '住居費': 'rgba(0, 114, 178, 1)',
            '食費': 'rgba(230, 159, 0, 1)',
            '交通費': 'rgba(240, 228, 66, 1)',
            '水道・光熱費': 'rgba(86, 180, 233, 1)',
            '日用品': 'rgba(213, 94, 0, 1)',
            '通信費': 'rgba(204, 121, 167, 1)',
            '医療費': 'rgba(0, 158, 115, 1)',
            'その他': 'rgba(153, 153, 153, 1)'
        };

        var colors = labels.map(label => categoryColors[label] || 'rgba(0,0,0,0.5)');
        var borders = labels.map(label => borderColors[label] || 'rgba(0,0,0,1)');

        // グラフの設定
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: values,
                    backgroundColor: colors,
                    borderColor: borders,
                    borderWidth: 1
                }]
            }
        });
    });


    function toggleTransactionType() {
        const transactionType = document.getElementById('transactionType');
        const categorySection = document.getElementById('categorySection');
        const toggle = document.getElementById('transactionToggle');

        if (toggle.checked) {
            transactionType.value = 'income';
            categorySection.style.display = 'none';
        } else {
            transactionType.value = 'expense';
            categorySection.style.display = 'block';
        }
    }
</script>
