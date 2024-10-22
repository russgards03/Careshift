<h1>Logs</h1>
<div class="content_wrapper">
    <table id="tablerecords">   
        <thead>
            <tr>
                <th>Date</th>
                <th>Time</th>
                <th>Actor</th>
                <th>Action</th>
                <th>Subject</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
        <?php
        /* Display each log record from the database */
        if ($logs = $log->list_logs()) {
            foreach ($logs as $value) {
                extract($value);
                ?>
                <tr>
                    <td><?php echo $log_date_managed; ?></td>
                    <td><?php echo $log_time_managed; ?></td>
                    <td><?php echo $adm_fname . ' ' . $adm_lname; ?></td> <!-- Use the first and last name of the admin -->
                    <td><?php echo $log_action; ?></td>
                    <td><?php echo isset($nurse_lname) ? $nurse_fname . ' ' . $nurse_lname : 'N/A'; ?></td> 
                    <td><?php echo $log_description; ?></td>
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
</div>
