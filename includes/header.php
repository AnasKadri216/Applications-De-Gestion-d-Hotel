<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$current_page = basename($_SERVER['PHP_SELF']);
if ($current_page !== 'index.php' && !isset($_SESSION['username'])) {
    header('Location: index.php');
    exit();
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <title>Gestion Hôtel</title>
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<header>
    <h1>Bienvenue, <?= isset($_SESSION['username']) ? $_SESSION['username'] : 'Invité' ?></h1>
    <nav>
        <a href="dashboard.php">Dashboard</a> |
        <a href="rooms.php">Chambres</a> |
        <a href="clients.php">Clients</a> |
        <a href="reservations.php">Réservations</a> |
        <a href="logout.php">Déconnexion</a>
    </nav>
    <hr>
</header>
