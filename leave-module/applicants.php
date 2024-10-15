<div class="heading">
    <h1><i class="fas fa-solid fa-file-pen"></i>&nbspLeave Applicants</h1>
</div>

<table id="tablerecords">   
    <thead>
        <tr>
            <th>Nurse ID</th>
            <th>Applicants</th>
            <th>Department</th>
            <th>Leave Type</th>
        </tr>
    </thead>
    <tbody>
        <?php
        /* Display each admin record located in the database */
        if ($employee->list_employees() != false) {
            foreach ($employee->list_employees() as $value) {
                extract($value);
                // Create a link for each row using the emp_id
                $row_url = "index.php?page=employees&subpage=profile&id=" . $emp_id;
                ?>
                <tr onclick="location.href='<?php echo $row_url; ?>'" style="cursor: pointer;">
                    <td><?php echo $emp_id; ?></td>
                    <td><?php echo $emp_lname . ', ' . $emp_fname . ' ' . $emp_mname; ?></td>
                    <td><?php echo $emp_department; ?></td>
                    <td>Pregnancy</td>
                </tr>
                <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="5">"No Record Found."</td>
            </tr>
        <?php
        }
        ?>
    </tbody>
</table>
