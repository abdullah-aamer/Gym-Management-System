<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Add Membership Plan";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $stmt = mysqli_prepare($conn, "INSERT INTO MEMBERSHIP_PLAN (plan_name, duration_months, monthly_fee, plan_type, description) VALUES (?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "sidss", $_POST["plan_name"], $_POST["duration_months"], $_POST["monthly_fee"], $_POST["plan_type"], $_POST["description"]);
    mysqli_stmt_execute($stmt);
    header("Location: plans.php");
    exit();
}

require_once "includes/header.php";
require_once "includes/sidebar.php";
?>

<div class="form-card">
<form method="POST" class="form-grid">
    <div><label>Plan Name</label><input class="input" name="plan_name" required></div>
    <div><label>Duration Months</label><input class="input" type="number" name="duration_months" required></div>
    <div><label>Monthly Fee</label><input class="input" type="number" step="0.01" name="monthly_fee" required></div>
    <div><label>Plan Type</label><select name="plan_type"><option>Basic</option><option>Standard</option><option>Premium</option><option>Student</option><option>Personal Training</option></select></div>
    <div class="form-grid-full"><label>Description</label><textarea name="description" required></textarea></div>
    <div class="form-grid-full actions"><button class="btn">Save Plan</button><a class="btn btn-light" href="plans.php">Cancel</a></div>
</form>
</div>

<?php require_once "includes/footer.php"; ?>
