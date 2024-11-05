<?php
    session_start();
    
    if (!isset($_SESSION['username'])) {
        header('Location: Login_user.php');
        exit();
    }
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

            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
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
    <link rel="stylesheet" href="Create_team.css">
</head>
<body>
<header>
    <main>
        <div class="Create">
            <form method="post" action="Create_team.php">
                <div class="bo">
                    <h2 class="Title_form">Account Creation</h2>
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
                                <input class="button" type="submit" name="condition" value="Creation" value="1" required>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </main>

        <a href=Main.php> Retour Main</a>
    </body>

</html>