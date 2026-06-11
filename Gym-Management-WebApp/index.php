<?php
session_start();

if(isset($_SESSION['user_id'])){
    header("Location: dashboard.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Gym Management System</title>
<link rel="stylesheet" href="assets/css/front.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body>

<div class="overlay"></div>

<nav class="navbar">
    <div class="nav-logo">
        <img src="assets/images/nutech-logo.png" alt="NUTECH Logo">
        <span>GymPro</span>
    </div>

    <ul>
        <li><a href="#home">Home</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#team">Team</a></li>
        <li><a href="login.php?role=admin">Admin</a></li>
    </ul>
</nav>

<section class="container" id="home">

    <img src="assets/images/nutech-logo.png" class="nutech-logo" alt="NUTECH Logo">

    <p class="project-label">Database Systems Project - CS160</p>

    <h1>Gym <span>Management</span> System</h1>

    <p class="university">
        National University of Technology (NUTECH)
    </p>

    <p class="tagline">
        Manage memberships, trainers, payments, and attendance smartly.
    </p>

    <div class="cards">

        <a href="login.php?role=admin" class="card">
            <div class="icon"><i class="fas fa-user-shield"></i></div>
            <h2>Admin Login</h2>
            <p>Access admin dashboard and manage the complete gym system.</p>
            <button>Admin Login →</button>
        </a>

        <a href="login.php?role=user" class="card">
            <div class="icon"><i class="fas fa-user"></i></div>
            <h2>User Login</h2>
            <p>Login to your user account and view system features.</p>
            <button>User Login →</button>
        </a>

        <a href="signup.php" class="card">
            <div class="icon"><i class="fas fa-user-plus"></i></div>
            <h2>User Sign Up</h2>
            <p>Create a new account and join the fitness management system.</p>
            <button>Sign Up →</button>
        </a>

    </div>

    <div class="features" id="features">

        <div class="feature">
            <i class="fas fa-dumbbell"></i>
            <h3>Manage Workouts</h3>
            <p>Custom workout plans</p>
        </div>

        <div class="feature">
            <i class="fas fa-users"></i>
            <h3>Expert Trainers</h3>
            <p>Professional guidance</p>
        </div>

        <div class="feature">
            <i class="fas fa-credit-card"></i>
            <h3>Secure Payments</h3>
            <p>Payment records</p>
        </div>

        <div class="feature">
            <i class="fas fa-calendar-check"></i>
            <h3>Track Attendance</h3>
            <p>Daily attendance</p>
        </div>

    </div>

    <div class="team-section" id="team">
        <h2>Project Team Members</h2>

        <div class="team-grid">
            <div>Muhammad Abdullah Bin Aamer</div>
            <div>Muhammad Kabeer Atif</div>
            <div>Talha Akhter</div>
            <div>Haseeb Ullah</div>
            <div>Hameed Ullah</div>
        </div>

        <p class="supervision">
            Under the Supervision of <strong>Ms. Saima Yasmeen</strong>
        </p>
    </div>

    <footer>
        Developed by Gym Management System Project Team | BS Computer Science - NUTECH
    </footer>

</section>

</body>
</html>