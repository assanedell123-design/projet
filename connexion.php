
<?php

$serveur = "127.0.0.1";
$utilisateur = "root";
$motDePasse = "";
$baseDeDonnees = "etudiants";
$port = 3307;

try {

    $connexion = mysqli_connect(
        $serveur,
        $utilisateur,
        $motDePasse,
        $baseDeDonnees,
        $port
    );

    mysqli_set_charset($connexion, "utf8mb4");

} catch (mysqli_sql_exception $e) {

    die("Erreur de connexion : " . $e->getMessage());

}

?>
