<?php
// Set up the database connection as you like
$dbconn = pg_connect("user=postgres dbname=emergency_waitlist");
if (!$dbconn) {
    echo "Failed to connect to database";
    exit;
}
$result = pg_query($dbconn, "SELECT * FROM patients");
if (!$result) {
    echo "Failed to query database";
    exit;
}
$data = pg_fetch_all($result);
?>

<style>
.table-container {
    margin: 20px;
}
table {
    width: 100%;
}
table tr th {
    text-align: left;
    background-color: #D9E2EC;
}
</style>

<div class="table-container">
    <table>
        <tr>
            <th>patient_name</th>
            <th>severity</th>
            <th>date_triage</th>
        </tr>
        <?php foreach ($data as $row) {?>
            <tr>
                <td><?php echo $row["patient_name"] ?></td>
                <td><?php echo $row["severity"] ?></td>
                <td><?php echo $row["date_triage"] ?></td>
            </tr>
        <?php } ?>
    </table>
</div>