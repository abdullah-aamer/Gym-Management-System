<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Payments";
require_once "includes/header.php";
require_once "includes/sidebar.php";

$result = mysqli_query($conn, "SELECT pay.subscription_id, pay.payment_no, CONCAT(p.first_name, ' ', p.last_name) AS member_name, pay.amount, pay.payment_date, pay.payment_method, pay.payment_status FROM PAYMENT pay JOIN SUBSCRIPTION s ON pay.subscription_id=s.subscription_id JOIN MEMBER m ON s.member_id=m.person_id JOIN PERSON p ON m.person_id=p.person_id ORDER BY pay.payment_date DESC");
?>

<div class="page-actions"><a class="btn" href="payment_add.php">+ Add Payment</a></div>
<div class="table-wrap"><table>
<tr><th>Subscription</th><th>Payment No</th><th>Member</th><th>Amount</th><th>Date</th><th>Method</th><th>Status</th><th>Actions</th></tr>
<?php while($row=mysqli_fetch_assoc($result)): ?>
<tr>
<td><?= safe($row["subscription_id"]) ?></td><td><?= safe($row["payment_no"]) ?></td><td><?= safe($row["member_name"]) ?></td><td>PKR <?= number_format($row["amount"]) ?></td><td><?= safe($row["payment_date"]) ?></td><td><?= safe($row["payment_method"]) ?></td><td><span class="badge"><?= safe($row["payment_status"]) ?></span></td>
<td><a class="btn btn-danger" href="payment_delete.php?sid=<?= $row["subscription_id"] ?>&pno=<?= $row["payment_no"] ?>" onclick="return confirm('Delete payment?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table></div>
<?php require_once "includes/footer.php"; ?>
