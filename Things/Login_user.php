
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
                                <input class="button" type="submit" name="condition" value="OK" value="1" required>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </main>
    <div class="Main_page">

       <?php
        session_start();
        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $verif_username = 0;
        $verif_hashed_password = 0;

        $sql = "SELECT username FROM players";
        $rep = $conn->prepare($sql);    
        $rep->execute();
        $username_test =" a";
        while($username = $rep->fetch(PDO::FETCH_ASSOC)){
            if ($username['username'] == $username_test) {
                $verif_username = 1;
                break;
            }
        };

        $sql = "SELECT hashed_password FROM players";
        $rep = $conn->prepare($sql);
        $rep->execute();
        while($hashed_password = $rep->fetch(PDO::FETCH_ASSOC)){
            if ($hashed_password['hashed_password'] == $hashed_password) {
                $verif_password = 1;
                break;
            }
        };

        if ($verif_username == 1 &&  $verif_password == 1){
            
        }
        ?>
        </div>
</body>
</html>
