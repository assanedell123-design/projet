
<?php
require_once "connexion.php";

$table = $_GET['table'] ?? 'filieres';

$tablesAutorisees = ['filieres', 'users', 'notes'];

if (!in_array($table, $tablesAutorisees)) {
    $table = 'filieres';
}

$titres = [
    'filieres' => 'Gestion des filières',
    'users' => 'Gestion des étudiants',
    'notes' => 'Gestion des notes'
];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion scolaire</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            background: #1eb811;
        }

        header {
            background: #24527a;
            color: white;
            padding: 20px;
            text-align: center;
        }

        nav {
            background: #333;
            padding: 15px;
            text-align: center;
        }

        nav a {
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            margin: 5px;
            display: inline-block;
            border-radius: 5px;
        }

        nav a:hover, nav a.active {
            background: #24527a;
        }

        main {
            background: white;
            width: 85%;
            margin: 30px auto;
            padding: 25px;
            border-radius: 8px;
            min-height: 300px;
        }

        h2 {
            color: #24527a;
        }

        .actions a {
            display: inline-block;
            background: #061b2e;
            color: white;
            padding: 10px 15px;
            margin: 5px;
            text-decoration: none;
            border-radius: 4px;
        }

        footer {
            text-align: center;
            padding: 15px;
            color: #666;
        }
    </style>
</head>

<body>

<header>
    <h1>Application de gestion scolaire</h1>
    <p>Gestion des filières, des étudiants et des notes</p>
</header>

<nav>
    <a href="index.php?table=filieres"
       class="<?= $table == 'filieres' ? 'active' : '' ?>">
       Filières
    </a>

    <a href="index.php?table=users"
       class="<?= $table == 'users' ? 'active' : '' ?>">
       Étudiants
    </a>

    <a href="index.php?table=notes"
       class="<?= $table == 'notes' ? 'active' : '' ?>">
       Notes
    </a>
</nav>

<main>
    <h2><?= $titres[$table] ?></h2>

    <p>
        Bienvenue dans l'espace de gestion.
        Sélectionne une opération pour gérer les données.
    </p>

    <div class="actions">
        <a href="#">Ajouter</a>
        <a href="#">Consulter</a>
        <a href="#">Modifier</a>
        <a href="#">Supprimer</a>
    </div>

    <hr>

    <p>
        La liste des données de la table
        <strong><?= htmlspecialchars($table) ?></strong>
        apparaîtra ici.
    </p>
</main>

<footer>
    Projet de gestion scolaire - PHP / MySQL
</footer>

</body>
</html>
