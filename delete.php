<?php
session_start();
if (!isset($_SESSION['medewerker'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM bestellingen WHERE id = ?');
    $stmt->execute([$id]);
}

header('Location: medewerker.php');
exit;
?>
