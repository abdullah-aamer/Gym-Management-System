<?php
if (session_status() === PHP_SESSION_NONE) session_start();
function safe($v){ return htmlspecialchars($v ?? '', ENT_QUOTES, 'UTF-8'); }
function logged_in(){ return isset($_SESSION['user_id']); }
function is_admin(){ return isset($_SESSION['role']) && $_SESSION['role']==='admin'; }
function require_login(){ if(!logged_in()){ header('Location: /Gym-Management-WebApp/index.php'); exit(); } }
function require_admin(){ require_login(); if(!is_admin()){ header('Location: /Gym-Management-WebApp/dashboard.php'); exit(); } }
?>
