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
    </header>

    <section class="container">
        <div class="balance">
        <canvas id="categoryChart" width="400" height="400"></canvas>
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
                        <!-- ユーザー名を表示 -->
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
                    {{$homebudgets->links()}}
                </div>
                <div class="flex total">


                    <p>収入合計：{{$income}}円</p>
                    <p>支出合計：{{$payment}}円</p>
                </div>
            </div>
            
        </div>

        
        

        <div class="add-balance">
        <h3>収支の追加</h3>

        <!-- 収入・支出の切り替えボタン -->
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
            @if($errors->has('date')) <span class="error">{{$errors->first('date')}}</span> @endif

            <!-- カテゴリ選択欄（支出の時のみ表示） -->
            <div id="categorySection">
                <label for="category">カテゴリ:</label>
                <br>
                <select name="category" id="category">
                    @foreach($categories as $category)
                    <option value="{{$category->id}}">{{$category->name}}</option>
                    @endforeach
                </select>
                @if($errors->has('category')) <span class="error">{{$errors->first('category')}}</span> @endif
            </div>

            <!-- 詳細欄 -->
            <label for="details">詳細:</label>
            <textarea id="details" name="details"></textarea>
            @if($errors->has('details')) <span class="error">{{$errors->first('details')}}</span> @endif

            <label for="user">ユーザー:</label>
            <select name="user_id" id="user_id">
                @foreach($users as $user)
                <option value="{{ $user->user_id }}">{{ $user->u_name }}</option>
                @endforeach
            </select>

            @if($errors->has('user_id')) <span class="error">{{$errors->first('user_id')}}</span> @endif

            <label for="price">金額:</label>
            <input type="text" id="price" name="price">
            @if($errors->has('price')) <span class="error">{{$errors->first('price')}}</span> @endif

            <button type="submit">追加</button>
        </form>
    </div>



        
    </section>
    
</body>
</html>


<script>
    // PHPからJavaScriptにデータを渡す
    var categories = @json($data->pluck('name'));
    var totalPrices = @json($data->pluck('total_price'));

    // 色覚異常に対応した固定色を設定（「その他」と「医療費」の色を交換）
    var categoryColors = {
        '住居費': 'rgba(0, 114, 178, 0.7)',  // 濃い青
        '食費': 'rgba(230, 159, 0, 0.7)',    // オレンジ
        '交通費': 'rgba(240, 228, 66, 0.7)', // 黄色
        '水道・光熱費': 'rgba(86, 180, 233, 0.7)',  // 明るい青
        '日用品': 'rgba(213, 94, 0, 0.7)',   // 赤
        '通信費': 'rgba(204, 121, 167, 0.7)', // 紫
        '医療費': 'rgba(0, 158, 115, 0.7)', // 緑
        'その他': 'rgba(153, 153, 153, 0.7)'  // グレー
    };

    var borderColors = {
        '住居費': 'rgba(0, 114, 178, 0.7)',  // 濃い青
        '食費': 'rgba(230, 159, 0, 0.7)',    // オレンジ
        '交通費': 'rgba(240, 228, 66, 0.7)', // 黄色
        '水道・光熱費': 'rgba(86, 180, 233, 0.7)',  // 明るい青
        '日用品': 'rgba(213, 94, 0, 0.7)',   // 赤
        '通信費': 'rgba(204, 121, 167, 0.7)', // 紫
        '医療費': 'rgba(0, 158, 115, 0.7)', // 緑
        'その他': 'rgba(153, 153, 153, 0.7)'  // グレー
    };

    // カテゴリに応じた色をマッピング
    var backgroundColors = categories.map(function(category) {
        return categoryColors[category] || 'rgba(200, 200, 200, 0.7)'; // カテゴリが見つからない場合はデフォルト色
    });

    var borderColorsArray = categories.map(function(category) {
        return borderColors[category] || 'rgba(200, 200, 200, 1)'; // カテゴリが見つからない場合はデフォルト色
    });

    var ctx = document.getElementById('categoryChart').getContext('2d');
    var categoryChart = new Chart(ctx, {
        type: 'pie',
        data: {
            labels: categories, // カテゴリ名
            datasets: [{
                label: '支出の割合',
                data: totalPrices, // 各カテゴリの合計金額
                backgroundColor: backgroundColors, // カテゴリに応じた背景色
                borderColor: borderColorsArray, // カテゴリに応じた枠線色
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'カテゴリごとの支出割合'
                }
            }
        }
    });

    function toggleForm(type) {
        const form = document.getElementById('balanceForm');
        const transactionType = document.getElementById('transactionType');
        const categorySection = document.getElementById('categorySection');

        if (type === 'income') {
            transactionType.value = 'income';
            form.querySelector('button[type="submit"]').textContent = '収入を追加';
            categorySection.style.display = 'none'; // カテゴリ選択を非表示
        } else {
            transactionType.value = 'expense';
            form.querySelector('button[type="submit"]').textContent = '支出を追加';
            categorySection.style.display = 'block'; // カテゴリ選択を表示
        }
    }

    function toggleTransactionType() {
        const transactionType = document.getElementById('transactionType');
        const categorySection = document.getElementById('categorySection');
        const toggle = document.getElementById('transactionToggle');

        if (toggle.checked) {
            transactionType.value = 'income';
            categorySection.style.display = 'none'; // カテゴリ選択を非表示
        } else {
            transactionType.value = 'expense';
            categorySection.style.display = 'block'; // カテゴリ選択を表示
        }
    }

</script>
