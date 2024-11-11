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
    <link rel="stylesheet" href="Profile.css">
</head>
<body>
    <header>
        <nav>
            <ul>
                <li class="logo_container">
                    <img class="logo" src="Image/logo.png">
                        </li>
                            <li class="deroulant_Main"><a href="#"> Players &ensp;</a>
                                <ul class="deroulant_Second">
                                   <li><a href="Login_user.php"> My Profile </a></li>
                                   <li><a href="Create_user.php"> Browse Players </a></li>
                                </ul>
                           </li>
                            <li class="deroulant_Main"><a href="#"> Teams &ensp;</a>
                                <ul class="deroulant_Second">
                                    <li><a href="Team_hub.php"> My Teams </a></li>
                                    <li><a> Join Teams </a></li>
                                </ul>
                            </li>
                            <li class="deroulant_Main"><a href="#"> Games &ensp;</a>
                                <ul class="deroulant_Second">
                                    <li><a href="Profile_user.php"> Add game </a></li>
                                    <li><a> Browse games </a></li>
                                </ul>
                            </li>
                            <li class="deroulant_Main"><a href="#"> Tournaments &ensp;</a>
                                <ul class="deroulant_Second">
                                    <li><a href="Tournament_hub.php"> My tournaments </a></li>
                                    <li><a href="Tournament_hub.php"> Join tournament </a></li>
                                    <li><a href="Create_tournament.php"> Browse tournaments </a></li>    
                                </ul>
                            </li>
                        </li>
            </ul>   
        </nav>
    </header>
    <div class="content">
        <section class="Profile_Main">
         <?php  $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT * FROM players WHERE username = :session_username";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':session_username', $_SESSION['username'], PDO::PARAM_STR);
                $rep->execute();
                $user = $rep->fetch(PDO::FETCH_ASSOC);
                    
        ?> 
        <div class="information">
            <div class="Menu_info">
                <h2>Information</h2>
                <div class="button">
                    <a href="Profile_user_upg.php"><img src="Image/Menu.png" class="img_button"></a>
                </div>
            </div>
            <div class="tab_item">
                <div class="item">
                    <?php echo "Username : " . $user['username']; ?>
                </div>
                <div class="item">
                    <?php  echo "email : " . $user['email'];?>
                </div>
                <div class="item">
                    <?php echo "creation_acc : " . $user['creation_date'];?>
                </div>
                <div class="item">
                    <?php echo "Bio : " . $user['bio'];?>
                </div>
            </div>
        </div>
    </section>
    <section class="Your_game">
        <div class="information">
            <div class="Menu_info">
                <h2>Your games</h2>
                <div class="button">
                    <a href="Profile_user_upg.php"><img src="Image/Menu.png" class="img_button"></a>
                </div>
            </div>
            <?php
                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT title FROM games WHERE id IN (SELECT game_id FROM played_games WHERE player_id = :user_id)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
                $rep->execute();
                $games = $rep->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div>
                    <?php foreach ($games as $game): ?>
                        <p><?php echo htmlspecialchars($game['title']); ?></p>
                    <?php endforeach; ?>
                </div>
        </div>
    </section>
    <section class="Team">
        <div class="information">
            <div class="Menu_info">
                <h2>Team</h2>
            <div class="Menu_info">
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
    <section class="History">
            
    </section>
    <section class="Newgame">
        <div class="information">
            <div class="Menu_info">
                <h2>Newgame</h2>
                    <form method="post" action="login_user.php">
                        <div class="bo">
                                <div class="arena_text">
                                <input class="left-space" type="text" name="Name_newgame" size="12" required>
                                    <label>Name</label>
                                    <span>Name</span>
                                </div>
                                <div class="arena_text">
                                <input class="left-space" type="text" name="Rules_newgame" size="12" required>
                                    <label>Rules</label>
                                    <span>Rules</span>
                                </div>
                                <div class="arena_text">
                                <input class="left-space" type="text" name="Name_newgame" size="12" required>
                                    <label>Name</label>
                                    <span>Name</span>
                                </div>
                                <input class="button" type="submit" name="add_newgame" value="Connexion" value="1" required>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </section>
    </div>

        <a href=Main.php> Retour Main</a>
    </body>
</html>