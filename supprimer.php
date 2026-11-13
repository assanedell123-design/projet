
<?php
require_once "connexion.php";

$table = $_GET['table'] ?? '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$tables = ['filieres', 'users', 'notes'];

if (!in_array($table, $tables) || $id <= 0) {
    die("Paramètres invalides !");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($table == 'filieres') {
        $sql = "DELETE FROM filieres WHERE id = ?";
    }
    elseif ($table == 'users') {
        $sql = "DELETE FROM users WHERE id = ?";
    }
    elseif ($table == 'notes') {
        $sql = "DELETE FROM notes WHERE id = ?";
    }

    $requete = mysqli_prepare($connexion, $sql);

    if (!$requete) {
        die("Erreur de préparation : " .
            htmlspecialchars(mysqli_error($connexion)));
    }

    mysqli_stmt_bind_param($requete, "i", $id);

    if (mysqli_stmt_execute($requete)) {

        if (mysqli_stmt_affected_rows($requete) > 0) {
            echo "Suppression effectuée avec succès !";
        } else {
            echo "Aucun enregistrement trouvé.";
        }

        echo '<br><br><a href="lire.php?table=' .
             htmlspecialchars($table) . '">Retour à la liste</a>';

    } else {
        echo "Erreur lors de la suppression : " .
             htmlspecialchars(mysqli_stmt_error($requete));
    }

    mysqli_stmt_close($requete);

} else {
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Confirmation de suppression</title>
</head>
<body>

    <h2>Confirmation de suppression</h2>

    <p>Voulez-vous vraiment supprimer cet enregistrement ?</p>

    <form method="POST"
          action="supprimer.php?table=<?php echo htmlspecialchars($table); ?>&id=<?php echo $id; ?>">

        <button type="submit">Oui, supprimer</button>

        <a href="lire.php?table=<?php echo htmlspecialchars($table); ?>">
            Annuler
        </a>

    </form>

</body>
</html>

<?php
}
?>
