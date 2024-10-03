<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Profile_user.css">
    <script>
        function Create_user() {
            // Redirige vers le script PHP
            window.location.href = 'Create_user.php'; // Changez 'traitement.php' pour votre script
        }
    </script>
</head>
<body>
<header>
        <nav>
            <div class="Title_nav">
                <h1>Tournament Manager</h1>
            </div>
            <ul>
                <li class="deroulant_Main"><a href="#"> Creation &ensp;</a>
                    <ul class="deroulant_Second">
                        <li><a href="Create_user.php"> Account creation </a></li>
                        <li><a href="Create_user.php"> Team creation </a></li>
                        <li><a href="Create_user.php"> Tournament creation </a></li>
                    </ul>
                </li>
                
                <li class="deroulant_Main"><a href="#"> Profile &ensp;</a>
                        <ul class="deroulant_Second">
                            <li><a> Account creation </a></li>
                            <li><a> Team creation </a></li>
                            <li><a> Tournament creation </a></li>
                        </ul>
                 </li>
            </ul>
        </nav>
    </header>
    <br>
    <div class="Box_section">
    <section class="Profile_Main">
        <h1>Profile</h1>
        <?php
        session_start();
            try {
                if (isset($_SESSION['user_id'])) {
                    echo "Hi, " . $_SESSION['username'] . " !";
                } else {
                    echo "Vous n'êtes pas connecté.";
                }
                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $username = "SELECT username FROM players";
                $creation_date = "SELECT creation_date FROM players";
                $bio = "SELECT bio FROM players";
                $email = "SELECT email FROM players";
                $stmt = $conn->prepare($username);
                $result = $stmt->fetch();
                print($result);
                $stmt = $conn->prepare($creation_date);
                $result = $stmt->fetch();
                print($result);
                $stmt = $conn->prepare($bio);
                $result = $stmt->fetch();
                print($result);
                $stmt = $conn->prepare($email);
                $result = $stmt->fetch();
                print($result);
            } 
            catch (PDOException $e) { 
                echo 'Erreur : ' . $e->getMessage();
            }
        ?>
    </section>
    <section class="Profile_Main">
        <h1>Profile</h1>

    </section>
    <section class="Profile_Main">
        <h1>Profile</h1>

    </section>
    </div>

        <a href=Main.php> Retour Main</a>
    </body>

</html>