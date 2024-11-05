<div class="heading">
    <h1><i class="fas fa-regular fa-paste"></i>&nbspLeave Applicants</h1>
    <a href="index.php?page=leave&subpage=add" class="right_button"><i class="fa fa-file-pen" aria-hidden="true"></i>&nbspApply Leave</a>
</div>
<span class="right">
    <div class="search_bar">
        <label for="search">Search:</label>
        <input type="text" id="search" class="search" name="search" onkeyup="filterTable()">
    </div>
</span>
<table id="tablerecords">   
    <thead>
        <tr>
            <th>Leave ID</th>
            <th>Nurse</th>
            <th>Date Filed</th>
            <th>Time Filed</th>
            <th>Leave Start Date</th>
            <th>Leave End Date</th>
            <th>Leave Type</th>
            <th>Leave Status</th>
        </tr>
    </thead>
    <tbody>
    <?php
    /* Display each leaves record located in the database */
    if ($leave->list_leaves() != false) {
        foreach ($leave->list_leaves() as $value) {
            extract($value);
            // Create a link for each row using the nurse_id
            $row_url = "index.php?page=leave&subpage=profile&id=" . $leave_id;
            
            // Determine class based on leave status
            $status_class = '';
            if ($leave_status === 'Denied') {
                $status_class = 'leave-status-denied';
            } elseif ($leave_status === 'Approved') {
                $status_class = 'leave-status-approved';
            } elseif ($leave_status === 'Pending') {
                $status_class = 'leave-status-pending';
            }
            ?>
            <tr onclick="location.href='<?php echo $row_url; ?>'" style="cursor: pointer;">
                <td><?php echo $leave_id; ?></td>
                <td><?php echo $leave->get_leave_nurse_name($leave_id); ?></td>
                <td><?php echo $leave->get_leave_date_filed($leave_id);?></td>
                <td><?php echo $leave->get_leave_time_filed($leave_id);?></td>
                <td><?php echo $leave->get_leave_start_date($leave_id);?></td>
                <td><?php echo $leave->get_leave_end_date($leave_id);?></td>
                <td><?php echo $leave_type; ?></td>
                <td class="<?php echo $status_class; ?>">
                    <?php echo $leave_status; ?>
                </td>
            </tr>
            <?php
        }
    } else {
        ?>
        <tr>
            <td colspan="6">No Record Found.</td>
        </tr>
    <?php
    }
    ?>
</tbody>

</table>