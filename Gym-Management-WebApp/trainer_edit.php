<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Edit Trainer";
$id = intval($_GET["id"] ?? 0);

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $stmt = mysqli_prepare($conn, "UPDATE PERSON SET first_name=?, last_name=?, street=?, city=?, email=? WHERE person_id=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $_POST["first_name"], $_POST["last_name"], $_POST["street"], $_POST["city"], $_POST["email"], $id);
    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($conn, "UPDATE TRAINER SET specialization_area=?, experience_years=?, salary=?, trainer_status=? WHERE person_id=?");
    mysqli_stmt_bind_param($stmt, "sidssi", $_POST["specialization_area"], $_POST["experience_years"], $_POST["salary"], $_POST["trainer_status"], $id);
    mysqli_stmt_execute($stmt);

    header("Location: trainers.php");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT p.*, t.* FROM PERSON p JOIN TRAINER t ON p.person_id=t.person_id WHERE p.person_id=?");
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$row = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt));

require_once "includes/header.php";
require_once "includes/sidebar.php";
?>

<div class="form-card">
<form method="POST" class="form-grid">
    <div><label>First Name</label><input class="input" name="first_name" value="<?= safe($row['first_name']) ?>" required></div>
    <div><label>Last Name</label><input class="input" name="last_name" value="<?= safe($row['last_name']) ?>" required></div>
    <div><label>Street</label><input class="input" name="street" value="<?= safe($row['street']) ?>" required></div>
    <div><label>City</label><input class="input" name="city" value="<?= safe($row['city']) ?>" required></div>
    <div><label>Email</label><input class="input" type="email" name="email" value="<?= safe($row['email']) ?>" required></div>
    <div><label>Specialization</label><input class="input" name="specialization_area" value="<?= safe($row['specialization_area']) ?>" required></div>
    <div><label>Experience Years</label><input class="input" type="number" name="experience_years" value="<?= safe($row['experience_years']) ?>" required></div>
    <div><label>Salary</label><input class="input" type="number" step="0.01" name="salary" value="<?= safe($row['salary']) ?>" required></div>
    <div><label>Status</label><select name="trainer_status">
        <?php foreach(["Active","Inactive","On Leave"] as $status): ?>
            <option <?= $row["trainer_status"]==$status ? "selected" : "" ?>><?= $status ?></option>
        <?php endforeach; ?>
    </select></div>
    <div class="form-grid-full actions"><button class="btn">Update Trainer</button><a class="btn btn-light" href="trainers.php">Cancel</a></div>
</form>
</div>

<?php require_once "includes/footer.php"; ?>
