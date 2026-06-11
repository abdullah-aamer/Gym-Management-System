<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Add Equipment";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $stmt = mysqli_prepare($conn, "INSERT INTO EQUIPMENT (equipment_name, category, quantity_available, condition_status, last_maintenance_date) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "ssiss", $_POST["equipment_name"], $_POST["category"], $_POST["quantity_available"], $_POST["condition_status"], $_POST["last_maintenance_date"]);
    mysqli_stmt_execute($stmt);
    header("Location: equipment.php");
    exit();
}

require_once "includes/header.php";
require_once "includes/sidebar.php";
?>

<div class="form-card">
<form method="POST" class="form-grid">
    <div><label>Equipment Name</label><input class="input" name="equipment_name" required></div>
    <div><label>Category</label><input class="input" name="category" required></div>
    <div><label>Quantity Available</label><input class="input" type="number" name="quantity_available" required></div>
    <div><label>Condition</label><select name="condition_status"><option>Good</option><option>Needs Maintenance</option><option>Damaged</option></select></div>
    <div><label>Last Maintenance Date</label><input class="input" type="date" name="last_maintenance_date"></div>
    <div class="form-grid-full actions"><button class="btn">Save Equipment</button><a class="btn btn-light" href="equipment.php">Cancel</a></div>
</form>
</div>

<?php require_once "includes/footer.php"; ?>
