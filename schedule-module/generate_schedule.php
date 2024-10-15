<?php
include '../config/config.php';

if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get form data
    $emp_id = $_POST['emp_id'];
    $sched_date = $_POST['sched_date'];
    $sched_start_time = $_POST['sched_start_time'];
    $sched_end_time = $_POST['sched_end_time'];

    $query = "SELECT * FROM schedule WHERE emp_id = '$emp_id' AND sched_date = '$sched_date' 
              AND ('$sched_start_time' BETWEEN sched_start_time AND sched_end_time 
              OR '$sched_end_time' BETWEEN sched_start_time AND sched_end_time)";
    $result = mysqli_query($con, $query);

    if (mysqli_num_rows($result) > 0) {
        // Output JavaScript to display an alert
        echo "<script>alert('The nurse already has a schedule for this time slot.'); window.location.href = '../index.php?page=schedule&subpage=calendar';</script>";
    } else {
        // Insert the new schedule into the database
        $insert_query = "INSERT INTO schedule (emp_id, sched_date, sched_start_time, sched_end_time) 
                         VALUES ('$emp_id', '$sched_date', '$sched_start_time', '$sched_end_time')";

        if (mysqli_query($con, $insert_query)) {
            // Output JavaScript to display a success message
            echo "<script>alert('Schedule generated successfully!'); window.location.href = '../index.php?page=schedule&subpage=calendar';</script>";
        } else {
            // Output JavaScript to display an error message
            echo "<script>alert('Error: " . mysqli_error($con) . "'); window.location.href = '../index.php?page=schedule&subpage=calendar';</script>";
        }
    }
}

mysqli_close($con);
?>
