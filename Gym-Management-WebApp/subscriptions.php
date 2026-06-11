<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Subscriptions";
require_once "includes/header.php";
require_once "includes/sidebar.php";

$result = mysqli_query($conn, "SELECT s.subscription_id, CONCAT(p.first_name, ' ', p.last_name) AS member_name, mp.plan_name, s.start_date, s.end_date, s.subscription_status, s.discount_percent FROM SUBSCRIPTION s JOIN MEMBER m ON s.member_id=m.person_id JOIN PERSON p ON m.person_id=p.person_id JOIN MEMBERSHIP_PLAN mp ON s.plan_id=mp.plan_id ORDER BY s.subscription_id DESC");
?>

<div class="page-actions"><a class="btn" href="subscription_add.php">+ Add Subscription</a></div>
<div class="table-wrap"><table>
<tr><th>ID</th><th>Member</th><th>Plan</th><th>Start</th><th>End</th><th>Status</th><th>Discount</th><th>Actions</th></tr>
<?php while($row=mysqli_fetch_assoc($result)): ?>
<tr>
<td><?= safe($row["subscription_id"]) ?></td><td><?= safe($row["member_name"]) ?></td><td><?= safe($row["plan_name"]) ?></td><td><?= safe($row["start_date"]) ?></td><td><?= safe($row["end_date"]) ?></td><td><span class="badge"><?= safe($row["subscription_status"]) ?></span></td><td><?= safe($row["discount_percent"]) ?>%</td>
<td class="actions"><a class="btn btn-danger" href="subscription_delete.php?id=<?= $row["subscription_id"] ?>" onclick="return confirm('Delete this subscription?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table></div>
<?php require_once "includes/footer.php"; ?>
