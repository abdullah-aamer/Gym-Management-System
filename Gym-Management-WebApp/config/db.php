<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "gym_management_system";
$conn = mysqli_connect($host, $username, $password, $database);
if (!$conn) { die("Database connection failed: " . mysqli_connect_error()); }
mysqli_set_charset($conn, "utf8mb4");
function seed_admin($conn) {
    $u = "admin"; $p = "admin123"; $name = "System Administrator"; $email = "admin@gympro.local"; $role = "admin";
    $stmt = mysqli_prepare($conn, "SELECT user_id FROM APP_USER WHERE username=? LIMIT 1");
    mysqli_stmt_bind_param($stmt, "s", $u); mysqli_stmt_execute($stmt); mysqli_stmt_store_result($stmt);
    if (mysqli_stmt_num_rows($stmt) == 0) {
        $hash = password_hash($p, PASSWORD_DEFAULT);
        $ins = mysqli_prepare($conn, "INSERT INTO APP_USER(username, full_name, email, password_hash, role) VALUES(?,?,?,?,?)");
        mysqli_stmt_bind_param($ins, "sssss", $u, $name, $email, $hash, $role); mysqli_stmt_execute($ins);
    }
}
seed_admin($conn);
?>
