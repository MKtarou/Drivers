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
            background-color: #f4f4f4;
        }
        .container {
            padding: 20px;
        }
        .tabs {
            display: flex;
            justify-content: flex-start;
            gap: 10px;
        }
        .tab {
            padding: 10px 20px;
            cursor: pointer;
            font-weight: bold;
            background-color: #e0e0e0;
            border-radius: 5px;
            text-align: center;
        }
        .tab.active {
            background-color: #5633d3;
            color: white;
        }
        .content {
            display: none;
        }
        .content.active {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }
        .charts {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 20px;
        }
        .meters {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }
        canvas {
            width: 300px;
            height: 300px;
        }
        .meter-label {
            text-align: center;
            font-size: 16px;
            font-weight: bold;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="tabs">
            <div class="tab active" data-target="personal">Aliceの個人データ</div>
            <div class="tab" data-target="team">家族のチームデータ</div>
        </div>

        <!-- 個人データ -->
        <div id="personal" class="content active">
            <div class="charts">
                <div>
                    <canvas id="personalChart"></canvas>
                    <div class="meter-label">収入: 100,000円</div>
                </div>
                <div class="meters">
                    <div>
                        <canvas id="personalLimitMeter"></canvas>
                        <div class="meter-label">使用限度額メーター</div>
                    </div>
                    <div>
                        <canvas id="personalGoalMeter"></canvas>
                        <div class="meter-label">貯金目標メーター</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- チームデータ -->
        <div id="team" class="content">
            <div class="charts">
                <div>
                    <canvas id="teamChart"></canvas>
                    <div class="meter-label">支出: 50,000円</div>
                </div>
                <div class="meters">
                    <div>
                        <canvas id="teamLimitMeter"></canvas>
                        <div class="meter-label">使用限度額メーター</div>
                    </div>
                    <div>
                        <canvas id="teamGoalMeter"></canvas>
                        <div class="meter-label">貯金目標メーター</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // タブ切り替え
        document.querySelectorAll('.tab').forEach(tab => {
            tab.addEventListener('click', () => {
                document.querySelectorAll('.tab').forEach(t => t.classList.remove('active'));
                document.querySelectorAll('.content').forEach(c => c.classList.remove('active'));
                tab.classList.add('active');
                document.getElementById(tab.getAttribute('data-target')).classList.add('active');
            });
        });

        // グラフ描画 - 個人
        new Chart(document.getElementById('personalChart'), {
            type: 'pie',
            data: {
                labels: ['食料品', '外食', '娯楽'],
                datasets: [{
                    data: [40, 30, 30],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                }]
            }
        });

        new Chart(document.getElementById('personalLimitMeter'), {
            type: 'doughnut',
            data: {
                labels: ['使用済み', '残額'],
                datasets: [{
                    data: [70, 30],
                    backgroundColor: ['#FF6384', '#E0E0E0']
                }]
            },
            options: { circumference: 180, rotation: -90 }
        });

        new Chart(document.getElementById('personalGoalMeter'), {
            type: 'doughnut',
            data: {
                labels: ['達成済み', '目標残額'],
                datasets: [{
                    data: [50, 50],
                    backgroundColor: ['#36A2EB', '#E0E0E0']
                }]
            },
            options: { circumference: 180, rotation: -90 }
        });

        // グラフ描画 - チーム
        new Chart(document.getElementById('teamChart'), {
            type: 'pie',
            data: {
                labels: ['食料品', '外食', '娯楽'],
                datasets: [{
                    data: [30, 20, 50],
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56']
                }]
            }
        });

        new Chart(document.getElementById('teamLimitMeter'), {
            type: 'doughnut',
            data: {
                labels: ['使用済み', '残額'],
                datasets: [{
                    data: [80, 20],
                    backgroundColor: ['#FF6384', '#E0E0E0']
                }]
            },
            options: { circumference: 180, rotation: -90 }
        });

        new Chart(document.getElementById('teamGoalMeter'), {
            type: 'doughnut',
            data: {
                labels: ['達成済み', '目標残額'],
                datasets: [{
                    data: [40, 60],
                    backgroundColor: ['#36A2EB', '#E0E0E0']
                }]
            },
            options: { circumference: 180, rotation: -90 }
        });
    </script>
</body>
</html>
