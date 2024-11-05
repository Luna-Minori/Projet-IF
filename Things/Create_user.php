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
<header>
        <div class="img_container">
            <a src="Main.php"><img class="fond" src="Image/fond.png"></a>
                <nav>
                    <ul>
                        <li class="deroulant_Main"><a href="#"> Profile &ensp;</a>
                            <ul class="deroulant_Second">
                               <li><a href="Create_user.php"> Account creation </a></li>
                               <li><a href="Create_user.php"> Team creation </a></li>
                               <li><a href="Create_user.php"> Tournament creation </a></li>
                            </ul>
                       </li>
                    <li class="deroulant_Main"><a href="#"> Team &ensp;</a>
                        <ul class="deroulant_Second">
                            <li><a> Account creation </a></li>
                            <li><a> Team creation </a></li>
                            <li><a> Tournament creation </a></li>
                       </ul>
                    </li>
                    <li class="logo_container">
                        <img class="logo" src="Image/logo.png">
                    </li>
                    <li class="deroulant_Main"><a href="#"> Tournament &ensp;</a>
                            <ul class="deroulant_Second">
                                <li><a> Account creation </a></li>
                                <li><a> Team creation </a></li>
                                <li><a> Tournament creation </a></li>                                </ul>
                        </li>
                    <li class="deroulant_Main"><a href="#"> Creation of &ensp;</a>
                            <ul class="deroulant_Second">
                                <li><a> Account creation </a></li>
                                <li><a> Team creation </a></li>
                                <li><a> Tournament creation </a></li>
                            </ul>
                     </li>
                </ul>
            </nav>
            <h1>Tournament Manager</h1>
        </div>
    </header>
    
    <?php
    session_start();
    /*
    try {

        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $sql = "SELECT * FROM board_game_tournament";
        $stmt = $conn->prepare($sql);
        $result = $stmt->fetchAll();
    } 
    catch (PDOException $e) { 
        echo 'Erreur : ' . $e->getMessage();
    }
    try{
        $sql = "INSERT INTO players(username, bio, email, hashed_password) VALUES ('Minori', 'me', 'luna@utbm', '@kija')";
        $rep = $conn->prepare($sql);
        $rep->execute();
    }
    catch (PDOException $e) { 
        echo 'Erreur : ' . $e->getMessage();
    }

    $sql = "SELECT username FROM players";
    $rep = $conn->prepare($sql);
    $rep->execute();
    $result = $rep->fetchAll();
    print_r($result);
    echo $result["username"];
    */
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST['username'];
        echo "Boujour " . htmlspecialchars($username);

    }
    ?>
    <br>
        <form method="post" action="Profile_user.php">
                Firstname :
                <input class="left-space" type="text" id="username" name="username" size="12" required>
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
                <input type="submit" name="condition" value="OK"     value="1" required>
                <input type="reset" value="Reset">
        </form>

        <a href=Main.php> Retour Main</a>
    </body>

</html>