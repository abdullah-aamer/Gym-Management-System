<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$sid = intval($_GET["sid"] ?? 0);
$pno = intval($_GET["pno"] ?? 0);
$stmt = mysqli_prepare($conn, "DELETE FROM PAYMENT WHERE subscription_id=? AND payment_no=?");
mysqli_stmt_bind_param($stmt, "ii", $sid, $pno);
mysqli_stmt_execute($stmt);

header("Location: payments.php");
exit();
?>
