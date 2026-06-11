<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Reports / SQL Views";
require_once "includes/header.php";
require_once "includes/sidebar.php";

$active = mysqli_query($conn, "SELECT * FROM view_active_member_report");
$trainer = mysqli_query($conn, "SELECT * FROM view_trainer_workload_report");
$equipment = mysqli_query($conn, "SELECT * FROM view_equipment_usage_report");

function render_report_table($result){
    if(!$result || mysqli_num_rows($result) == 0){
        echo "<div class='table-wrap'><table><tr><td>No records found.</td></tr></table></div>";
        return;
    }

    echo "<div class='table-wrap'><table>";
    $first = true;
    while($row = mysqli_fetch_assoc($result)){
        if($first){
            echo "<tr>";
            foreach(array_keys($row) as $head){
                echo "<th>" . safe($head) . "</th>";
            }
            echo "</tr>";
            $first = false;
        }
        echo "<tr>";
        foreach($row as $value){
            echo "<td>" . safe($value) . "</td>";
        }
        echo "</tr>";
    }
    echo "</table></div>";
}
?>

<h2 class="section-title">Active Member Report View</h2>
<?php render_report_table($active); ?>

<h2 class="section-title">Trainer Workload Report View</h2>
<?php render_report_table($trainer); ?>

<h2 class="section-title">Equipment Usage Report View</h2>
<?php render_report_table($equipment); ?>

<?php require_once "includes/footer.php"; ?>
