<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>{{ $groupName }}の家計簿ダッシュボード</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    

<div class="dashboard-container">
    <div class="sidebar">
        <!-- サイドバーやナビゲーションリンクなど -->
        <div class="tab-menu">
            <a href="#" class="active">個人</a>
            <a href="#">グループ</a>
        </div>
    </div>
    
    <div class="chart-area">
        <canvas id="categoryChart"></canvas>
    </div>

    <div class="meter-area">
        <div class="meter">
            <canvas id="savingGoalMeter"></canvas>
            <div class="meter-label">貯金目標達成度</div>
        </div>

        <div class="meter">
            <canvas id="monthlyBalanceMeter"></canvas>
            <div class="meter-label">月の収支達成度</div>
        </div>
    </div>
</div>

<div class="total-summary">
    <p>収入合計: 250000円</p>
    <p>支出合計: -157476円</p>
</div>



    <script>
        // 貯金目標メーターの設定
        var savingGoalMeterCtx = document.getElementById('savingGoalMeter').getContext('2d');
        var savingGoalMeter = new Chart(savingGoalMeterCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [60, 40], // 目標達成率と残り
                    backgroundColor: ['#4caf50', '#e0e0e0']
                }]
            },
            options: {
                responsive: true,
                cutout: '70%', // メーターの厚さ調整
                rotation: -90, // メーターを半円に見せるための調整
                circumference: 180, // 半円表示
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        // 月の収支メーターの設定
        var monthlyBalanceMeterCtx = document.getElementById('monthlyBalanceMeter').getContext('2d');
        var monthlyBalanceMeter = new Chart(monthlyBalanceMeterCtx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [75, 25], // 月の収支達成率と残り
                    backgroundColor: ['#4caf50', '#e0e0e0']
                }]
            },
            options: {
                responsive: true,
                cutout: '70%',
                rotation: -90,
                circumference: 180,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });


    </script>
</body>
</html>
