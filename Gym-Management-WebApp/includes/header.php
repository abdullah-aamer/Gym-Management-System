<?php
require_once __DIR__ . '/auth.php';

$page_title = $page_title ?? 'Gym Management System';
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title><?= safe($page_title) ?></title>

    <link rel="stylesheet" href="/Gym-Management-WebApp/assets/css/style.css">
    <link rel="stylesheet" href="/Gym-Management-WebApp/assets/css/crud_extra.css">
    <link rel="stylesheet" href="/Gym-Management-WebApp/assets/css/about_extra.css">

    <link rel="icon" href="/Gym-Management-WebApp/assets/images/nutech-logo.png">

</head>

<body>
