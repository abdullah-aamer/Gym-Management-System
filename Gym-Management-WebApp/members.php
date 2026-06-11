<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Members Management";
require_once "includes/header.php";
require_once "includes/sidebar.php";

$query = "SELECT m.person_id, CONCAT(p.first_name, ' ', p.last_name) AS member_name, p.email, p.city, m.health_goal, m.joining_date, m.member_status
          FROM MEMBER m
          JOIN PERSON p ON m.person_id = p.person_id
          ORDER BY m.person_id DESC";
$result = mysqli_query($conn, $query);
?>

<div class="page-actions">
    <a class="btn" href="member_add.php">+ Add New Member</a>
</div>

<div class="table-wrap">
<table>
<tr>
    <th>ID</th>
    <th>Member Name</th>
    <th>Email</th>
    <th>City</th>
    <th>Health Goal</th>
    <th>Joining Date</th>
    <th>Status</th>
    <th>Actions</th>
</tr>

<?php while($row = mysqli_fetch_assoc($result)): ?>
<tr>
    <td><?= safe($row["person_id"]) ?></td>
    <td><?= safe($row["member_name"]) ?></td>
    <td><?= safe($row["email"]) ?></td>
    <td><?= safe($row["city"]) ?></td>
    <td><?= safe($row["health_goal"]) ?></td>
    <td><?= safe($row["joining_date"]) ?></td>
    <td><span class="badge"><?= safe($row["member_status"]) ?></span></td>
    <td class="actions">
        <a class="btn btn-light" href="member_edit.php?id=<?= $row["person_id"] ?>">Edit</a>
        <a class="btn btn-danger" href="member_delete.php?id=<?= $row["person_id"] ?>" onclick="return confirm('Delete this member? This will remove related records too.')">Delete</a>
    </td>
</tr>
<?php endwhile; ?>

</table>
</div>

<?php require_once "includes/footer.php"; ?>
