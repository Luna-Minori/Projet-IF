
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
        try{
            $sql = "SELECT username FROM players";
            $rep = $conn->prepare($sql);
            $rep->execute();
            $username->fetchAll();

            $sql = "SELECT hashed_password FROM players";
            $rep = $conn->prepare($sql);
            $rep->execute();
            $password->fetchAll();
            $username_test =" a";
            $i=0;
            while($username[$i] != null && $username[$i] == $username_test){
                $i=$i+1;
            };
            if ($username[$i] != null){
                echo "vous etes co";
            };
            
        }
        catch (PDOException $e) { 
            echo 'Erreur : ' . $e->getMessage();
        }
        ?>
        </div>
</body>
</html>
