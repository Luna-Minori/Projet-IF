<!DOCTYPE html>
<html lang="fr">
    <script>
        function return_to_main() {
            // Redirige vers le script PHP
            window.location.href = 'main.php'; 
        }
        </script>
<head>
    <meta charset="UTF-8">
    <title>Mon formulaire</title>
    <style>
        .button {
            display: inline-block;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            text-align: center;
            text-decoration: none;
            outline: none;
            color: #fff;
            background-color: #4CAF50;
            border: none;
            border-radius: 5px;
            box-shadow: 0 4px #999;
        }

        .button:hover {background-color: #3e8e41}

        .button:active {
            background-color: #3e8e41;
            box-shadow: 0 2px #666;
            transform: translateY(2px);
        }
    </style>
</head>
<body>

<form action="Create_user.php" method="post">
    Username : <input type="text" name="name" /><br />
    Email : <input type="text" name="email" /><br />
    Password : <input type="password" name="password" /><br />
    <input type="submit" value="Envoyer" />
</form>

<a class="button" onclick="return_to_main()">Retour au menu principal</a>

</body>
</html>