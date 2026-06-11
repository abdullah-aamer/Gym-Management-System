<?php
require_once __DIR__ . "/auth.php";
$base_url = "/Gym-Management-WebApp";
?>

<div class="layout">

<aside class="sidebar">

    <div class="brand">
        <img src="<?= $base_url ?>/assets/images/nutech-logo.png" class="side-logo" alt="NUTECH Logo">
        <div>
            <h2>GymPro</h2>
            <p>Database Systems PBL</p>
        </div>
    </div>

    <nav class="side-nav">
        <a href="<?= $base_url ?>/dashboard.php">Dashboard</a>

        <?php if (is_admin()): ?>
            <a href="<?= $base_url ?>/members.php">Members</a>
            <a href="<?= $base_url ?>/trainers.php">Trainers</a>
            <a href="<?= $base_url ?>/plans.php">Membership Plans</a>
            <a href="<?= $base_url ?>/subscriptions.php">Subscriptions</a>
            <a href="<?= $base_url ?>/payments.php">Payments</a>
            <a href="<?= $base_url ?>/equipment.php">Equipment</a>
            <a href="<?= $base_url ?>/reports.php">Reports / Views</a>
        <?php endif; ?>

        <a href="<?= $base_url ?>/about.php">About Project</a>
        <a href="<?= $base_url ?>/logout.php" class="logout">Logout</a>
    </nav>

</aside>

<main class="main">

<div class="topbar">
    <div>
        <h1><?= safe($page_title) ?></h1>
        <p><?= safe($_SESSION["full_name"] ?? "Guest") ?> · <?= safe(ucfirst($_SESSION["role"] ?? "")) ?></p>
    </div>
</div>
