
<?php
require_once "connexion.php";

$table = $_GET['table'] ?? '';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

$tables = ['filieres', 'users', 'notes'];

if (!in_array($table, $tables) || $id <= 0) {
    die("Paramètres invalides !");
}

if ($_SERVER["REQUEST_METHOD"] != "POST") {
    die("Aucune donnée reçue !");
}

if ($table == 'filieres') {

    $nom_filiere = trim($_POST['nom_filiere']);

    $sql = "UPDATE filieres SET nom_filiere = ? WHERE id = ?";

    $requete = mysqli_prepare($connexion, $sql);
    mysqli_stmt_bind_param($requete, "si", $nom_filiere, $id);

}

elseif ($table == 'users') {

    $nom = trim($_POST['nom']);
    $prenom = trim($_POST['prenom']);
    $filiere_id = (int) $_POST['filiere_id'];
    $moyenne = (float) $_POST['moyenne'];
    $passe = $_POST['passe'] ?? '';

    if ($passe == '') {


        $sql = "UPDATE users
                SET nom = ?, prenom = ?, filiere_id = ?, moyenne = ?
                WHERE id = ?";

        $requete = mysqli_prepare($connexion, $sql);

        mysqli_stmt_bind_param(
            $requete,
            "ssidi",
            $nom,
            $prenom,
            $filiere_id,
            $moyenne,
            $id
        );

    } else {

        $passe = password_hash($passe, PASSWORD_DEFAULT);

        $sql = "UPDATE users
                SET nom = ?, prenom = ?, filiere_id = ?,
                    moyenne = ?, passe = ?
                WHERE id = ?";

        $requete = mysqli_prepare($connexion, $sql);

        mysqli_stmt_bind_param(
            $requete,
            "ssidsi",
            $nom,
            $prenom,
            $filiere_id,
            $moyenne,
            $passe,
            $id
        );
    }
}

elseif ($table == 'notes') {

    $user_id = (int) $_POST['user_id'];
    $matiere = trim($_POST['matiere']);
    $note = (float) $_POST['note'];

    $sql = "UPDATE notes
            SET user_id = ?, matiere = ?, note = ?
            WHERE id = ?";

    $requete = mysqli_prepare($connexion, $sql);

    mysqli_stmt_bind_param(
        $requete,
        "isdi",
        $user_id,
        $matiere,
        $note,
        $id
    );
}

if (mysqli_stmt_execute($requete)) {

    echo "Modification effectuée avec succès !";

    echo '<br><br><a href="lire.php?table=' .
         htmlspecialchars($table) . '">Voir la liste</a>';

} else {

    echo "Erreur lors de la modification : " .
         htmlspecialchars(mysqli_stmt_error($requete));
}

mysqli_stmt_close($requete);
?>

<br><br>
<a href="index.php">Retour à l'accueil</a>
