<?php
session_start();
if (!isset($_SESSION['medewerker'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare('UPDATE bestellingen SET status = ? WHERE id = ?');
    $stmt->execute(['Opgehaald', $id]);
}

header('Location: medewerker.php');
exit;
?>
