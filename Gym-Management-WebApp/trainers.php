<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Trainers Management";
require_once "includes/header.php";
require_once "includes/sidebar.php";

$result = mysqli_query($conn, "SELECT t.person_id, CONCAT(p.first_name, ' ', p.last_name) AS trainer_name, p.email, t.specialization_area, t.experience_years, t.salary, t.trainer_status FROM TRAINER t JOIN PERSON p ON t.person_id=p.person_id ORDER BY t.person_id DESC");
?>

<div class="page-actions"><a class="btn" href="trainer_add.php">+ Add Trainer</a></div>

<div class="table-wrap">
<table>
<tr><th>ID</th><th>Trainer</th><th>Email</th><th>Specialization</th><th>Experience</th><th>Salary</th><th>Status</th><th>Actions</th></tr>
<?php while($row=mysqli_fetch_assoc($result)): ?>
<tr>
<td><?= safe($row["person_id"]) ?></td>
<td><?= safe($row["trainer_name"]) ?></td>
<td><?= safe($row["email"]) ?></td>
<td><?= safe($row["specialization_area"]) ?></td>
<td><?= safe($row["experience_years"]) ?> years</td>
<td>PKR <?= number_format($row["salary"]) ?></td>
<td><span class="badge"><?= safe($row["trainer_status"]) ?></span></td>
<td class="actions"><a class="btn btn-light" href="trainer_edit.php?id=<?= $row["person_id"] ?>">Edit</a><a class="btn btn-danger" href="trainer_delete.php?id=<?= $row["person_id"] ?>" onclick="return confirm('Delete this trainer?')">Delete</a></td>
</tr>
<?php endwhile; ?>
</table>
</div>

<?php require_once "includes/footer.php"; ?>
