
<?php
require_once "connexion.php";

$table = $_GET['table'] ?? 'filieres';

$tables = ['filieres', 'users', 'notes'];

if (!in_array($table, $tables)) {
    die("Table non autorisée !");
}

if ($table == 'filieres') {

    $sql = "SELECT * FROM filieres";
    $resultat = mysqli_query($connexion, $sql);

}
elseif ($table == 'users') {

    $sql = "SELECT users.*, filieres.nom_filiere
            FROM users
            INNER JOIN filieres
            ON users.filiere_id = filieres.id";

    $resultat = mysqli_query($connexion, $sql);

}
elseif ($table == 'notes') {

    $sql = "SELECT notes.*, users.nom, users.prenom
            FROM notes
            INNER JOIN users
            ON notes.user_id = users.id";

    $resultat = mysqli_query($connexion, $sql);

}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Liste des données</title>
</head>
<body>

<h2>Liste des <?php echo htmlspecialchars($table); ?></h2>

<a href="index.php">Accueil</a> |
<a href="ajouter.php?table=<?php echo $table; ?>">Ajouter</a>

<br><br>

<?php if ($table == 'filieres') { ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nom de la filière</th>
            <th>Actions</th>
        </tr>

        <?php while ($ligne = mysqli_fetch_assoc($resultat)) { ?>
            <tr>
                <td><?php echo $ligne['id']; ?></td>
                <td><?php echo htmlspecialchars($ligne['nom_filiere']); ?></td>
                <td>
                    <a href="modifier.php?table=filieres&id=<?php echo $ligne['id']; ?>">Modifier</a> |
                    <a href="supprimer.php?table=filieres&id=<?php echo $ligne['id']; ?>">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
    </table>

<?php } elseif ($table == 'users') { ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Filière</th>
            <th>Moyenne</th>
            <th>Actions</th>
        </tr>

        <?php while ($ligne = mysqli_fetch_assoc($resultat)) { ?>
            <tr>
                <td><?php echo $ligne['id']; ?></td>
                <td><?php echo htmlspecialchars($ligne['nom']); ?></td>
                <td><?php echo htmlspecialchars($ligne['prenom']); ?></td>
                <td><?php echo htmlspecialchars($ligne['nom_filiere']); ?></td>
                <td><?php echo $ligne['moyenne']; ?></td>
                <td>
                    <a href="modifier.php?table=users&id=<?php echo $ligne['id']; ?>">Modifier</a> |
                    <a href="supprimer.php?table=users&id=<?php echo $ligne['id']; ?>">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
    </table>

<?php } elseif ($table == 'notes') { ?>

    <table border="1" cellpadding="8">
        <tr>
            <th>ID</th>
            <th>Étudiant</th>
            <th>Matière</th>
            <th>Note</th>
            <th>Actions</th>
        </tr>

        <?php while ($ligne = mysqli_fetch_assoc($resultat)) { ?>
            <tr>
                <td><?php echo $ligne['id']; ?></td>
                <td>
                    <?php echo htmlspecialchars($ligne['nom'] . ' ' . $ligne['prenom']); ?>
                </td>
                <td><?php echo htmlspecialchars($ligne['matiere']); ?></td>
                <td><?php echo $ligne['note']; ?></td>
                <td>
                    <a href="modifier.php?table=notes&id=<?php echo $ligne['id']; ?>">Modifier</a> |
                    <a href="supprimer.php?table=notes&id=<?php echo $ligne['id']; ?>">Supprimer</a>
                </td>
            </tr>
        <?php } ?>
    </table>

<?php } ?>

</body>
</html>
