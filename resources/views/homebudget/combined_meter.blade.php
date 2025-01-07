<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
    <title>家計簿メーター</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f0fc;
            color: #333;
        }

        .container {
            max-width: 1500px;
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
            width: 350px;
            align-items: center;
        }

        .meter canvas {
            max-width: 200px;
            max-height: 200px;
        }

        .chart-section p, .meter p {
            margin: 0px 0;
            font-size: 16px;
            font-weight: bold;
        }

        .controls {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px; /* ボタンとテキストの間隔を空ける */
            margin-bottom: 20px;
        }

        .controls span {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }

        .control-btn {
            text-decoration: none;
            background: none;
            border: 2px solid #9b59b6;
            padding: 5px 10px;
            border-radius: 4px;
            color: #9b59b6;
            transition: background-color 0.3s, color 0.3s;
            font-weight: bold;
        }

        .control-btn:hover {
            background-color: #9b59b6;
            color: #fff;
        }

        /* モーダル初期非表示 */
        .modal {
        display: none;
        position: fixed;
        z-index: 9999; /* 手前に表示 */
        left: 0; 
        top: 0;
        width: 100%;
        height: 100%;
        overflow: auto; /* モーダル内がはみ出す場合にスクロール */
        background-color: rgba(0,0,0,0.5); /* 背景を半透明にする */
        }

        .modal-content {
        background-color: #fff;
        margin: 10% auto;
        padding: 20px;
        border-radius: 10px;
        width: 300px;
        position: relative;
        }

        .close {
        position: absolute;
        right: 15px;
        top: 15px;
        font-size: 18px;
        cursor: pointer;
        }

        .saving-button {
        margin-top: 10px;
        padding: 5px 10px;
        background-color: #9b59b6;
        color: #fff;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        }
        .saving-button:hover {
        background-color: #7d3c98;
        }

    </style>
</head>
<body>

@include('homebudget.sidebar')
    <div class="container">
        <!-- タブ -->
        <div class="tabs">
            <div class="tab {{ $activeTab === 'personal' ? 'active' : '' }}" data-target="personal">{{ $u_name }}のデータ</div>
            <div class="tab {{ $activeTab === 'team' ? 'active' : '' }}" data-target="team">{{ $g_name }}のデータ</div>
        </div>

        <div class="controls">
            <a href="{{ route('combined.meter', [
                'month' => $month == 1 ? 12 : $month - 1,
                'year' => $month == 1 ? $year - 1 : $year,
                'tab' => $activeTab
            ]) }}" class="control-btn">◀ 前月</a>

            <span>{{ $year }}年 {{ $month }}月のデータ</span>

            <a href="{{ route('combined.meter', [
                'month' => $month == 12 ? 1 : $month + 1,
                'year' => $month == 12 ? $year + 1 : $year,
                'tab' => $activeTab
            ]) }}" class="control-btn">次月 ▶</a>
        </div>

        <!-- 個人データ -->
        <div id="personal" class="content {{ $activeTab === 'personal' ? 'active' : '' }}">

            <div class="grid">
                <!-- 個人データのグラフ -->
                <div class="chart-section">
                    <canvas id="personalChart"></canvas>
                    <p>個人支出合計：{{ number_format($personalExpense) }}円</p>
                </div>

                <!-- 個人メーター -->
                <div class="meter-section">
                    <div class="meter">
                        <h2>使用限度額メーター</h2>
                        <canvas id="personalLimitMeter"></canvas>
                        @php
                            $personalRemainder = $u_limit + $personalExpense; // 残りの使用可能額
                        @endphp
                        <p>
                            使用額 {{ number_format($personalExpense * -1) }}円 / 限度額 {{ number_format($u_limit) }}円 <br>
                            残りの使用可能額 {{ number_format($personalRemainder) }}円
                            @if($personalRemainder < 0)
                                <span style="color:red; font-weight:bold;"> Over!!</span>
                            @endif
                            <br>
                            
                        </p>
                    </div>


                    <div class="meter">
                        <h2>貯金目標メーター</h2>
                        <canvas id="personalGoalMeter"></canvas>
                        @php
                            $personalGoalRemainder = $u_goal - $u_savings; // 残り目標額
                        @endphp
                        <p>
                            貯金額 {{ number_format($u_savings) }}円 / 目標額 {{ number_format($u_goal) }}円<br>

                            @if($personalGoalRemainder <= 0)
                                <span style="color:green; font-weight:bold;" text-align: center;> 目標達成!!</span>
                            @else
                                目標まで残り{{ number_format( $u_goal - $u_savings) }}円
                            @endif
                        </p>

                        <!-- 貯金額追加ボタン -->
                        <button type="button" id="openSavingModal" class="saving-button">貯金額追加</button>
                    </div>

                    <!-- モーダル（ポップアップ） -->
                    <div id="savingModal" class="modal">
                    <div class="modal-content">
                        <span id="closeSavingModal" class="close">&times;</span>
                        <h2>貯金を追加</h2>
                        <form action="{{ route('add.personal.saving') }}" method="POST">
                        @csrf
                        <!-- month, yearを維持したい場合はhiddenで渡す -->
                        <input type="hidden" name="month" value="{{ $month }}">
                        <input type="hidden" name="year" value="{{ $year }}">

                        <label for="addedSaving">貯金額 (マイナスで減額)</label>
                        <input type="number" name="addedSaving" id="addedSaving" required>

                        <button type="submit">追加</button>
                        </form>
                    </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- チームデータ -->
        <div id="team" class="content {{ $activeTab === 'team' ? 'active' : '' }}">
            <div class="grid">
                <!-- チームデータのグラフ -->
                <div class="chart-section">
                    <canvas id="teamChart"></canvas>
                    <p>グループ支出合計：{{ number_format($teamExpense) }}円</p>
                </div>

                <!-- チームメーター -->
                <div class="meter-section">
                    <div class="meter">
                        <h2>使用限度額メーター</h2>
                        <canvas id="teamLimitMeter"></canvas>
                        @php
                            $teamRemainder = $g_limit + $teamExpense;
                        @endphp
                        <p>
                            使用額 {{ number_format($teamExpense * -1) }}円 / 限度額 {{ number_format($g_limit) }}円<br>
                            残りの使用可能額 {{ number_format($teamRemainder) }}円
                            @if($teamRemainder < 0)
                                <span style="color:red; font-weight:bold;"> Over!!</span>
                            @endif
                            <br>
                            
                        </p>
                    </div>

                    <div class="meter">
                        <h2>貯金目標メーター</h2>
                        <canvas id="teamGoalMeter"></canvas>
                        @php
                            $teamGoalRemainder = $g_goal - $g_savings;
                        @endphp
                        <p>
                            貯金額 {{ number_format($g_savings) }}円 / 目標額 {{ number_format($g_goal) }}円<br>
   
                            @if($teamGoalRemainder <= 0)
                                <span style="color:green; font-weight:bold;"> 目標達成！</span>
                            @else
                            目標まで残り{{ number_format( $g_goal - $g_savings) }}円
                            @endif
                        </p>
                        <button type="button" id="openGroupSavingModal" class="saving-button">グループ貯金額追加</button>
                    </div>
                </div>

                <!-- グループ用モーダル（ポップアップ） -->
                <div id="groupSavingModal" class="modal">
                    <div class="modal-content">
                        <span id="closeGroupSavingModal" class="close">&times;</span>
                        <h2>グループ貯金を追加</h2>
                        <form action="{{ route('add.group.saving') }}" method="POST">
                        @csrf
                        <!-- month, yearを維持したい場合はhiddenで渡す -->
                        <input type="hidden" name="month" value="{{ $month }}">
                        <input type="hidden" name="year" value="{{ $year }}">
                        <input type="hidden" name="tab" value="team">
                        <label for="groupAddedSaving">貯金額 (マイナスで減額)</label>
                        <input type="number" name="groupAddedSaving" id="groupAddedSaving" required>

                        <button type="submit">追加</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>


        

        // タブ切り替え機能
        document.querySelectorAll('.tab').forEach(tab => {
    tab.addEventListener('click', () => {
        const selectedTab = tab.getAttribute('data-target'); 

        // パラメータを更新してリロード
        const url = new URL(window.location.href);
        url.searchParams.set('tab', selectedTab);
        window.location.href = url.toString();
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
        const personalRemainder = uLimit - Math.abs(personalExpense);
        new Chart(document.getElementById('personalLimitMeter'), {
            type: 'doughnut',
            data: {
                labels: ['使用済み', '残額'],
                datasets: [{
                    data: [Math.abs(personalExpense), Math.max(personalRemainder, 0)],
                    backgroundColor: [
                        '#4CAF50', 
                        personalRemainder >= 0 ? '#E0E0E0' : 'red' // 残額が負の場合は赤、それ以外は灰色
                    ]
                }]
            },
            options: { 
                circumference: 180,
                rotation: -90
            }
        });



        // 個人貯金目標メーター
        const personalGoalRemainder = uGoal - uSaving;  // 残りの目標
        new Chart(document.getElementById('personalGoalMeter'), {
            type: 'doughnut',
            data: {
                labels: ['貯金済み', '残額'],
                datasets: [{
                    // 貯金済みと目標残額。残額が負なら0にして描画
                    data: [Math.abs(uSaving), Math.max(personalGoalRemainder, 0)],
                    backgroundColor: [
                        '#36A2EB', 
                        personalGoalRemainder >= 0 ? '#E0E0E0' : 'blue' // 目標超過で青
                    ]
                }]
            },
            options: { 
                circumference: 180,
                rotation: -90
            }
        });

        // チーム使用限度額メーター
        const teamRemainder = gLimit - Math.abs(teamExpense);
        new Chart(document.getElementById('teamLimitMeter'), {
            type: 'doughnut',
            data: {
                labels: ['使用済み', '残額'],
                datasets: [{
                    data: [Math.abs(teamExpense), Math.max(teamRemainder, 0)],
                    backgroundColor: [
                        '#4CAF50', 
                        teamRemainder >= 0 ? '#E0E0E0' : 'red' // 残額が負の場合は赤、それ以外は灰色
                    ]
                }]
            },
            options: { 
                circumference: 180,
                rotation: -90
            }
        });


        // チーム貯金目標メーター
        const teamGoalRemainder = gGoal - gSaving;  // 残りの目標
        new Chart(document.getElementById('teamGoalMeter'), {
            type: 'doughnut',
            data: {
                labels: ['貯金済み', '残額'],
                datasets: [{
                    // gSavingが目標を超えたら残額を0扱いし、色をblueに
                    data: [Math.abs(gSaving), Math.max(teamGoalRemainder, 0)],
                    backgroundColor: [
                        '#36A2EB', 
                        teamGoalRemainder >= 0 ? '#E0E0E0' : 'blue' // 超過時、残額部分を青
                    ]
                }]
            },
            options: { 
                circumference: 180,
                rotation: -90
            }
        });



        //個人貯金追加モーダル
        const openBtn = document.getElementById('openSavingModal');
        const modal = document.getElementById('savingModal');
        const closeBtn = document.getElementById('closeSavingModal');

        openBtn.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        closeBtn.addEventListener('click', () => {
            modal.style.display = 'none';
        });

        // モーダル外クリックで閉じる場合
        window.addEventListener('click', (e) => {
            if (e.target === modal) {
                modal.style.display = 'none';
            }
        });



        // グループ貯金モーダル
        const openGroupBtn = document.getElementById('openGroupSavingModal');
        const groupModal = document.getElementById('groupSavingModal');
        const closeGroupBtn = document.getElementById('closeGroupSavingModal');

        openGroupBtn.addEventListener('click', () => {
            groupModal.style.display = 'block';
        });

        closeGroupBtn.addEventListener('click', () => {
            groupModal.style.display = 'none';
        });

        // モーダル外クリックで閉じる
        window.addEventListener('click', (e) => {
            if (e.target === groupModal) {
                groupModal.style.display = 'none';
            }
        });
    </script>
</body>
</html>
