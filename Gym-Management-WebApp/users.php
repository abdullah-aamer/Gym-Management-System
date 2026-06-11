<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Registered Users";

require_once "includes/header.php";
require_once "includes/sidebar.php";

$result = mysqli_query($conn, "SELECT user_id, username, full_name, email, role, created_at FROM APP_USER ORDER BY user_id DESC");
?>

<div class="table-wrap">
<table>
<tr>
    <th>User ID</th>
    <th>Username</th>
    <th>Full Name</th>
    <th>Email</th>
    <th>Role</th>
    <th>Created At</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= safe($row["user_id"]) ?></td>
    <td><?= safe($row["username"]) ?></td>
    <td><?= safe($row["full_name"]) ?></td>
    <td><?= safe($row["email"]) ?></td>
    <td><span class="badge"><?= safe($row["role"]) ?></span></td>
    <td><?= safe($row["created_at"]) ?></td>
</tr>
<?php endwhile; ?>

</table>
</div>

<?php require_once "includes/footer.php"; ?>