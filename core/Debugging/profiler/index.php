<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Log Viewer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f8f8;
            margin: 20px;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .line {
            margin-bottom: 10px;
        }

        .error {
            color: red;
        }
    </style>
</head>
<body>
<div class="container">
    <?php
    // ouverture du fichier
    $fh = fopen('../../../logs/dev/dev.log', 'r');

    // tant que je ne suis pas à la fin du fichier
    while (!feof($fh)) {
        // je récupère la ligne courante
        $ligne = fgets($fh);

        // échapper une seule fois et stocker dans une variable
        $escapedLigne = htmlspecialchars($ligne);

        // vérifier si la ligne contient "ERROR" ou "EXCEPTION"
        if (str_contains($escapedLigne, "ERROR") || str_contains($escapedLigne, "EXCEPTION")) {
            // ajouter un saut de ligne avant le texte "ERROR" ou "EXCEPTION"
            echo "<hr>";
            echo "<br>";
            // j'affiche le contenu de la ligne avec la classe 'error' pour la couleur rouge
            echo '<div class="line error">' . $escapedLigne . "</div>";
        } else {
            // j'affiche le contenu de la ligne normalement
            echo '<div class="line">' . $escapedLigne . "</div>";
        }
    }

    // je ferme mon fichier
    fclose($fh);
    ?>
</div>
</body>
</html>
