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

    use Core\Environment\DotEnv;

    $dotEnv = new DotEnv();
    $environment = $dotEnv->getVariable("ENVIRONMENT");
    /*
    if ($environment==="dev"){

        $fh = fopen('../../../logs/dev/dev.log', 'r');

    }else{
        $fh = fopen('../../../logs/prod/prod.log', 'r');
    }*/
    $fh = fopen('../../../logs/dev/dev.log', 'r');

    while (!feof($fh)) {
        $ligne = fgets($fh);

        $escapedLigne = htmlspecialchars($ligne);

        if (str_contains($escapedLigne, "ERROR") || str_contains($escapedLigne, "EXCEPTION")) {
            echo "<hr>";

            echo "<br>";
            echo '<div class="line error">' . $escapedLigne . "</div>";
        } else {
            echo '<div class="line">' . $escapedLigne . "</div>";
        }
    }

    // je ferme mon fichier
    fclose($fh);
    ?>
</div>
</body>
</html>
