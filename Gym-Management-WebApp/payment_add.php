<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Add Payment";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $stmt = mysqli_prepare($conn, "INSERT INTO PAYMENT (subscription_id, payment_no, amount, payment_date, payment_method, payment_status) VALUES (?, ?, ?, ?, ?, ?)");
    mysqli_stmt_bind_param($stmt, "iidsss", $_POST["subscription_id"], $_POST["payment_no"], $_POST["amount"], $_POST["payment_date"], $_POST["payment_method"], $_POST["payment_status"]);
    mysqli_stmt_execute($stmt);
    header("Location: payments.php");
    exit();
}

$subs = mysqli_query($conn, "SELECT s.subscription_id, CONCAT(p.first_name, ' ', p.last_name, ' - ', mp.plan_name) AS title FROM SUBSCRIPTION s JOIN MEMBER m ON s.member_id=m.person_id JOIN PERSON p ON m.person_id=p.person_id JOIN MEMBERSHIP_PLAN mp ON s.plan_id=mp.plan_id ORDER BY s.subscription_id DESC");

require_once "includes/header.php";
require_once "includes/sidebar.php";
?>

<div class="form-card">
<form method="POST" class="form-grid">
    <div><label>Subscription</label><select name="subscription_id"><?php while($s=mysqli_fetch_assoc($subs)): ?><option value="<?= $s["subscription_id"] ?>"><?= safe($s["title"]) ?></option><?php endwhile; ?></select></div>
    <div><label>Payment No</label><input class="input" type="number" name="payment_no" value="1" required></div>
    <div><label>Amount</label><input class="input" type="number" step="0.01" name="amount" required></div>
    <div><label>Payment Date</label><input class="input" type="date" name="payment_date" required></div>
    <div><label>Payment Method</label><select name="payment_method"><option>Cash</option><option>Card</option><option>JazzCash</option><option>EasyPaisa</option><option>Bank Transfer</option></select></div>
    <div><label>Payment Status</label><select name="payment_status"><option>Paid</option><option>Pending</option><option>Failed</option><option>Refunded</option></select></div>
    <div class="form-grid-full actions"><button class="btn">Save Payment</button><a class="btn btn-light" href="payments.php">Cancel</a></div>
</form>
</div>

<?php require_once "includes/footer.php"; ?>
