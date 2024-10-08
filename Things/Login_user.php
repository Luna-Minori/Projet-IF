
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Login_user.css">
    <script>
        function Create_user() {
            // Redirige vers le script PHP
            window.location.href = 'Create_user.php'; // Changez 'traitement.php' pour votre script
        }
    </script>
</head>
<body>
    <main>
            <div class="Connexion">
                    <form method="post" action="Profile_user.php">
                        <div class="bo">
                            <h2 class="Title_form">Connexion</h2>
                            <div class="text_form">
                                <br>
                                <div class="arena_text">
                                    <input class="left-space" type="text" id="username" name="username" size="12" required>
                                    <label>Username</label>
                                    <span>Username</span>
                                </div>
                                <br>
                                <div class="arena_text">
                                <input class="left-space" type="text" name="password" size="12" required>
                                    <label>Password</label>
                                    <span>Password</span>
                                </div>
                                <input class="button" type="submit" name="condition" value="OK"     value="1" required>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </main>
    <div class="Main_page">

       <?php
        session_start();       
        ?>
        </div>
</body>
</html>
