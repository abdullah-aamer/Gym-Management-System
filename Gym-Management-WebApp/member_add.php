<?php
require_once "config/db.php";
require_once "includes/auth.php";
require_admin();

$page_title = "Add Member";
$error = "";

if($_SERVER["REQUEST_METHOD"] === "POST"){
    $first_name = trim($_POST["first_name"]);
    $last_name = trim($_POST["last_name"]);
    $date_of_birth = $_POST["date_of_birth"];
    $gender = $_POST["gender"];
    $street = trim($_POST["street"]);
    $city = trim($_POST["city"]);
    $email = trim($_POST["email"]);
    $phone = trim($_POST["phone"]);
    $joining_date = $_POST["joining_date"];
    $health_goal = $_POST["health_goal"];
    $emergency_contact = trim($_POST["emergency_contact"]);
    $member_status = $_POST["member_status"];

    mysqli_begin_transaction($conn);

    try{
        $stmt = mysqli_prepare($conn, "INSERT INTO PERSON (first_name, last_name, date_of_birth, gender, street, city, email) VALUES (?, ?, ?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "sssssss", $first_name, $last_name, $date_of_birth, $gender, $street, $city, $email);
        mysqli_stmt_execute($stmt);

        $person_id = mysqli_insert_id($conn);

        $stmt = mysqli_prepare($conn, "INSERT INTO MEMBER (person_id, joining_date, health_goal, emergency_contact, member_status) VALUES (?, ?, ?, ?, ?)");
        mysqli_stmt_bind_param($stmt, "issss", $person_id, $joining_date, $health_goal, $emergency_contact, $member_status);
        mysqli_stmt_execute($stmt);

        if($phone !== ""){
            $stmt = mysqli_prepare($conn, "INSERT INTO PERSON_PHONE (person_id, phone_number) VALUES (?, ?)");
            mysqli_stmt_bind_param($stmt, "is", $person_id, $phone);
            mysqli_stmt_execute($stmt);
        }

        mysqli_commit($conn);
        header("Location: members.php");
        exit();
    }catch(Exception $e){
        mysqli_rollback($conn);
        $error = "Member could not be added. Please check email/phone uniqueness and required fields.";
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
    <div><label>Phone</label><input class="input" name="phone"></div>
    <div><label>Joining Date</label><input class="input" type="date" name="joining_date" required></div>
    <div><label>Health Goal</label><select name="health_goal"><option>Weight Loss</option><option>Muscle Gain</option><option>Fitness</option><option>Strength Training</option><option>Endurance</option></select></div>
    <div><label>Emergency Contact</label><input class="input" name="emergency_contact" required></div>
    <div><label>Status</label><select name="member_status"><option>Active</option><option>Inactive</option><option>Suspended</option></select></div>
    <div class="form-grid-full actions"><button class="btn">Save Member</button><a class="btn btn-light" href="members.php">Cancel</a></div>
</form>
</div>

<?php require_once "includes/footer.php"; ?>
