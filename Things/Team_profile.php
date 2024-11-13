<?php
session_start();
/*
if (!isset($_SESSION['player_username'])) {
    header('Location: Login_user.php');
    exit();
}

if (!isset($_GET['team_id'])) {
    header('Location: Team_hub.php');
    exit();
}
*/
if (isset($_GET['request_id'])) {
    if (isset($_GET['Update_request'])) {
        if ($_GET['Update_request'] == 1) {
            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
            $sql = "INSERT INTO player_teams(player_id, team_id) VALUES ((SELECT player_id FROM team_request WHERE id = :request_id), :team_id)";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':request_id', $_GET['request_id'], PDO::PARAM_INT);
            $rep->bindParam(':team_id', $_GET['team_id'], PDO::PARAM_INT);
            $rep->execute();
        }
    }
    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    $sql = "UPDATE team_request SET treated = 1 WHERE id = :request_id";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':request_id', $_GET['request_id'], PDO::PARAM_INT);
    $rep->execute();
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
    <div class="Box_section">
        <section class="Profile_Main">
            <?php $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
            $sql = "SELECT * FROM teams WHERE id = :id";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':id', $_GET['team_id'], PDO::PARAM_STR);
            $rep->execute();
            $team = $rep->fetch(PDO::FETCH_ASSOC);
            ?>
            <div class="information">
                <div class="Menu_info">
                    <div class="sub_Title">Information</div>
                    <div class="button">
                        <a href="Profile_user_upg.php"><img src="Image/Menu.png" class="img_button"></a>
                    </div>
                </div>
                <div class="tab_item">
                    <div class="item">
                        <?php echo "Username : " . $team['title']; ?>
                    </div>
                    <div class="item">
                        <?php echo "creation_acc : " . $team['creation_date']; ?>
                    </div>
                    <div class="item">
                        <?php echo "Bio : " . $team['bio']; ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="Member">
            <div class="information">
                <div class="Menu_info">
                    <div class="sub_Title">Member</div>
                    <div class="button">
                        <a href="Profile_user_upg.php"><img src="Image/Menu.png" class="img_button"></a>
                    </div>
                </div>

                <table class="Tab">
                    <?php
                    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                    $sql = "SELECT p.username, pt.Date_joined, pt.games_won, pt.games_lost, pt.games_tied, pt.Administrator, pt.is_substitue FROM players p INNER JOIN player_teams pt ON p.id = pt.player_id WHERE pt.team_id = :team_id ORDER BY pt.player_id";
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':team_id', $team['id'], PDO::PARAM_INT);
                    $rep->execute();
                    $Member = $rep->fetchAll(PDO::FETCH_ASSOC);
                    ?>
                    <tr>
                        <th> Roles </th>
                        <th> Username </th>
                        <th> Join Date </th>
                        <th> Game tied </th>
                        <th> Win </th>
                        <th> Lose </th>
                    </tr>
                    <?php foreach ($Member as $M): ?>
                        <tr>
                            <td>
                                <?php
                                if ($M['Administrator'] == 1) {
                                    echo 'Admin';
                                } else {
                                    if ($M['is_substitue'] == 1) {
                                        echo 'Substitue';
                                    } else {
                                        echo 'Member';
                                    }
                                }
                                ?>
                            </td>
                            <td><?php echo htmlspecialchars($M['username']); ?></td>
                            <td><?php echo htmlspecialchars($M['Date_joined']); ?></td>
                            <td><?php echo htmlspecialchars($M['games_tied']); ?></td>
                            <td><?php echo htmlspecialchars($M['games_won']); ?></td>
                            <td><?php echo htmlspecialchars($M['games_lost']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
        </section>
        <section class="History">
            <div class="information">
                <div class="Menu_info">
                    <div class="sub_Title">History</div>
                    <?php
                    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                    $sql = "SELECT t.*, tt.round FROM tournaments t INNER JOIN team_tournaments tt ON tt.tournament_id = t.id WHERE id = :team_id";
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':team_id', $_GET['team_id'], PDO::PARAM_INT);
                    $rep->execute();
                    $Tournaments = $rep->fetch(PDO::FETCH_ASSOC);
                    if (!empty($Tournaments)): ?>
                        <table class="Tab">
                            <tr>
                                <th> Name of tournament </th>
                                <th> Placement </th>
                                <th> Date </th>
                            </tr>
                            <?php foreach ($Tournaments as $T): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($T['Name']); ?></td>
                                    <td><?php echo htmlspecialchars($T['round']); ?></td>
                                    <td><?php echo htmlspecialchars($T['Creation_Date']); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        <?php echo "You never participated in a tournament"; ?>
                    <?php endif; ?>

        </section>

        <section class="request">
            <div class="information">
                <div class="Menu_info">
                    <div class="sub_Title">Request</div>
                    <div class="Menu_info">
                        <?php
                        $sql = "SELECT tr.id AS request_id, tr.Date AS request_Date, tr.treated, players.username FROM team_request tr INNER JOIN players ON players.id = tr.player_id WHERE tr.team_id = :team_id";
                        $rep = $conn->prepare($sql);
                        $rep->bindParam(':team_id', $team['id'], PDO::PARAM_INT);
                        $rep->execute();
                        $requests = $rep->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                        <?php if ($requests): ?>
                            <table class="Tab">
                                <tr>
                                    <th> ID request </th>
                                    <th> Username </th>
                                    <th> Date </th>
                                </tr>
                                <?php
                                foreach ($requests as $r) {
                                    if ($r['treated'] == 0) {
                                        echo "<tr>";
                                        echo "<td>" . htmlspecialchars($r['request_id']) . "</td>";
                                        echo "<td>" . htmlspecialchars($r['username']) . "</td>";
                                        echo "<td>" . htmlspecialchars($r['request_Date']) . "</td>";
                                        echo "<td>" . " <form method='GET' action='Team_profile.php'>
                                        <input type='submit' value='Delete' />
                                        <input type='hidden' name='team_id' value='" . $team['id'] . "' />
                                        <input type='hidden' name='Update_request' value='0' />
                                        <input type='hidden' name='request_id' value='" . $r['request_id'] . "' /> </form>" .
                                            "</td>";
                                        echo "<td>" . " <form method='GET' action='Team_profile.php'>
                                        <input type='submit' value='Accept' />
                                        <input type='hidden' name='team_id' value='" . $team['id'] . "' />
                                        <input type='hidden' name='Update_request' value='1' />
                                        <input type='hidden' name='request_id' value='" . $r['request_id'] . "' /> </form>" .
                                            "</td>";
                                        echo "</tr>";
                                    }
                                }
                                ?>
                            </table>
                        <?php else: ?>
                            <p>No requests</p>
                        <?php endif; ?>

        </section>
    </div>

    <a href=Main.php> Retour Main</a>
</body>

</html>