<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$id = intval($_GET["id"] ?? 0);
$stmt = mysqli_prepare($conn, "DELETE FROM SUBSCRIPTION WHERE subscription_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);

header("Location: subscriptions.php");
exit();
?>
