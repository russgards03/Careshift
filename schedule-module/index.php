<h1>Schedule</h1>
<div class="dashboard-wrapper">
    <div class="">
        <table id="tablerecords">   
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Schedule</th>
                </tr>
            </thead>
            <tbody>
            <?php
                /* Display each employee's records located in the database */
                if($employee->list_employees() != false){
                    foreach($employee->list_employees() as $value){
                        extract($value);
                        ?>
                        <tr>
                            <td>
                                <a href="#" onclick="fetchSchedule(<?php echo $emp_id; ?>)">
                                    <?php echo $emp_lname.', '.$emp_fname;?>
                                </a>
                            </td>
                            <td id="schedule-<?php echo $emp_id; ?>"> <!-- Placeholder for the schedule -->
                                Click on the name to view schedule
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    ?>
                    <tr>
                        <td colspan="2">"No Record Found."</td>
                    </tr>
                <?php
                }
            ?>
            </tbody>
        </table>
    </div>
</div>

<script>
// Function to fetch schedule using Ajax
function fetchSchedule(empId) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', 'schedule-module/view_schedule.php?emp_id=' + empId, true);
    xhr.onload = function() {
        if (this.status == 200) {
            // Assuming the server returns the schedule as a string
            document.getElementById('schedule-' + empId).innerHTML = this.responseText;
        } else {
            document.getElementById('schedule-' + empId).innerHTML = 'Error fetching schedule';
        }
    };
    xhr.send();
}
</script>