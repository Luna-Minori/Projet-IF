<?php
    session_start();
    
    // if (!isset($_SESSION['username'])) {
    //     header('Location: Login_user.php');
    //     exit();
    // }

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $title = $_POST['title'];
        $password = $_POST['password'];
        $game = $_POST['game'];

        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $sql = "SELECT hashed_password FROM players WHERE username = :username";
        $rep = $conn->prepare($sql);
        $rep->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
        $rep->execute();
        $Hpassword = $rep->fetchColumn();

        if ($Hpassword && password_verify($password, $Hpassword)) {

            $sql = "SELECT COUNT(*) FROM teams WHERE title = :title";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':title', $title, PDO::PARAM_STR);
            $rep->execute();
            $number = $rep->fetchColumn();
            echo $number;
            if($number == 0){
                $sql = "INSERT INTO teams (title, creator_id, game_id) VALUES (:title, (SELECT id FROM players WHERE username = :username), :game)";
                $rep = $conn->prepare($sql);
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $rep->bindParam(':title', $title, PDO::PARAM_STR);
                $rep->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
                $rep->bindParam(':game', $game, PDO::PARAM_STR);
                $rep->execute();

                $sql = "SELECT id FROM players WHERE username = :username";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
                $rep->execute();
                $id_player = $rep->fetchColumn();

                $sql = "SELECT id FROM teams WHERE title = :title";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':title', $title, PDO::PARAM_STR);
                $rep->execute();
                $id_team = $rep->fetchColumn();

                $sql = "INSERT INTO player_teams (player_id, team_id, Administrator) VALUES (:id_player, :id_team, 1)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':id_player', $id_player, PDO::PARAM_INT);
                $rep->bindParam(':id_team',$id_team, PDO::PARAM_INT);
                $rep->execute();

                header('Location: Team_hub.php');
                exit();
            }
            else {
                echo "This name is already used";
            }   
        }
        else {
        echo "Invalid password";
        }
    }
?>
    
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Create.css">
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
                        <li><a href="Log_out.php"> Log Out </a></li>
                    </ul>
                </li>
                <li class="deroulant_Main"><a href="#"> Teams &ensp;</a>
                    <ul class="deroulant_Second">
                        <li><a href="Team_hub.php"> My Teams </a></li>
                        <li><a href="Team_hub.php"> Join Teams </a></li>
                        <li><a href="Create_team.php"> Create Team </a></li>
                    </ul>
                </li>

                <li class="deroulant_Main"><a href="#"> Tournaments &ensp;</a>
                    <ul class="deroulant_Second">
                        <li><a href="Tournament_hub.php"> My tournaments </a></li>
                        <li><a href="Tournament_hub.php"> Join tournament </a></li>
                        <li><a href="Create_tournament.php"> Browse tournaments </a></li>
                    </ul>
                </li>
                <li class="deroulant_Main"><a href=Profile_user.php> Add Games &ensp;</a></li>
                </li>
            </ul>
        </nav>
    </header>
    <section
        <main>
            <div class="Create">
                <form method="post" action="Create_team.php">
                    <div class="bo">
                        <h2 class="Title_form">Team Creation</h2>
                            <div class="text_form">
                                <br>
                                <div class="arena_text">
                                    <input class="left-space" type="text" id="username" name="title" size="12" required>
                                        <label>Name of your team</label>
                                        <span>Name of your team</span>
                                    </div>
                                    <div class="arena_text">
                                        <input class="left-space" type="text" name="password" size="12" required>
                                        <label>Your Password</label>
                                        <span>Your Password</span>
                                    </div>

                                    <div class="arena_text">
                                        <div class="choice_game">
                                            <p>Choice game</p>
                                            <select name="game" id="game_select">
                                                <?php 
                                                    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                                                    $sql = "SELECT title, id FROM games";
                                                    $rep = $conn->prepare($sql);
                                                    $rep->execute();
                                                    $Basedata = $rep->fetchAll();
                                                    foreach ($Basedata as $game) {
                                                        echo "<option value='" . htmlspecialchars($game['id']) . "'>" . htmlspecialchars($game['title']) . "</option>";
                                                    }

                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <input class="button" type="submit" name="condition" value="Creation" value="1" required>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </main>
    </body>
</html>