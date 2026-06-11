<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Edit Equipment";
$id = intval($_GET["id"] ?? 0);

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $stmt = mysqli_prepare($conn, "UPDATE EQUIPMENT SET equipment_name=?, category=?, quantity_available=?, condition_status=?, last_maintenance_date=? WHERE equipment_id=?");
    mysqli_stmt_bind_param($stmt, "ssissi", $_POST["equipment_name"], $_POST["category"], $_POST["quantity_available"], $_POST["condition_status"], $_POST["last_maintenance_date"], $id);
    mysqli_stmt_execute($stmt);
    header("Location: equipment.php");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT * FROM EQUIPMENT WHERE equipment_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

require_once "includes/header.php";
require_once "includes/sidebar.php";
?>

<div class="form-card">
<form method="POST" class="form-grid">
    <div><label>Equipment Name</label><input class="input" name="equipment_name" value="<?= safe($row['equipment_name']) ?>" required></div>
    <div><label>Category</label><input class="input" name="category" value="<?= safe($row['category']) ?>" required></div>
    <div><label>Quantity Available</label><input class="input" type="number" name="quantity_available" value="<?= safe($row['quantity_available']) ?>" required></div>
    <div><label>Condition</label><select name="condition_status">
        <?php foreach(["Good","Needs Maintenance","Damaged"] as $status): ?>
            <option <?= $row["condition_status"]==$status ? "selected" : "" ?>><?= $status ?></option>
        <?php endforeach; ?>
    </select></div>
    <div><label>Last Maintenance Date</label><input class="input" type="date" name="last_maintenance_date" value="<?= safe($row['last_maintenance_date']) ?>"></div>
    <div class="form-grid-full actions"><button class="btn">Update Equipment</button><a class="btn btn-light" href="equipment.php">Cancel</a></div>
</form>
</div>

<?php require_once "includes/footer.php"; ?>
