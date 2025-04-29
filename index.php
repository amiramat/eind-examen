
<?php
session_start();
include 'db.php';

$bevestiging = false;
$foutmelding = false;

if (isset($_GET['success']) && $_GET['success'] == '1') {
    $bevestiging = true;
}

if (isset($_GET['error']) && $_GET['error'] == '1') {
    $foutmelding = true;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>De Bonte Koe - Bestellen</title>
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

    <section class="intro-section">
        <h2>Welkom bij De Bonte Koe!</h2>
        <p>Bestel hier uw heerlijke chocolade-aardbeien.<br>
            Ophalen kan op vrijdag, zaterdag of zondag tussen 12:00 en 17:00.</p>
    </section>

    <?php if ($bevestiging): ?>
        <div class="alert-success">
            Uw bestelling is succesvol geplaatst! U kunt afrekenen in onze winkel aan de Hoogstraat 78. Bedankt!
        </div>
    <?php endif; ?>

    <?php if ($foutmelding): ?>
        <div class="alert-error">
            U kunt maximaal 10 aardbeien per bestelling bestellen. Probeer opnieuw.
        </div>
    <?php endif; ?>

    <section class="form-section">
        <h2>Plaats uw bestelling</h2>
        <form action="create.php" method="post">
            <div class="form-grid">
                <label>Naam:
                    <input type="text" name="klant_naam" placeholder="Uw naam" required>
                </label>
                <label>Aantal aardbeien:
                    <input type="number" name="aantal" min="1" max="10" placeholder="Maximaal 10" required>
                </label>
                <label>Dag ophalen:
                    <select name="dag" required>
                        <option value="">Kies een dag</option>
                        <option value="Vrijdag">Vrijdag</option>
                        <option value="Zaterdag">Zaterdag</option>
                        <option value="Zondag">Zondag</option>
                    </select>
                </label>
                <label>Tijd ophalen:
                    <select name="tijd" required>
                        <option value="">Kies een tijd</option>
                        <option value="12:00">12:00</option>
                        <option value="13:00">13:00</option>
                        <option value="14:00">14:00</option>
                        <option value="15:00">15:00</option>
                        <option value="16:00">16:00</option>
                        <option value="17:00">17:00</option>
                    </select>
                </label>
            </div>

            <div class="form-button">
                <button type="submit">Bestellen</button>
            </div>
        </form>
    </section>

</main>

<footer class="footer">
    <p>Hoogstraat 78 | Instagram & TikTok: <strong>@DeBonteKoe</strong></p>
</footer>

</body>
</html>

