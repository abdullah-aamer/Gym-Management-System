<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_login();

$page_title = "Dashboard";

function count_rows($conn, $table) {
    $result = mysqli_query($conn, "SELECT COUNT(*) AS total FROM $table");
    if (!$result) return 0;
    $row = mysqli_fetch_assoc($result);
    return $row["total"] ?? 0;
}

$total_members = count_rows($conn, "MEMBER");
$total_trainers = count_rows($conn, "TRAINER");
$total_plans = count_rows($conn, "MEMBERSHIP_PLAN");
$total_equipment = count_rows($conn, "EQUIPMENT");

$revenue_result = mysqli_query($conn, "SELECT COALESCE(SUM(amount),0) AS total FROM PAYMENT WHERE payment_status='Paid'");
$revenue = $revenue_result ? (mysqli_fetch_assoc($revenue_result)["total"] ?? 0) : 0;

$plans = mysqli_query($conn, "SELECT plan_name, duration_months, monthly_fee, plan_type FROM MEMBERSHIP_PLAN ORDER BY monthly_fee ASC");

require_once "includes/header.php";
require_once "includes/sidebar.php";
?>

<section class="dashboard-hero">
    <p class="small-label">Database Systems Project - CS160</p>
    <h2>Gym <span>Management</span> System</h2>
    <p>A professional database-driven web application for managing members, trainers, plans, subscriptions, payments, equipment, and SQL reports.</p>
</section>

<div class="stats-grid">
    <div class="stat-card"><div class="stat-icon">👥</div><div><p>Total Members</p><h3><?= safe($total_members) ?></h3></div></div>
    <div class="stat-card"><div class="stat-icon">🏋️</div><div><p>Total Trainers</p><h3><?= safe($total_trainers) ?></h3></div></div>
    <div class="stat-card"><div class="stat-icon">📋</div><div><p>Membership Plans</p><h3><?= safe($total_plans) ?></h3></div></div>
    <div class="stat-card"><div class="stat-icon">💳</div><div><p>Total Revenue</p><h3>PKR <?= number_format($revenue) ?></h3></div></div>
    <div class="stat-card"><div class="stat-icon">⚙️</div><div><p>Equipment Items</p><h3><?= safe($total_equipment) ?></h3></div></div>
</div>

<h2 class="section-title">Available Membership Plans</h2>

<div class="table-wrap">
<table>
<tr>
    <th>Plan Name</th>
    <th>Duration</th>
    <th>Monthly Fee</th>
    <th>Plan Type</th>
</tr>
<?php if ($plans): while($plan = mysqli_fetch_assoc($plans)): ?>
<tr>
    <td><?= safe($plan["plan_name"]) ?></td>
    <td><?= safe($plan["duration_months"]) ?> Month(s)</td>
    <td>PKR <?= number_format($plan["monthly_fee"]) ?></td>
    <td><span class="badge"><?= safe($plan["plan_type"]) ?></span></td>
</tr>
<?php endwhile; endif; ?>
</table>
</div>

<?php if (is_admin()): ?>
<h2 class="section-title">Admin Quick Actions</h2>
<div class="action-grid">
    <a class="action-card" href="members.php"><h3>Manage Members</h3><p>View member records from the database.</p></a>
    <a class="action-card" href="trainers.php"><h3>Manage Trainers</h3><p>View trainers and specialization details.</p></a>
    <a class="action-card" href="plans.php"><h3>Membership Plans</h3><p>View all available gym membership plans.</p></a>
    <a class="action-card" href="payments.php"><h3>Payments</h3><p>View payment records and revenue data.</p></a>
    <a class="action-card" href="equipment.php"><h3>Equipment</h3><p>View gym equipment and condition status.</p></a>
    <a class="action-card" href="reports.php"><h3>Reports / Views</h3><p>View SQL database views and report outputs.</p></a>
</div>
<?php else: ?>
<div class="user-panel">
    <h2>User Panel</h2>
    <p>Welcome to the Gym Management System. This is a normal user account.</p>
</div>
<?php endif; ?>

<?php require_once "includes/footer.php"; ?>
