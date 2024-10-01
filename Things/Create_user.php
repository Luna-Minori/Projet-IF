<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Create_user.css">
    <script>
        function Create_user() {
            // Redirige vers le script PHP
            window.location.href = 'Create_user.php'; // Changez 'traitement.php' pour votre script
        }
    </script>
</head>
<body>
        <form method="post" action="verif.php">
                Firstname :
                <input class="left-space" type="text" name="nom" size="12" required>
                <br>
                name : 
                <input class="left-space" type="text" name="prenom" size="12" required>
                <br>
                email :
                <input class="left-space" type="email" name="email" size="12" required>
                <br>
                Gender :
                <input class="left-space" type="Text" name="email" size="12">
                <br>
                <input type="radio" name="eail" size="12" required>
                Accepter vous les conditions générale utilisation de Tournament Manager
                <br>
                <input type="submit" name="condition" value="OK" value="1" required>
                <input type="reset" value="Reset">
        </form>

        <a href=Main.php> Retour Main</a>
    </body>

</html>