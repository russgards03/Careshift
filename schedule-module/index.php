<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Schedule</title>
</head>
<body>
    <h1>Schedule</h1>
    <div class="dashboard-wrapper">
        <form method="POST" action="">
            <div class="button-container">
                <button type="submit" name="page" value="add-schedule">Add Schedule</button>
                <button type="submit" name="page" value="edit-schedule">Edit Schedule</button>
                <button type="submit" name="page" value="calendar">Calendar</button>
            </div>
        </form>
        <div class="main_content">
            <?php
                $page = isset($_POST['page']) ? $_POST['page'] : 'calendar';

                switch($page){
                    case 'add-schedule':
                        require_once 'schedule-module/add-sched.php';
                        break;
                    case 'edit-schedule':
                        require_once 'schedule-module/edit-sched.php';
                        break;
                    case 'calendar':
                    default:
                        require_once 'schedule-module/calendar.php';
                        break; 
                }
            ?>
        </div>
    </div>
</body>
</html>