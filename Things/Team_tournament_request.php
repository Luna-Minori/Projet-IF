<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['request_id'])) {
        if (isset($_POST['Update_request'])) {
            if ($_POST['Update_request'] == 2) {

                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');

                $sql = "INSERT INTO team_tournaments(team_id, tournament_id VALUES (tournament_id =:tournament_id AND team_id = (SELECT id FROM teams WHERE id =:team_id)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $_POST['tournament_id'], PDO::PARAM_INT);
                $rep->bindParam(':team_id', $_POST['team_id'], PDO::PARAM_STR);
                $rep->execute();
                $number = $rep->fetchColumn();
            }
        }
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
                    <a href="Main.php"><img class="logo" src="Image/logo.png"></a>
                </li>
                <li class="deroulant_Main"><a href="#"> Players &ensp;</a>
                    <ul class="deroulant_Second">
                        <li><a href="Login_user.php"> My Profile </a></li>

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
                <li class="deroulant_Main"><a href="#"> Games &ensp;</a>
                    <ul class="deroulant_Second">
                        <li><a href="Profile_user.php"> Add Games </a></li>
                        <li><a href="Profile_game.php"> Games Stats </a></li>
                    </ul>
                </li>
                </li>
            </ul>
        </nav>
    </header>
    <section>
        <main>
            <div class="Create">
                <form method="post" action="Create_user.php">
                    <div class="bo">
                        <h2 class="Title_form">Register team tournament</h2>
                        <div class="text_form">
                            <br>
                            <div class="arena_text">
                                <input class="left-space" type="text" id="username" name="Name" size="12" required>
                                <label>Name of your team</label>
                                <span>Name of your team</span>
                            </div>
                            <input class="button" type="submit" name="condition" value="Creation" required>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </main>
    </section>
</body>

</html>