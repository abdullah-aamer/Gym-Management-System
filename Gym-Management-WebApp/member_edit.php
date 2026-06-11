<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Edit Member";
$id = intval($_GET["id"] ?? 0);

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $stmt = mysqli_prepare($conn, "UPDATE PERSON SET first_name=?, last_name=?, street=?, city=?, email=? WHERE person_id=?");
    mysqli_stmt_bind_param($stmt, "sssssi", $_POST["first_name"], $_POST["last_name"], $_POST["street"], $_POST["city"], $_POST["email"], $id);
    mysqli_stmt_execute($stmt);

    $stmt = mysqli_prepare($conn, "UPDATE MEMBER SET health_goal=?, emergency_contact=?, member_status=? WHERE person_id=?");
    mysqli_stmt_bind_param($stmt, "sssi", $_POST["health_goal"], $_POST["emergency_contact"], $_POST["member_status"], $id);
    mysqli_stmt_execute($stmt);

    header("Location: members.php");
    exit();
}

$stmt = mysqli_prepare($conn, "SELECT p.*, m.* FROM PERSON p JOIN MEMBER m ON p.person_id=m.person_id WHERE p.person_id=?");
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
    <div><label>Health Goal</label><select name="health_goal">
        <?php foreach(["Weight Loss","Muscle Gain","Fitness","Strength Training","Endurance"] as $goal): ?>
            <option <?= $row["health_goal"]==$goal ? "selected" : "" ?>><?= $goal ?></option>
        <?php endforeach; ?>
    </select></div>
    <div><label>Emergency Contact</label><input class="input" name="emergency_contact" value="<?= safe($row['emergency_contact']) ?>" required></div>
    <div><label>Status</label><select name="member_status">
        <?php foreach(["Active","Inactive","Suspended"] as $status): ?>
            <option <?= $row["member_status"]==$status ? "selected" : "" ?>><?= $status ?></option>
        <?php endforeach; ?>
    </select></div>
    <div class="form-grid-full actions"><button class="btn">Update Member</button><a class="btn btn-light" href="members.php">Cancel</a></div>
</form>
</div>

<?php require_once "includes/footer.php"; ?>
