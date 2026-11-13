
<?php
require_once "connexion.php";

$table = $_GET['table'] ?? '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$tables = ['filieres', 'users', 'notes'];

if (!in_array($table, $tables) || $id <= 0) {
    die("Paramètres invalides !");
}

if ($table == 'filieres') {

    $sql = "SELECT * FROM filieres WHERE id = ?";

}
elseif ($table == 'users') {

    $sql = "SELECT * FROM users WHERE id = ?";

}
elseif ($table == 'notes') {

    $sql = "SELECT * FROM notes WHERE id = ?";

}

$requete = mysqli_prepare($connexion, $sql);
mysqli_stmt_bind_param($requete, "i", $id);
mysqli_stmt_execute($requete);

$resultat = mysqli_stmt_get_result($requete);
$donnees = mysqli_fetch_assoc($resultat);

if (!$donnees) {
    die("Enregistrement introuvable !");
}

if ($table == 'users') {
    $filieres = mysqli_query($connexion, "SELECT * FROM filieres");
}

if ($table == 'notes') {
    $users = mysqli_query(
        $connexion,
        "SELECT id, nom, prenom FROM users"
    );
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Modifier</title>
</head>
<body>

<h2>Modifier : <?php echo htmlspecialchars($table); ?></h2>

<?php if ($table == 'filieres') { ?>

    <form action="modifier_traitement.php?table=filieres&id=<?php echo $id; ?>" method="POST">

        <label>Nom de la filière :</label>
        <input type="text" name="nom_filiere"
               value="<?php echo htmlspecialchars($donnees['nom_filiere']); ?>"
               required>

        <br><br>
        <button type="submit">Enregistrer les modifications</button>
    </form>

<?php } elseif ($table == 'users') { ?>

    <form action="modifier_traitement.php?table=users&id=<?php echo $id; ?>" method="POST">

        <label>Nom :</label>
        <input type="text" name="nom"
               value="<?php echo htmlspecialchars($donnees['nom']); ?>"
               required>

        <br><br>

        <label>Prénom :</label>
        <input type="text" name="prenom"
               value="<?php echo htmlspecialchars($donnees['prenom']); ?>"
               required>

        <br><br>

        <label>Filière :</label>
        <select name="filiere_id" required>
            <?php while ($f = mysqli_fetch_assoc($filieres)) { ?>
                <option value="<?php echo $f['id']; ?>"
                    <?php if ($f['id'] == $donnees['filiere_id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($f['nom_filiere']); ?>
                </option>
            <?php } ?>
        </select>

        <br><br>

        <label>Moyenne :</label>
        <input type="number" name="moyenne" step="0.01"
               value="<?php echo $donnees['moyenne']; ?>"
               required>

        <br><br>

        <label>Nouveau mot de passe (facultatif) :</label>
        <input type="password" name="passe">

        <br><br>
        <button type="submit">Enregistrer les modifications</button>
    </form>

<?php } elseif ($table == 'notes') { ?>

    <form action="modifier_traitement.php?table=notes&id=<?php echo $id; ?>" method="POST">

        <label>Étudiant :</label>
        <select name="user_id" required>
            <?php while ($u = mysqli_fetch_assoc($users)) { ?>
                <option value="<?php echo $u['id']; ?>"
                    <?php if ($u['id'] == $donnees['user_id']) echo 'selected'; ?>>
                    <?php echo htmlspecialchars($u['nom'] . ' ' . $u['prenom']); ?>
                </option>
            <?php } ?>
        </select>

        <br><br>

        <label>Matière :</label>
        <input type="text" name="matiere"
               value="<?php echo htmlspecialchars($donnees['matiere']); ?>"
               required>

        <br><br>

        <label>Note :</label>
        <input type="number" name="note" step="0.01" min="0" max="20"
               value="<?php echo $donnees['note']; ?>"
               required>

        <br><br>
        <button type="submit">Enregistrer les modifications</button>
    </form>

<?php } ?>

<br><br>
<a href="lire.php?table=<?php echo htmlspecialchars($table); ?>">Retour à la liste</a>

</body>
</html>
