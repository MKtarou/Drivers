<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>家計簿カレンダー</title>
    <link rel="stylesheet" href="{{asset('css/calendar.css')}}">
</head>
<body>

    @include('homebudget.sidebar')
    <div class="calendar-container">
        <h1>カレンダー</h1>
        <div class="controls">
            <button onclick="changeMonth(-1)">◀</button>
            <a id="currentMonth" href="{{ route('balance', ['month' => $currentMonth, 'year' => $currentYear]) }}" style="text-decoration: none; color: black;">
                {{ $currentYear }}年 {{ $currentMonth }}月
            </a>
            <button onclick="changeMonth(1)">▶</button>
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
                        if (entry.total_income !== 0 || entry.total_expenditure !== 0) {
                            cell.innerHTML += `
                                <div>${entry.user_name || ''}
                                ${entry.total_income !== 0 ? `+${formatNumber(entry.total_income)}` : ''}
                                ${entry.total_expenditure !== 0 ? `-${formatNumber(Math.abs(entry.total_expenditure))}` : ''}
                                ${entry.details ? `${entry.details}</div>` : ''}
                            `;
                        }
                    });
                }
            });
        }

        function generateCalendar(month, year) {
            const calendar = document.getElementById('calendar');
            calendar.innerHTML = '';

            const daysInMonth = new Date(year, month, 0).getDate();
            const firstDayOfMonth = new Date(year, month - 1, 1).getDay();

            document.getElementById('currentMonth').textContent = `${year}年 ${month}月`;

            const dayLabels = ["日", "月", "火", "水", "木", "金", "土"];
            dayLabels.forEach((day, index) => {
                const dayLabel = document.createElement('div');
                dayLabel.classList.add('calendar-day', 'day-label');
                dayLabel.classList.add(index === 0 ? 'sunday-label' : index === 6 ? 'saturday-label' : 'weekday-label');
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
