<?php
session_start();

if (!isset($_SESSION['player_username'])) {
    header('Location: Login_user.php');
    exit();
}

if (!isset($_POST['game_title'])) {
    header('Location: Choices_game.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    $sql = "SELECT pg.*, t.title AS Nteam, g.id AS id, g.title AS title, g.rules AS rules, g.team_based FROM games g INNER JOIN played_games pg ON pg.game_id = g.id INNER JOIN teams t ON t.game_id = g.id WHERE g.title = :title";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':title', $_POST['game_title'], PDO::PARAM_STR);
    $rep->execute();
    $game = $rep->fetch(PDO::FETCH_ASSOC);
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
                    <a href="Main.php"><img class="logo" src="Image/logo.png"></a>
                </li>
                <li class="deroulant_Main"><a href="#"> Players &ensp;</a>
                    <ul class="deroulant_Second">
                        <li><a href="Login_user.php"> Log in </a></li>
                        <li><a href="Profile_user.php"> My Profile </a></li>
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
    <section id="welcome">
        <h2>WELCOME TO GAME STATS PAGE</h2>
    </section>
    <div class="Box_sections">
        <section class="Profile_Main">
            <div class="information">
                <div class="Menu_info">
                    <h2>Information</h2>
                </div>
                <div class="tab_item">
                    <div class="item">
                        <?php echo "ID : " . $game['id']; ?>
                    </div>
                    <div class="item">
                        <?php echo "title : " . $game['title']; ?>
                    </div>
                    <div class="item">
                        <?php echo "rules : " . $game['rules']; ?>
                    </div>
                    <div class="item">
                        <?php
                        if ($game['team_based'] == 1) {
                            echo "The game is team based";
                        } else {
                            echo "The game is singleplayer based";
                        } ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="Your_game">
            <div class="information">
                <div class="Menu_info">
                    <h2>Game Stats</h2>
                </div>
                <table>
                    <?php
                    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                    $sql = $sql = "SELECT COUNT(pg.player_id) AS player, COUNT(t.id) AS team, COUNT(tour.id) AS tournament FROM games g INNER JOIN teams t ON t.game_id = g.id INNER JOIN played_games pg ON pg.game_id = g.id INNER JOIN tournaments tour ON tour.game_id = g.id WHERE g.id = :game_id";
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':game_id', $game['id'], PDO::PARAM_INT);
                    $rep->execute();
                    $Basedata = $rep->fetch(PDO::FETCH_ASSOC);
                    ?>
                    <div class="tab_item">
                        <div class="item">
                            <?php echo $Basedata['player'] . " players play " . $game['title']; ?>
                        </div>
                        <div class="item">
                            <?php echo $Basedata['team'] . " teams play " . $game['title']; ?>
                        </div>
                        <div class="item">
                            <?php echo $Basedata['tournament'] . " " .  $game['title'] . " tournaments";  ?>
                        </div>
                    </div>
        </section>
</body>

</html>