<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Edit Membership Plan";
$id = intval($_GET["id"] ?? 0);

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $stmt = mysqli_prepare($conn, "UPDATE MEMBERSHIP_PLAN SET plan_name=?, duration_months=?, monthly_fee=?, plan_type=?, description=? WHERE plan_id=?");
    mysqli_stmt_bind_param($stmt, "sidssi", $_POST["plan_name"], $_POST["duration_months"], $_POST["monthly_fee"], $_POST["plan_type"], $_POST["description"], $id);
    mysqli_stmt_execute($stmt);
    header("Location: plans.php");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT * FROM MEMBERSHIP_PLAN WHERE plan_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

require_once "includes/header.php";
require_once "includes/sidebar.php";
?>

<div class="form-card">
<form method="POST" class="form-grid">
    <div><label>Plan Name</label><input class="input" name="plan_name" value="<?= safe($row['plan_name']) ?>" required></div>
    <div><label>Duration Months</label><input class="input" type="number" name="duration_months" value="<?= safe($row['duration_months']) ?>" required></div>
    <div><label>Monthly Fee</label><input class="input" type="number" step="0.01" name="monthly_fee" value="<?= safe($row['monthly_fee']) ?>" required></div>
    <div><label>Plan Type</label><select name="plan_type">
        <?php foreach(["Basic","Standard","Premium","Student","Personal Training"] as $type): ?>
            <option <?= $row["plan_type"]==$type ? "selected" : "" ?>><?= $type ?></option>
        <?php endforeach; ?>
    </select></div>
    <div class="form-grid-full"><label>Description</label><textarea name="description" required><?= safe($row["description"]) ?></textarea></div>
    <div class="form-grid-full actions"><button class="btn">Update Plan</button><a class="btn btn-light" href="plans.php">Cancel</a></div>
</form>
</div>

<?php require_once "includes/footer.php"; ?>
