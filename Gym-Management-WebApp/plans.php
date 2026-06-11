<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Membership Plans";
require_once "includes/header.php";
require_once "includes/sidebar.php";

$result = mysqli_query($conn, "SELECT * FROM MEMBERSHIP_PLAN ORDER BY monthly_fee ASC LIMIT 4");
?>

<div class="page-actions">
    <a class="btn" href="plan_add.php">+ Add Membership Plan</a>
</div>

<div class="plan-grid">
<?php while($plan = mysqli_fetch_assoc($result)): ?>
    <div class="plan-card">
        <div class="plan-type"><?= safe($plan["plan_type"]) ?></div>
        <h2><?= safe($plan["plan_name"]) ?></h2>
        <h3>PKR <?= number_format($plan["monthly_fee"]) ?></h3>
        <p><?= safe($plan["duration_months"]) ?> Month(s) Membership</p>
        <p><?= safe($plan["description"]) ?></p>
        <div class="actions">
            <a class="btn btn-light" href="plan_edit.php?id=<?= $plan["plan_id"] ?>">Edit</a>
            <a class="btn btn-danger" href="plan_delete.php?id=<?= $plan["plan_id"] ?>" onclick="return confirm('Delete this plan?')">Delete</a>
        </div>
    </div>
<?php endwhile; ?>
</div>

<?php require_once "includes/footer.php"; ?>
