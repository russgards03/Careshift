<?php
include '../config/config.php';
include '../class/class.schedule.php';

$action = isset($_GET['action']) ? $_GET['action'] : '';

switch ($action) {
    case 'new':
        create_new_schedule($con);
        break;
    case 'update':
        update_nurse();
        break;
    case 'delete':
        delete_nurse();
        break;
}

function create_new_schedule($con) {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $nurse_id = $_POST['nurse_id'];
        $sched_date = $_POST['sched_date'];
        $sched_start_time = $_POST['sched_start_time'];
        $work_hours = $_POST['work_hours'];

        $start_time = new DateTime($sched_date . ' ' . $sched_start_time);
        $end_time = clone $start_time; 
        $end_time->modify("+{$work_hours} hours");

        $formatted_start_time = $start_time->format('H:i:s');
        $formatted_end_time = $end_time->format('H:i:s');
        $end_date = $end_time->format('Y-m-d'); 

        $insert_query = "INSERT INTO schedule (nurse_id, sched_date, sched_start_time, sched_end_time) 
                         VALUES ('$nurse_id', '$sched_date', '$formatted_start_time', '$formatted_end_time')";

        if (mysqli_query($con, $insert_query)) {
            $log_action = "Added Schedule";
            $log_description = "Added a new schedule for nurse ID $nurse_id";
            $log_date_managed = date('Y-m-d');
            $log_time_managed = date('H:i:s'); 
            $adm_id = $_SESSION['adm_id']; 

            $log_insert_query = "INSERT INTO logs (log_action, log_description, log_time_managed, log_date_managed, adm_id, nurse_id) 
                                 VALUES ('$log_action', '$log_description', '$log_time_managed', '$log_date_managed', '$adm_id', '$nurse_id')";

            mysqli_query($con, $log_insert_query);

            echo "<script>alert('Schedule generated successfully!'); window.location.href = '../index.php?page=schedule&subpage=calendar';</script>";
        } else {
            echo "<script>alert('Error: " . mysqli_error($con) . "'); window.location.href = '../index.php?page=schedule&subpage=calendar';</script>";
        }
    }
}

mysqli_close($con);
?>
