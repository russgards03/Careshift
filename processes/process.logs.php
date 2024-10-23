<?php
/*Include Logs Class File */
include '../class/class.logs.php';

// Create an instance of the Log class
$log = new Log(); // Ensure this is correctly pointing to your Log class

// Function to insert a schedule into the database
function insertSchedule($nurse_name, $schedule_date) {
    global $log; // Access the global log instance
    // Add your database insertion logic here. For example:
    try {
        // Assuming you have a PDO connection set up
        $conn = $log->conn; // Use the connection from the Log class
        $sql = "INSERT INTO schedules (nurse_name, schedule_date) VALUES (:nurse_name, :schedule_date)";
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['nurse_name' => $nurse_name, 'schedule_date' => $schedule_date]);
    } catch (PDOException $e) {
        // Log error or handle it as needed
        return false;
    }
}

// Function to update a schedule in the database
function updateSchedule($nurse_name, $schedule_date) {
    global $log; // Access the global log instance
    // Add your database update logic here. For example:
    try {
        $conn = $log->conn; // Use the connection from the Log class
        $sql = "UPDATE schedules SET schedule_date = :schedule_date WHERE nurse_name = :nurse_name"; // Adjust the WHERE clause as needed
        $stmt = $conn->prepare($sql);
        return $stmt->execute(['nurse_name' => $nurse_name, 'schedule_date' => $schedule_date]);
    } catch (PDOException $e) {
        // Log error or handle it as needed
        return false;
    }
}

function scheduleAdded($nurse_name, $schedule_date, $actor) {
    // Insert logic to add the schedule to the database
    // Assuming you have a function insertSchedule() that performs the database insertion
    $result = insertSchedule($nurse_name, $schedule_date);
    
    // Log the action if the schedule was added successfully
    if ($result) {
        global $log; // Access the global log instance
        $action = 'Added Schedule';
        $subject = 'Nurse Schedule for ' . $nurse_name;
        $description = 'Schedule added for ' . $nurse_name . ' on ' . $schedule_date;

        // Call the logging function
        $log->add_log($actor, $action, $subject, $description);
    }
    return $result; // Return the result of the insertion
}

// Function to edit a schedule
function scheduleEdited($nurse_name, $schedule_date, $actor) {
    // Insert logic to edit the schedule in the database
    // Assuming you have a function updateSchedule() that performs the database update
    $result = updateSchedule($nurse_name, $schedule_date);
    
    // Log the action if the schedule was edited successfully
    if ($result) {
        global $log; // Access the global log instance
        $action = 'Edited Schedule';
        $subject = 'Nurse Schedule for ' . $nurse_name;
        $description = 'Schedule edited for ' . $nurse_name . ' on ' . $schedule_date;

        // Call the logging function
        $log->add_log($actor, $action, $subject, $description);
    }
    return $result; // Return the result of the update
}

// Example of handling a form submission for adding a schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_schedule'])) {
    $nurse_name = $_POST['nurse_name']; // Get nurse name from form
    $schedule_date = $_POST['schedule_date']; // Get schedule date from form
    $actor = $_SESSION['username']; // Get the actor's username from session

    // Call the function to add the schedule
    if (scheduleAdded($nurse_name, $schedule_date, $actor)) {
        echo "Schedule added successfully.";
    } else {
        echo "Failed to add schedule.";
    }
}

// Example of handling a form submission for editing a schedule
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['edit_schedule'])) {
    $nurse_name = $_POST['nurse_name']; // Get nurse name from form
    $schedule_date = $_POST['schedule_date']; // Get new schedule date from form
    $actor = $_SESSION['username']; // Get the actor's username from session

    // Call the function to edit the schedule
    if (scheduleEdited($nurse_name, $schedule_date, $actor)) {
        echo "Schedule edited successfully.";
    } else {
        echo "Failed to edit schedule.";
    }
}
?>