<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Add Subscription";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $stmt = mysqli_prepare($conn, "INSERT INTO SUBSCRIPTION (member_id, plan_id, start_date, end_date, subscription_status, discount_percent) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iisssd", $_POST["member_id"], $_POST["plan_id"], $_POST["start_date"], $_POST["end_date"], $_POST["subscription_status"], $_POST["discount_percent"]);
    mysqli_stmt_execute($stmt);
    header("Location: subscriptions.php");
    exit();
}

$members = mysqli_query($conn, "SELECT m.person_id, CONCAT(p.first_name, ' ', p.last_name) AS name FROM MEMBER m JOIN PERSON p ON m.person_id=p.person_id ORDER BY name");
$plans = mysqli_query($conn, "SELECT plan_id, plan_name FROM MEMBERSHIP_PLAN ORDER BY plan_name");

require_once "includes/header.php";
require_once "includes/sidebar.php";
?>

<div class="form-card">
<form method="POST" class="form-grid">
    <div><label>Member</label><select name="member_id"><?php while($m=mysqli_fetch_assoc($members)): ?><option value="<?= $m["person_id"] ?>"><?= safe($m["name"]) ?></option><?php endwhile; ?></select></div>
    <div><label>Plan</label><select name="plan_id"><?php while($p=mysqli_fetch_assoc($plans)): ?><option value="<?= $p["plan_id"] ?>"><?= safe($p["plan_name"]) ?></option><?php endwhile; ?></select></div>
    <div><label>Start Date</label><input class="input" type="date" name="start_date" required></div>
    <div><label>End Date</label><input class="input" type="date" name="end_date" required></div>
    <div><label>Status</label><select name="subscription_status"><option>Pending</option><option>Active</option><option>Expired</option><option>Cancelled</option></select></div>
    <div><label>Discount Percent</label><input class="input" type="number" step="0.01" name="discount_percent" value="0"></div>
    <div class="form-grid-full actions"><button class="btn">Save Subscription</button><a class="btn btn-light" href="subscriptions.php">Cancel</a></div>
</form>
</div>

<?php require_once "includes/footer.php"; ?>
