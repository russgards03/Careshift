<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css"> <!-- Link to your CSS file -->
    <title>Add Schedule</title>
</head>
<body>
<h1>Add Schedule</h1>
    <div class="dashboard-wrapper">
        <form action="process_schedule.php" method="POST"> 
            <label for="employee">Assigned Employee:</label>
            <select id="employee" name="employee" required>
                <option value="">Select an employee</option>
                <option value="employee1">Employee 1</option>
                <option value="employee2">Employee 2</option>
                <option value="employee3">Employee 3</option>
            </select>

            <label for="date">Assign Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="time">Assign Time:</label>
            <input type="time" id="time" name="time" required>

            <button type="submit">Confirm</button> 
        </form>
    </div>
</body>
</html>
</div>
