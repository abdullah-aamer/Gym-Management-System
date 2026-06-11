<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Equipment Management";
require_once "includes/header.php";
require_once "includes/sidebar.php";

$result = mysqli_query($conn, "SELECT * FROM EQUIPMENT ORDER BY equipment_id DESC");
?>

<div class="page-actions"><a class="btn" href="equipment_add.php">+ Add Equipment</a></div>
<div class="table-wrap"><table>
<tr><th>ID</th><th>Name</th><th>Category</th><th>Quantity</th><th>Condition</th><th>Last Maintenance</th><th>Actions</th></tr>
<?php while($row=mysqli_fetch_assoc($result)): ?>
<tr>
<td><?= safe($row["equipment_id"]) ?></td><td><?= safe($row["equipment_name"]) ?></td><td><?= safe($row["category"]) ?></td><td><?= safe($row["quantity_available"]) ?></td><td><span class="badge"><?= safe($row["condition_status"]) ?></span></td><td><?= safe($row["last_maintenance_date"]) ?></td>
<td class="actions"><a class="btn btn-light" href="equipment_edit.php?id=<?= $row["equipment_id"] ?>">Edit</a><a class="btn btn-danger" href="equipment_delete.php?id=<?= $row["equipment_id"] ?>" onclick="return confirm('Delete this equipment?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table></div>
<?php require_once "includes/footer.php"; ?>
