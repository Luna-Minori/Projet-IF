<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: Login_user.php');
        exit();
    }
?>

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
        <div class="Title">
            <?php echo "Hii  " . $_SESSION['username']; ?>
        </div>
        <br>

        <?php   $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT * FROM players";
                $rep = $conn->prepare($sql);
                $rep->execute();
                $user = $rep->fetch(PDO::FETCH_ASSOC);
                    
        ?>
        <div class="information">
            <div class="sub_Title">
                <p> Information </p>
            </div>
                <div class="Username">
                    <?php echo "Username : " . $user['username']; ?>
                </div>
                <div class="email">
                    <?php  echo "email : " . $user['email'];?>
                </div>
                <div class="creation_acc">
                    <?php echo "creation_acc : " . $user['creation_date'];?>
                </div>
        </div>
    </section>
    <section class="Your game">
        <div class="sub_Title">
                <p> Your game </p>
        </div>

        <?php
            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
            $sql = "SELECT title FROM games WHERE id = (SELECT game_id FROM played_games WHERE player_id = :user_id)";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
            $rep->execute();
            $game = $rep->fetch(PDO::FETCH_ASSOC);
            ?>
        <div>
            <?php echo $game['title']; ?>
        </div>
        <div class="information">
            <div class="sub_Title">
                <p> Team </p>
            </div>

            <?php
                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT title FROM teams WHERE id = (SELECT game_id FROM player_teams WHERE player_id = :user_id)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
                $rep->execute();
                $Team = $rep->fetch(PDO::FETCH_ASSOC);
            ?>
                <div class="Username">
                    <?php echo "Username : " . $Team['Title']; ?>
                </div>  
        </div>
    </section>
    </div>

        <a href=Main.php> Retour Main</a>
    </body>

</html>