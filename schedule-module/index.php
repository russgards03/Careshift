<div class="content_wrapper">
    <div class="heading">
        <h1><i class="fas fa-solid fa-clock"></i>&nbspSchedule</h1>

        <!-- Add Schedule Button (opens modal) -->
        <button id="addScheduleBtn" class="right_button">
            <i class="fa fa-plus"></i>&nbspAdd Schedule
        </button>

        <!-- Calendar Button -->
        <a href="index.php?page=schedule&subpage=calendar" class="right_button">
            <i class="fa fa-calendar"></i>&nbspCalendar
        </a>
    </div>
</div>

<!-- Modal Structure -->
<div id="addScheduleModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1><i class="fa fa-plus"></i>&nbspAdd Nurse Schedule</h1>
        <form method="post" action="schedule-module/generate_schedule.php">
            <label for="emp_id">Select Nurse:</label>
            <select name="emp_id" required>
                <?php
                if (!$con) {
                    die("Connection failed: " . mysqli_connect_error());
                }

                // Query to select nurses from the employee table
                $query = "SELECT emp_id, CONCAT(emp_fname, ' ', emp_lname) AS name FROM employee";
                $result = mysqli_query($con, $query);

                if ($result && mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<option value='{$row['emp_id']}'>{$row['name']}</option>";
                    }
                } else {
                    echo "<option>No nurses found</option>";
                }
                ?>
            </select>

            <!-- Date Selection -->
            <label for="sched_date">Select Date:</label>
            <input type="date" name="sched_date" required>

            <!-- Start Time Selection -->
            <label for="sched_start_time">Start Time:</label>
            <input type="time" name="sched_start_time" required>

            <!-- End Time Selection -->
            <label for="sched_end_time">End Time:</label>
            <input type="time" name="sched_end_time" required>

            <!-- Submit Button -->
            <button type="submit">Generate Schedule</button>
        </form>
    </div>
</div>

<?php
    $subpage = isset($_GET['subpage']) ? $_GET['subpage'] : 'calendar';

    switch($subpage){
        case 'add_sched':
            require_once 'add_schedule.php';
        break;
        case 'calendar':
            require_once 'calendar.php';
        break; 
        default:
            require_once 'calendar.php';
        break;
    }
?>
