
<?php

require_once "connexion.php";

$table = $_GET['table'] ?? '';

$tables = ['filieres', 'users', 'notes'];

if (!in_array($table, $tables)) {
    die("Table non autorisée !");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($table == 'filieres') {

        $nom_filiere = trim($_POST['nom_filiere']);

        $requete = mysqli_prepare(
            $connexion,
            "INSERT INTO filieres (nom_filiere) VALUES (?)"
        );

        mysqli_stmt_bind_param($requete, "s", $nom_filiere);
    }

    elseif ($table == 'users') {

        $nom = trim($_POST['nom']);
        $prenom = trim($_POST['prenom']);
        $filiere_id = (int) $_POST['filiere_id'];
        $moyenne = (float) $_POST['moyenne'];

        $passe = password_hash($_POST['passe'], PASSWORD_DEFAULT);

        $requete = mysqli_prepare(
            $connexion,
            "INSERT INTO users
            (nom, prenom, filiere_id, moyenne, passe)
            VALUES (?, ?, ?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $requete,
            "ssids",
            $nom,
            $prenom,
            $filiere_id,
            $moyenne,
            $passe
        );
    }

    elseif ($table == 'notes') {

        $user_id = (int) $_POST['user_id'];
        $matiere = trim($_POST['matiere']);
        $note = (float) $_POST['note'];

        $requete = mysqli_prepare(
            $connexion,
            "INSERT INTO notes (user_id, matiere, note)
             VALUES (?, ?, ?)"
        );

        mysqli_stmt_bind_param(
            $requete,
            "isd",
            $user_id,
            $matiere,
            $note
        );
    }

    if (mysqli_stmt_execute($requete)) {

        echo "Enregistrement effectué avec succès !";

        echo '<br><br><a href="ajouter.php?table='
             . htmlspecialchars($table)
             . '">Ajouter encore</a>';

        echo '<br><br><a href="lire.php?table='
             . htmlspecialchars($table)
             . '">Voir la liste</a>';

    } else {

        echo "Erreur lors de l'enregistrement : "
             . htmlspecialchars(mysqli_stmt_error($requete));
    }

    mysqli_stmt_close($requete);

} else {

    echo "Aucune donnée reçue.";

}

?>

<br><br>
<a href="index.php">Retour à l'accueil</a>
