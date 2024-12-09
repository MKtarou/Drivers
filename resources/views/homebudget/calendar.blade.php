<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>家計簿カレンダー</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f8f0fc;
            color: #333;
        }

        .calendar-container {
            max-width: 1100px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            text-align: center;
        }

        h1 {
            font-size: 24px;
            margin: 10px 0;
            color: #333;
        }

        .controls {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 50px;
            margin: 20px 0;
        }

        .controls button, .controls a.control-btn {
            background: none;
            border: 2px solid #9b59b6;
            font-size: 16px;
            cursor: pointer;
            padding: 5px 10px;
            color: #9b59b6;
            border-radius: 6px;
            text-decoration: none;
            transition: background-color 0.3s, color 0.3s;
        }

        .controls button:hover, .controls a.control-btn:hover {
            background-color: #9b59b6;
            color: #fff;
        }

        #currentMonth {
            font-weight: bold;
            color: #9b59b6;
            text-decoration: none;
        }

        .calendar {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 1px;
            background-color: #f2f2f2;
            border-radius: 4px;
        }

        .day-label {
            padding: 10px 0;
            text-align: center;
            font-weight: bold;
            background-color: #e9e9e9;
            font-size: 14px;
            color: #555;
        }

        .sunday-label {
            background-color: #ffeaea; 
            color: #d64550; 
        }

        .saturday-label {
            background-color: #e8f3ff; 
            color: #4067d4; 
        }

        .calendar-day {
            border: 1px solid #ddd;
            padding: 5px;
            min-height: 100px;
            background-color: #fff;
            position: relative;
            transition: transform 0.2s ease, z-index 0.2s ease;
            z-index: 0;
        }

        .calendar-day strong {
            display: block;
            text-align: right;
            color: #333; 
            font-size: 16px;
            margin-bottom: 5px;
        }

        .calendar-day:hover {
            transform: scale(1.2);
            z-index: 10;
            background-color: #f4e6fc;
            box-shadow: 0 0 4px rgba(0,0,0,0.1);
        }

        .calendar-day div {
            font-size: 12px;
            color: #555;
            word-wrap: break-word;
            margin-bottom: 3px;
        }

        .saturday {
            color: #4067d4;
        }

        .sunday, .holiday {
            color: #d64550;
        }

        .summary-container {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .summary-box {
            flex: 1;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 8px;
            text-align: center;
            background-color: #f4e6fc;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }

        .summary-box h2 {
            font-size: 18px;
            color: #9b59b6;
            margin-bottom: 10px;
        }

        .summary-box p {
            font-size: 24px;
            font-weight: bold;
            color: #333;
        }
    </style>
    <link rel="stylesheet" href="{{asset('css/calendar.css')}}">
    <link rel="icon" href="{{ asset('/favicon.ico') }}" type="image/x-icon">
</head>
<body>
    @include('homebudget.sidebar')
    <div class="calendar-container">
        <div class="controls">
            <button onclick="changeMonth(-1)" class="control-btn">◀</button>
            <a id="currentMonth" href="{{ route('balance', ['month' => $currentMonth, 'year' => $currentYear]) }}" style="text-decoration: none; color: black;">
                {{ $currentYear }}年 {{ $currentMonth }}月
            </a>
            <button onclick="changeMonth(1)" class="control-btn">▶</button>
        </div>

        <div id="calendar" class="calendar"></div>

        <div class="summary-container">
            <div class="summary-box">
                <h2>今月の収入</h2>
                <p id="totalIncome">{{ number_format($totalIncome) }}</p>
            </div>
            <div class="summary-box">
                <h2>今月の支出</h2>
                <p id="totalExpenditure">{{ number_format($totalExpenditure) }}</p>
            </div>
        </div>
    </div>
    <script>
        const transactions = @json($transactions);
        let currentMonth = {{ $currentMonth }};
        let currentYear = {{ $currentYear }};

        function formatNumber(num) {
            return num.toLocaleString();
        }

        function loadMonthlyTransactions() {
            Object.keys(transactions).forEach(day => {
                const cell = document.getElementById(`day-${day}`);
                if (cell) {
                    cell.innerHTML = `<strong>${day}</strong>`;
                    transactions[day].forEach(entry => {
                        const transactionDiv = document.createElement('div');
                        transactionDiv.innerHTML = `
                            ${entry.user_name || ''} 
                            ${entry.total_income !== 0 ? '+'+formatNumber(entry.total_income) : ''} 
                            ${entry.total_expenditure !== 0 ? '-'+formatNumber(Math.abs(entry.total_expenditure)) : ''} 
                            ${entry.details || ''}
                        `;
                        cell.appendChild(transactionDiv);
                    });
                }
            });
        }

        function generateCalendar(month, year) {
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';

            const daysInMonth = new Date(year, month, 0).getDate();
            const firstDayOfMonth = new Date(year, month - 1, 1).getDay();

            const dayLabels = ["日", "月", "火", "水", "木", "金", "土"];
            dayLabels.forEach((day, index) => {
                const dayLabel = document.createElement('div');
                dayLabel.classList.add('calendar-day', 'day-label');
                if (index === 0) dayLabel.classList.add('sunday-label');
                if (index === 6) dayLabel.classList.add('saturday-label');
                dayLabel.textContent = day;
                calendar.appendChild(dayLabel);
            });

            for (let i = 0; i < firstDayOfMonth; i++) {
                const emptyCell = document.createElement('div');
                emptyCell.classList.add('calendar-day');
                calendar.appendChild(emptyCell);
            }

            for (let day = 1; day <= daysInMonth; day++) {
                const cell = document.createElement('div');
                cell.classList.add('calendar-day');
                cell.id = `day-${day}`;
                cell.innerHTML = `<strong>${day}</strong>`;
                calendar.appendChild(cell);
            }
            loadMonthlyTransactions();
        }

        function changeMonth(offset) {
            currentMonth += offset;
            if (currentMonth > 12) {
                currentMonth = 1;
                currentYear++;
            } else if (currentMonth < 1) {
                currentMonth = 12;
                currentYear--;
            }
            const queryParams = new URLSearchParams({ month: currentMonth, year: currentYear });
            window.location.href = "?" + queryParams.toString();
        }

        generateCalendar(currentMonth, currentYear);
    </script>
</body>
</html>
