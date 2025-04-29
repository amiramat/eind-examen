

<?php
session_start();
if (!isset($_SESSION['medewerker'])) {
    header('Location: login.php');
    exit;
}

include 'db.php';
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Medewerker Paneel - De Bonte Koe</title>
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
        <h2>Overzicht Bestellingen</h2>
        <table>
            <thead>
            <tr>
                <th>Bestelnummer</th>
                <th>Naam</th>
                <th>Aantal</th>
                <th>Dag</th>
                <th>Tijd</th>
                <th>Totaalprijs</th>
                <th>Status</th>
                <th>Acties</th>
            </tr>
            </thead>
            <tbody>
            <?php
            try {
                $stmt = $pdo->query('SELECT * FROM bestellingen ORDER BY dag, tijd');
                while ($row = $stmt->fetch()) {
                    $prijsPerStuk = 12.95;
                    $totaalPrijs = number_format(($row['aantal'] ?? 0) * $prijsPerStuk, 2, ',', '.');

                    echo "<tr>";
                    echo "<td>" . htmlspecialchars($row['id'] ?? '-') . "</td>";
                    echo "<td>" . htmlspecialchars($row['klant_naam'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['aantal'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['dag'] ?? '') . "</td>";
                    echo "<td>" . htmlspecialchars($row['tijd'] ?? '') . "</td>";
                    echo "<td>€" . $totaalPrijs . "</td>";
                    echo "<td>" . htmlspecialchars($row['status'] ?? 'In behandeling') . "</td>";
                    echo "<td>";

                    if (isset($row['id']) && ($row['status'] ?? '') === 'In behandeling') {
                        echo "<form action='status.php' method='get' style='display:inline;'>
                            <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                            <button type='submit' class='btn-status'>Opgehaald</button>
                          </form> ";
                    }

                    if (isset($row['id'])) {
                        echo "<form action='delete.php' method='get' style='display:inline;' onsubmit=\"return confirm('Weet je zeker dat je deze bestelling wilt verwijderen?');\">
                            <input type='hidden' name='id' value='" . htmlspecialchars($row['id']) . "'>
                            <button type='submit' class='btn-verwijder'>Verwijder</button>
                          </form>";
                    }

                    echo "</td>";
                    echo "</tr>";
                }
            } catch (PDOException $e) {
                echo "<tr><td colspan='8' style='color:red;'>Fout bij ophalen bestellingen: " . htmlspecialchars($e->getMessage()) . "</td></tr>";
            }
            ?>
            </tbody>
        </table>
    </section>
</main>

<footer class="footer">
    <p>Hoogstraat 78 | Instagram & TikTok: <strong>@DeBonteKoe</strong></p>
</footer>

</body>
</html>
