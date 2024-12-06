<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <title>家計簿メーター</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f0fc;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
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

        .content {
            display: none;
        }

        .content.active {
            display: block;
        }

        .grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
        }

        .chart-section, .meter-section {
            background-color: #f4e6fc;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .chart-section canvas, .meter canvas {
            max-width: 500px;
            max-height: 500px;
        }

        /* .meter-section {
            gap: 20px;
            align-items: center;
        } */

        .meter {
            display: flex;
            flex-direction: column;
            width: 250px;
            align-items: center;
        }

        .meter canvas {
            max-width: 200px;
            max-height: 200px;
        }

        .chart-section p, .meter p {
            margin: 10px 0;
            font-size: 16px;
            font-weight: bold;
        }
    </style>
</head>
<body>

@include('homebudget.sidebar')
    <div class="container">
        <!-- タブ -->
        <div class="tabs">
            <div class="tab active" data-target="personal">{{ $u_name }}の個人データ</div>
            <div class="tab" data-target="team">{{ $g_name }}のチームデータ</div>
        </div>

        <div class="controls">
            <a href="{{ route('combined.meter', ['month' => $month == 1 ? 12 : $month - 1, 'year' => $month == 1 ? $year - 1 : $year]) }}" class="control-btn">◀ 前月</a>
            <span>{{ $year }}年 {{ $month }}月のデータ</span>
            <a href="{{ route('combined.meter', ['month' => $month == 12 ? 1 : $month + 1, 'year' => $month == 12 ? $year + 1 : $year]) }}" class="control-btn">次月 ▶</a>
        </div>

        <!-- 個人データ -->
        <div id="personal" class="content active">
            <div class="grid">
                <!-- 個人データのグラフ -->
                <div class="chart-section">
                    <canvas id="personalChart"></canvas>
                    <p>個人支出合計：{{ $personalExpense }}円</p>
                </div>

                <!-- 個人メーター -->
                <div class="meter-section">
                    <div class="meter">
                    <h2>使用限度額メーター</h2>
                        <canvas id="personalLimitMeter"></canvas>

                        <p>使用限度{{ $u_limit }}円</p>
                        <p>現在使用額{{ $personalExpense * -1 }}円</p>
                        <p>残りの使用可能額{{ $u_limit + $personalExpense }} 円</p>
                        
                    </div>
                    <div class="meter">
                    <h2>貯金目標メーター</h2>
                        <canvas id="personalGoalMeter"></canvas>
                        
                    </div>
                </div>
            </div>
        </div>

        <!-- チームデータ -->
        <div id="team" class="content">
            <div class="grid">
                <!-- チームデータのグラフ -->
                <div class="chart-section">
                    <canvas id="teamChart"></canvas>
                    <p>グループ支出合計：{{ $teamExpense }}円</p>
                </div>

                <!-- チームメーター -->
                <div class="meter-section">
                    <div class="meter">
                        <h2>使用限度額メーター</h2>
                        <canvas id="teamLimitMeter"></canvas>
                        <p>使用限度{{ $g_limit }}円</p>
                        <p>現在使用額{{ $teamExpense * -1 }}円</p>
                        <p>残りの使用可能額{{ $g_limit + $teamExpense }} 円</p>
                        
                    </div>
                    <div class="meter">
                        <h2>貯金目標メーター</h2>
                        <canvas id="teamGoalMeter"></canvas>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>

        

        // タブ切り替え機能
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.content').forEach(c => c.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById(tab.getAttribute('data-target')).classList.add('active');
            });
        });

        // PHPデータの取得
        const personalCategories = @json($personalCategories);
        const personalIncome = @json($personalIncome);
        const personalExpense = @json($personalExpense);
        const teamCategories = @json($teamCategories);
        const teamIncome = @json($teamIncome);
        const teamExpense = @json($teamExpense);
        const uGoal = @json($u_goal);
        const gGoal = @json($g_goal);
        const uLimit = @json($u_limit);
        const gLimit = @json($g_limit);
        const gSaving = @json($g_savings);
        const uSaving = @json($u_savings);

        const month = @json($month);
        const year = @json($year);

        // グラフ描画
        const categoryColors = {
            '住居費': 'rgba(0, 114, 178, 0.7)',
            '食費': 'rgba(230, 159, 0, 0.7)',
            '交通費': 'rgba(240, 228, 66, 0.7)',
            '水道・光熱費': 'rgba(86, 180, 233, 0.7)',
            '日用品': 'rgba(213, 94, 0, 0.7)',
            '通信費': 'rgba(204, 121, 167, 0.7)',
            '医療費': 'rgba(0, 158, 115, 0.7)',
            'その他': 'rgba(153, 153, 153, 0.7)'
        };

        const personalChart = new Chart(document.getElementById('personalChart'), {
            type: 'pie',
            data: {
                labels: personalCategories.map(c => c.name),
                datasets: [{
                    data: personalCategories.map(c => Math.abs(c.total_price)),
                    backgroundColor: personalCategories.map(c => categoryColors[c.name] || 'rgba(0, 0, 0, 0.5)')
                }]
            }
        });

        const teamChart = new Chart(document.getElementById('teamChart'), {
            type: 'pie',
            data: {
                labels: teamCategories.map(c => c.name),
                datasets: [{
                    data: teamCategories.map(c => Math.abs(c.total_price)),
                    backgroundColor: teamCategories.map(c => categoryColors[c.name] || 'rgba(0, 0, 0, 0.5)')
                }]
            }
        });


        // 個人使用限度額メーター
        new Chart(document.getElementById('personalLimitMeter'), {
            type: 'doughnut',
            data: {
                labels: ['使用済み', '残額'],
                datasets: [{
                    // 使用済み: personalExpenseの絶対値
                    // 残額: 使用限度額 - 使用済み金額
                    data: [Math.abs(personalExpense), uLimit - Math.abs(personalExpense)],
                    backgroundColor: ['#FF6384', '#E0E0E0']
                }]
            },
            options: { 
                circumference: 180, // 半円メーター
                rotation: -90 // メーターの開始位置を調整
            }
        });

        // 個人貯金目標メーター
        new Chart(document.getElementById('personalGoalMeter'), {
            type: 'doughnut',
            data: {
                labels: ['貯金済み', '目標'],
                datasets: [{
                    data: [uSaving , uGoal - uSaving],
                    backgroundColor: ['#36A2EB', '#E0E0E0']
                }]
            },
            options: { circumference: 180, rotation: -90 }
        });

        // チーム使用限度額メーター
        new Chart(document.getElementById('teamLimitMeter'), {
            type: 'doughnut',
            data: {
                labels: ['使用済み', '残額'],
                datasets: [{
                    // 使用済み: teamExpenseの絶対値
                    // 残額: チーム使用限度額 - 使用済み金額
                    data: [Math.abs(teamExpense), gLimit - Math.abs(teamExpense)],
                    backgroundColor: ['#FF6384', '#E0E0E0']
                }]
            },
            options: { 
                circumference: 180, // 半円メーター
                rotation: -90 // メーターの開始位置を調整
            }
        });


        // チーム貯金目標メーター
        new Chart(document.getElementById('teamGoalMeter'), {
            type: 'doughnut',
            data: {
                labels: ['貯金済み', '目標残額'],
                datasets: [{
                    data: [gSaving , gGoal - gSaving],
                    backgroundColor: ['#36A2EB', '#E0E0E0']
                }]
            },
            options: { circumference: 180, rotation: -90 }
        });
    </script>
</body>
</html>
