<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard-wrapper">
        <div class="calendar">
            <div class="calendar-header">
                <button id="prev" onclick="prevMonth()">&#10094;</button>
                <div id="month-year"></div>
                <button id="next" onclick="nextMonth()">&#10095;</button>
            </div>
            <div class="calendar-body">
                <div class="day-names">
                    <span>Sun</span>
                    <span>Mon</span>
                    <span>Tue</span>
                    <span>Wed</span>
                    <span>Thu</span>
                    <span>Fri</span>
                    <span>Sat</span>
                </div>
                <div class="days" id="calendar-days"></div>
            </div>
        </div>
    </div>

    <div id="schedule-details" style="margin-top: 20px; display: none;">
        <h2>Assigned Employees for <span id="selected-date"></span></h2>
        <ul id="employee-list"></ul>
    </div>
    

    <script src="script/script.js"></script>
</body>
</html>