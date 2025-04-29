<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $aantal = intval($_POST['aantal']);
    if ($aantal < 1 || $aantal > 10) {
        header('Location: index.php?error=1');
        exit;
    }

    $stmt = $pdo->prepare('INSERT INTO bestellingen (klant_naam, aantal, dag, tijd) VALUES (?, ?, ?, ?)');
    $stmt->execute([
        $_POST['klant_naam'],
        $aantal,
        $_POST['dag'],
        $_POST['tijd']
    ]);

    $bestelnummer = $pdo->lastInsertId();

    // Stuur klant door naar bedankpagina met bestelnummer en aantal
    header('Location: bedankt.php?bestelnummer=' . $bestelnummer . '&aantal=' . $aantal);
    exit;
}
?>
