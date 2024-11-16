<?php
session_start();
if (!isset($_SESSION['player_username'])) {
    header('Location: Login_user.php');
    exit();
}


$conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
$sql = "SELECT id FROM players WHERE username = :username";
$rep = $conn->prepare($sql);
$rep->bindParam(':username', $_SESSION['player_username'], PDO::PARAM_STR);
$rep->execute();
$_SESSION['id'] = $rep->fetchColumn();

?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Team_hub.css">
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
    <div class="content">
        <?php
        if (isset($_POST['team_id'])) {
            $sql = "SELECT COUNT(*) id FROM player_teams WHERE player_id = :player_id AND team_id = :team_id";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':player_id', $_SESSION['id'], PDO::PARAM_INT);
            $rep->bindParam(':team_id', $_POST['team_id'], PDO::PARAM_INT);
            $rep->execute();
            $Bool = $rep->fetchColumn();
            if ($Bool == 0) {
                $sql = "SELECT COUNT(*) id FROM team_request WHERE player_id = :player_id AND team_id = :team_id AND treated = 0";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':player_id', $_SESSION['id'], PDO::PARAM_INT);
                $rep->bindParam(':team_id', $_POST['team_id'], PDO::PARAM_INT);
                $rep->execute();
                $Bool = $rep->fetchColumn();
                if ($Bool == 0) {
                    $sql = "INSERT INTO team_request(player_id, team_id) VALUES (:player_id, :team_id)";
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':player_id', $_SESSION['id'], PDO::PARAM_INT);
                    $rep->bindParam(':team_id', $_POST['team_id'], PDO::PARAM_INT);
                    $rep->execute();
                    $Basedata = $rep->fetchAll();
                    echo "<div class='popup'><p>Your request has been sent </p></div>";
                } else {
                    echo "<div class='popup'> Your already request. wait </p></div>";
                }
            } else {
                echo "<div class='popup'><p>Your are already in the team</p></div>";
            }
        }
        ?>
        <section>
            <div class="Team_join">
                <div class="Tab">
                    <table>
                        <?php

                        $sql = "SELECT t.title, t.id, t.creator_id, t.game_id FROM teams t INNER JOIN player_teams pt ON pt.team_id = t.id INNER JOIN players p ON pt.player_id = p.id WHERE pt.player_id = :player_id";
                        $rep = $conn->prepare($sql);
                        $rep->bindParam(':player_id', $_SESSION['id'], PDO::PARAM_INT);
                        $rep->execute();
                        $Basedata = $rep->fetchAll();
                        ?>

                        <tr>
                            <th> ID </th>
                            <th> Name </th>
                            <th> Creator_id </th>
                            <th> Creator username </th>
                            <th> Game </th>
                            <th> Profile </th>
                        </tr>
                        <?php
                        foreach ($Basedata as $team): ?>
                            <tr>
                                <?php
                                echo "<td>" . htmlspecialchars($team['id']) . "</td>";
                                echo "<td>" . htmlspecialchars($team['title']) . "</td>";
                                echo "<td>" . htmlspecialchars($team['creator_id']) . "</td>";
                                $sql = "SELECT username FROM players WHERE id =:player_id";
                                $rep = $conn->prepare($sql);
                                $rep->bindParam(':player_id', $team['creator_id'], PDO::PARAM_INT);
                                $rep->execute();
                                $username = $rep->fetchColumn();

                                echo "<td>" . htmlspecialchars($username) . "</td>";
                                $sql = "SELECT g.title FROM games g INNER JOIN teams t ON t.game_id = g.id WHERE t.id = :team_id";
                                $rep = $conn->prepare($sql);
                                $rep->bindParam(':team_id', $team['id'], PDO::PARAM_INT);
                                $rep->execute();
                                $game = $rep->fetch();

                                echo "<td>" . htmlspecialchars($game['title']) . "</td>";

                                echo "<td><form method='POST' action='Team_profile.php'>
                                        <input type='submit' value='Profile' />
                                        <input type='hidden' name='team_id' value='" . $team['id'] . "' /> </form></td>";
                                ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </section>
        <section>
            <div class="Team_choices">
                <div class="Tab">
                    <table>
                        <?php
                        $valid_columns = ['team_id', 'team_title', 'creator_id', 'username', 'game_title'];
                        $order = "ASC";
                        if (isset($_POST['order'])) {
                            if ($_POST['order'] === 'desc') {
                                $order = 'DESC';
                            } else {
                                $order = 'ASC';
                            }
                        }

                        if (isset($_POST['sort'])) {
                            if (in_array($_POST['sort'], $valid_columns)) {
                                $sort = $_POST['sort'];
                            } else {
                                $sort = "team_id";
                            }
                        } else {
                            $sort = "team_id";
                        }

                        $sql = "SELECT DISTINCT t.title AS team_title, t.id AS team_id, t.creator_id, g.title AS game_title FROM teams t INNER JOIN player_teams pt ON pt.team_id = t.id INNER JOIN games g ON t.game_id = g.id  ORDER BY $sort $order";
                        $rep = $conn->prepare($sql);
                        $rep->execute();
                        $Basedata = $rep->fetchAll();
                        ?>
                        <tr>
                            <th><a href="?sort=team_id&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">ID </a></th>
                            <th><a href="?sort=team_title&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Name </a></th>
                            <th><a href="?sort=creator_id&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Creator ID </a></th>
                            <th><a href="?sort=username&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Creator username </a></th>
                            <th><a href="?sort=game_title&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Game </a></th>
                        </tr>
                        <?php foreach ($Basedata as $team): ?>
                            <tr>
                                <?php
                                echo "<td>" . htmlspecialchars($team['team_id']) . "</td>";
                                echo "<td>" . htmlspecialchars($team['team_title']) . "</td>";
                                echo "<td>" . htmlspecialchars($team['creator_id']) . "</td>";
                                $sql = "SELECT username FROM players WHERE id =:player_id";
                                $rep = $conn->prepare($sql);
                                $rep->bindParam(':player_id', $team['creator_id'], PDO::PARAM_INT);
                                $rep->execute();
                                $username = $rep->fetchColumn();

                                echo "<td>" . htmlspecialchars($username) . "</td>";
                                echo "<td>" . htmlspecialchars($team['game_title']) . "</td>";
                                echo " <td><form method='POST' action='Team_hub.php'>
                                        <input type='submit' value='Ask to Join' />
                                        <input type='hidden' name='team_id' value='" . $team['team_id'] . "' /> 
                                    </form></td>";

                                ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </section>
</body>

</html>