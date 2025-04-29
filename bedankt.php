<?php
session_start();

$bestelnummer = $_GET['bestelnummer'] ?? 'Onbekend';
$aantal = intval($_GET['aantal'] ?? 0);
$prijsPerStuk = 12.95;
$totaal = number_format($aantal * $prijsPerStuk, 2, ',', '.');
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Bedankt voor uw bestelling - De Bonte Koe</title>
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
    <section class="form-section" style="text-align:center;">
        <h2>Bedankt voor uw bestelling!</h2>
        <p>
            Uw bestelling is succesvol ontvangen.<br><br>
            <strong>Bestelnummer:</strong> <?= htmlspecialchars($bestelnummer); ?><br>
            <strong>Aantal:</strong> <?= htmlspecialchars($aantal); ?> aardbeien<br>
            <strong>Te betalen in de winkel:</strong> €<?= $totaal; ?><br><br>
            U kunt dit bestelnummer tonen in de winkel aan de Hoogstraat 78.
        </p>

        <a href="index.php" class="btn-terug">Terug naar Home</a>
    </section>
</main>

<footer class="footer">
    <p>Hoogstraat 78 | Instagram & TikTok: <strong>@DeBonteKoe</strong></p>
</footer>

</body>
</html>
