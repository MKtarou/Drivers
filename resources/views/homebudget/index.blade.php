<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>家計簿アプリ</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 20px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        h1, h2, h3 {
            color: #333;
            margin: 0 0 10px 0;
        }

        .chart-container {
            display: flex;
            justify-content: space-between;
            background-color: #f4e6fc;
            border-radius: 10px;
            padding: 20px;
            box-shadow: inset 0 2px 5px rgba(0,0,0,0.05);
        }

        .balance {
            width: 70%;
            margin-right: 20px;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .balance table {
            width: 100%;
            border-collapse: collapse;
        }

        .balance th, .balance td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ccc;
        }

        .balance th {
            background-color: #f4e6fc;
            font-weight: bold;
        }

        .balance tbody tr:nth-child(odd) {
            background: #f8f0fc;
        }

        .income {
            color: #0072b2; 
        }

        .payment {
            color: red; 
        }

        .add-balance {
            width: 25%;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .add-balance label {
            font-weight: bold;
            display: block;
            margin-bottom: 5px;
        }

        .add-balance input, .add-balance select, .add-balance textarea {
            width: 100%;
            border: 1px solid #ccc;
            border-radius: 4px;
            padding: 8px;
            margin-bottom: 10px;
            box-sizing: border-box;
        }

        .add-balance button {
            padding: 8px 16px;
            background-color: #9b59b6;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        .add-balance button:hover {
            background-color: #7d3c98;
        }

        .error {
            color: tomato;
            font-size: 12px;
        }

        .flash_message {
            background-color: aquamarine;
            opacity: 0.7;
            color: darkgreen;
            margin-bottom: 10px;
            padding: 5px;
            border-radius: 4px;
        }

        .flash_error_message {
            background-color: tomato;
            opacity: 0.7;
            color: #fff;
            margin-bottom: 10px;
            padding: 5px;
            border-radius: 4px;
        }

        .pagination {
            list-style: none;
            display: flex;
            margin: 10px 0;
        }

        .pagination li {
            margin-right: 5px;
        }

        .pagination li a {
            padding: 8px 12px;
            text-decoration: none;
            background-color: #9b59b6;
            color: #fff;
            border-radius: 4px;
        }

        .pagination li a:hover {
            background-color: #7d3c98;
        }

        .button-td {
            display: flex;
            gap: 10px;
        }

        .edit-button, .delete-button {
            padding: 5px 10px;
            border: none;
            border-radius: 4px;
            color: #fff;
            cursor: pointer;
            font-size: 12px;
        }

        .edit-button {
            background-color: orange;
        }

        .edit-button:hover {
            background-color: #cc8400;
        }

        .delete-button {
            background-color: tomato;
        }

        .delete-button:hover {
            background-color: #c0392b;
        }

        .flex {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .total p {
            margin: 0 5px;
            font-weight: bold;
        }

        .tabs {
            display: flex;
            justify-content: center;
            background-color: #9b59b6;
            border-radius: 10px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .tab {
            flex: 1;
            padding: 15px 20px;
            text-align: center;
            cursor: pointer;
            font-weight: bold;
            color: #fff;
            background-color: #9b59b6;
            transition: background-color 0.3s;
        }

        .tab:hover, .tab.active {
            background-color: #7d3c98;
        }

    </style>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <!-- <header>
        <h1>{{ $groupName }}</h1>
    </header> -->

    @include('homebudget.sidebar')
    <div class="container">
        <div class="chart-container">
            <div class="balance">
                <h1>{{ $groupName }}</h1>
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
                            <th>操作</th>
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
                                        <span class="income">+{{ number_format($homebudget->price) }}</span>
                                    @else
                                        <span class="payment">-{{ number_format(abs($homebudget->price)) }}</span>
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
                        <p>収入合計：{{ number_format($income) }}円</p>
                        <p>支出合計：{{ number_format($payment) }}円</p>
                    </div>
                </div>
            </div>

            <div class="add-balance">
                <h3>収支の追加</h3>

                <div class="tabs">
                    <div class="tab active" data-type="expense">支出</div>
                    <div class="tab" data-type="income">収入</div>
                </div>

                <form id="balanceForm" action="{{ route('store') }}" method="POST">
                    @csrf
                    <input type="hidden" id="transactionType" name="transaction_type" value="expense">

                    <label for="date">日付:</label>
                    <input type="date" id="date" name="date">
                    @if($errors->has('date')) <span class="error">{{ $errors->first('date') }}</span> @endif

                    <div id="categorySection">
                        <label for="category">カテゴリ:</label>
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

                    <label for="user_id">ユーザー:</label>
                    <select name="user_id" id="user_id">
                        @php
                            $loggedInUserId = session('userId');
                        @endphp
                        @foreach($users as $user)
                            <option value="{{ $user->user_id }}" {{ $user->user_id == $loggedInUserId ? 'selected' : '' }}>
                                {{ $user->u_name }}
                            </option>
                        @endforeach
                    </select>
                    @if($errors->has('user_id')) <span class="error">{{ $errors->first('user_id') }}</span> @endif

                    <label for="price">金額:</label>
                    <input type="number" id="price" name="price">
                    @if($errors->has('price')) <span class="error">{{ $errors->first('price') }}</span> @endif

                    <button type="submit">追加</button>
                </form>

                <canvas id="categoryChart"></canvas>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                tab.classList.add('active');
                const transactionType = tab.getAttribute('data-type');
                document.getElementById('transactionType').value = transactionType;

                // カテゴリセクションの表示/非表示
                if (transactionType === 'income') {
                    document.getElementById('categorySection').style.display = 'none';
                } else {
                    document.getElementById('categorySection').style.display = 'block';
                }
            });
        });

        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('categoryChart').getContext('2d');
            var labels = @json(array_column($data->toArray(), 'name'));
            var values = @json(array_column($data->toArray(), 'total_price'));

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

            var borders = labels.map(label => categoryColors[label] || 'rgba(0,0,0,1)');
            var colors = labels.map(label => categoryColors[label] || 'rgba(0,0,0,0.5)');

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors,
                        borderWidth: 1
                    }]
                }
            });
        });
    </script>
</body>
</html>
