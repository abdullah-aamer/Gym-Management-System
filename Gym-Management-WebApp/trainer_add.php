<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Add Trainer";
$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    mysqli_begin_transaction($conn);
    try{
        $stmt = mysqli_prepare($conn, "INSERT INTO PERSON (first_name, last_name, date_of_birth, gender, street, city, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssss", $_POST["first_name"], $_POST["last_name"], $_POST["date_of_birth"], $_POST["gender"], $_POST["street"], $_POST["city"], $_POST["email"]);
        mysqli_stmt_execute($stmt);
        $person_id = mysqli_insert_id($conn);

        $stmt = mysqli_prepare($conn, "INSERT INTO TRAINER (person_id, specialization_area, experience_years, salary, trainer_status) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "isids", $person_id, $_POST["specialization_area"], $_POST["experience_years"], $_POST["salary"], $_POST["trainer_status"]);
        mysqli_stmt_execute($stmt);

        mysqli_commit($conn);
        header("Location: trainers.php");
        exit();
    }catch(Exception $e){
        mysqli_rollback($conn);
        $error = "Trainer could not be added.";
    }
}

require_once "includes/header.php";
require_once "includes/sidebar.php";
?>

<div class="form-card">
<?php if($error): ?><div class="alert alert-error"><?= safe($error) ?></div><?php endif; ?>
<form method="POST" class="form-grid">
    <div><label>First Name</label><input class="input" name="first_name" required></div>
    <div><label>Last Name</label><input class="input" name="last_name" required></div>
    <div><label>Date of Birth</label><input class="input" type="date" name="date_of_birth" required></div>
    <div><label>Gender</label><select name="gender"><option>Male</option><option>Female</option><option>Other</option></select></div>
    <div><label>Street</label><input class="input" name="street" required></div>
    <div><label>City</label><input class="input" name="city" required></div>
    <div><label>Email</label><input class="input" type="email" name="email" required></div>
    <div><label>Specialization</label><input class="input" name="specialization_area" required></div>
    <div><label>Experience Years</label><input class="input" type="number" name="experience_years" required></div>
    <div><label>Salary</label><input class="input" type="number" step="0.01" name="salary" required></div>
    <div><label>Status</label><select name="trainer_status"><option>Active</option><option>Inactive</option><option>On Leave</option></select></div>
    <div class="form-grid-full actions"><button class="btn">Save Trainer</button><a class="btn btn-light" href="trainers.php">Cancel</a></div>
</form>
</div>

<?php require_once "includes/footer.php"; ?>
