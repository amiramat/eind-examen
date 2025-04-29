<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $wachtwoord = $_POST['wachtwoord'];

    $stmt = $pdo->prepare("SELECT * FROM medewerkers WHERE gebruikersnaam = ?");
    $stmt->execute([$gebruikersnaam]);

    if ($stmt->rowCount() > 0) {
        $error = "Gebruikersnaam bestaat al.";
    } else {
        $hashed = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $insert = $pdo->prepare("INSERT INTO medewerkers (gebruikersnaam, wachtwoord) VALUES (?, ?)");
        $insert->execute([$gebruikersnaam, $hashed]);
        $success = "Account aangemaakt. U kunt nu inloggen.";
        header("refresh:2;url=login.php");
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Registreren - Medewerker</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<header class="navbar">
    <div class="nav-container">
        <div class="nav-left">
            <a href="index.php" class="logo-link">
                <h1>🍫 De Bonte Koe</h1>
            </a>
        </div>
        <div class="nav-right">
            <div class="dropdown">
                <button class="dropbtn">Menu ▾</button>
                <div class="dropdown-content">
                    <a href="index.php">Home</a>
                    <?php
                    session_start();
                    $pagina = basename($_SERVER['PHP_SELF']);

                    if ($pagina == "index.php") {
                        echo '<a href="login.php">Login</a>';
                    } else {
                        if (isset($_SESSION['medewerker'])) {
                            echo '<a href="dashboard.php">Dashboard</a>';
                            echo '<a href="logout.php">Uitloggen</a>';
                        } else {
                            echo '<a href="login.php">Login</a>';
                        }
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</header>



<main class="container">
    <section class="form-section">
        <h2>Registreren als Medewerker</h2>
        <?php if (!empty($error)) echo "<p class='alert-error'>$error</p>"; ?>
        <?php if (!empty($success)) echo "<p class='alert-success'>$success</p>"; ?>
        <form method="post">
            <label>Gebruikersnaam:
                <input type="text" name="gebruikersnaam" required>
            </label>
            <label>Wachtwoord:
                <input type="password" name="wachtwoord" required>
            </label>
            <button type="submit">Account aanmaken</button>
        </form>
        <p><a href="index.php" class="teruglink">← Terug naar startpagina</a></p>
    </section>
</main>

<footer class="footer">
    <p>Hoogstraat 78 | Instagram & TikTok: <strong>@DeBonteKoe</strong></p>
</footer>

</body>
</html>
