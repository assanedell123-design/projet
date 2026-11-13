
<?php
require_once "connexion.php";

$table = $_GET['table'] ?? 'filieres';

$tables = ['filieres', 'users', 'notes'];

if (!in_array($table, $tables)) {
    die("Table non autorisée !");
}
if ($table == 'users') {
    $filieres = mysqli_query(
        $connexion,
        "SELECT * FROM filieres"
    );
}

if ($table == 'notes') {
    $etudiants = mysqli_query(
        $connexion,
        "SELECT id, nom, prenom FROM users"
    );
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter des données</title>
</head>
<body>

<h2>Ajouter des données</h2>

<?php if ($table == 'filieres') { ?>

    <h3>Ajouter une filière</h3>

    <form action="traitement.php?table=filieres" method="POST">

        <label>Nom de la filière :</label><br>
        <input type="text" name="nom_filiere" required>

        <br><br>

        <input type="submit" value="Enregistrer">

    </form>

<?php } elseif ($table == 'users') { ?>

    <h3>Ajouter un étudiant</h3>

    <form action="traitement.php?table=users" method="POST">

        <label>Nom :</label><br>
        <input type="text" name="nom" required>

        <br><br>

        <label>Prénom :</label><br>
        <input type="text" name="prenom" required>

        <br><br>

        <label>Filière :</label><br>

        <select name="filiere_id" required>
            <option value="">Choisir une filière</option>

            <?php while ($filiere = mysqli_fetch_assoc($filieres)) { ?>
                <option value="<?php echo $filiere['id']; ?>">
                    <?php echo htmlspecialchars($filiere['nom_filiere']); ?>
                </option>
            <?php } ?>

        </select>

        <br><br>

        <label>Moyenne :</label><br>
        <input type="number" name="moyenne"
               min="0" max="20" step="0.01" required>

        <br><br>

        <label>Mot de passe :</label><br>
        <input type="password" name="passe" required>

        <br><br>

        <input type="submit" value="Enregistrer">

    </form>

<?php } elseif ($table == 'notes') { ?>

    <h3>Ajouter une note</h3>

    <form action="traitement.php?table=notes" method="POST">

        <label>Étudiant :</label><br>

        <select name="user_id" required>
            <option value="">Choisir un étudiant</option>

            <?php while ($etudiant = mysqli_fetch_assoc($etudiants)) { ?>
                <option value="<?php echo $etudiant['id']; ?>">
                    <?php
                    echo htmlspecialchars(
                        $etudiant['nom'] . " " . $etudiant['prenom']
                    );
                    ?>
                </option>
            <?php } ?>

        </select>

        <br><br>

        <label>Matière :</label><br>
        <input type="text" name="matiere" required>

        <br><br>

        <label>Note :</label><br>
        <input type="number" name="note"
               min="0" max="20" step="0.01" required>

        <br><br>

        <input type="submit" value="Enregistrer">

    </form>

<?php } ?>

<br><br>

<a href="index.php">Retour à l'accueil</a>

</body>
</html>
