<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('Location: Login_user.php');
    exit();
}

if (!isset($_SESSION['tournament_id'])) {
    header('Location: Tournament_hub.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['Form'] == 1) {
        $Name = $_POST['Name_tournament'];
        $Rules = $_POST['Rules_tournament'];

        if (empty($Name)) {
            header('Location: Tournament_management_upg.php');
            exit();
        }

        if (empty($Rules)) {
            $Rules = null;
        }

        try {
            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
            $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $sql = "SELECT * FROM tournaments";
            $rep = $conn->prepare($sql);
            $rep->execute();

            $bool = false;
            while ($Basedata = $rep->fetch(PDO::FETCH_ASSOC)) {
                if ($Basedata['id'] != $_SESSION['tournament_id'] && $Basedata['Name'] == $Name) {
                    echo "This tournament name is already in use.";
                    $bool = true;
                    break;
                }
            }

            if ($bool == false) {
                $sql = "UPDATE tournaments SET Name = :Name, Rules = :Rules WHERE id = :id";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':Name', $Name, PDO::PARAM_STR);
                $rep->bindParam(':Rules', $Rules, PDO::PARAM_STR);
                $rep->bindParam(':id', $_SESSION['tournament_id'], PDO::PARAM_INT);
                $rep->execute();
            }
        } catch (PDOException $e) {
            echo 'Database error: ' . $e->getMessage();
            exit();
        }

        header('Location: Tournament_management_upg.php');
        exit();
    } elseif ($_POST['Form'] == 2) {
        $match_id = $_POST['match_id'];
        $winner = $_POST['Winner_username'];

        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $sql = "SELECT * FROM player_match_tournaments WHERE id=:match_id";
        $rep = $conn->prepare($sql);
        $rep->bindParam(':id', $match_id, PDO::PARAM_INT);
        $rep->execute();
        $Match = $rep->fetch(PDO::FETCH_ASSOC);

        if ($Match['player1_id'] == $winner || $Match['player2_id'] == $winner) {
            $sql = "SELECT id FROM players WHERE username=:username";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':username', $winner, PDO::PARAM_STR);
            $rep->execute();
            $id = $rep->fetch();
            if (isset($id)) {
                if ($Match == 0) {
                    $sql = "UPDATE player_match_tournaments SET win = :winner WHERE id = :id";
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':winner', $winner, PDO::PARAM_INT);
                    $rep->bindParam(':id', $match_id, PDO::PARAM_INT);
                    $rep->execute();
                }
            }
            header('Location: Tournament_management_upg.php');
            exit();
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
    <section>
        <div class="Box_section">
            <section class="Profile_Main">
                <?php $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT * FROM tournaments WHERE id = :id";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':id', $_SESSION['tournament_id'], PDO::PARAM_STR);
                $rep->execute();
                $tournament = $rep->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="information">
                    <div class="Menu_info">
                        <div class="sub_Title">Information</div>
                    </div>
                    <form method="POST" action="Tournament_management_upg.php">
                        <div class="tab_item">
                            <div class="item">
                                <p> Name : </p>
                                <input type="text" name="Name_tournament" value="<?php echo htmlspecialchars($tournament['Name'] ?? ''); ?>">
                            </div>
                            <?php
                            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                            $sql = "SELECT title, rules FROM games WHERE id = :id";
                            $rep = $conn->prepare($sql);
                            $rep->bindParam(':id', $tournament['game_id'], PDO::PARAM_INT);
                            $rep->execute();
                            $game = $rep->fetch(PDO::FETCH_ASSOC);

                            ?>
                            <div class="item">
                                <?php echo "Game : " . $game['title']; ?>
                            </div>
                            <div class="item">
                                <?php echo "Rules of game : " . $game['rules']; ?>
                            </div>
                            <div class="item">
                                <p> Specific rules of tournament : </p>
                                <input type="text" name="Rules_tournament" value="<?php echo htmlspecialchars($tournament['Rules'] ?? ''); ?>">
                            </div>
                            <div class="item">
                                <?php
                                if ($tournament['Match_system'] == 1): ?>
                                    <p> Elimnation rounds </p>
                                <?php endif;
                                if ($tournament['Match_system'] == 2): ?>
                                    <p> Swiss system </p>
                                <?php endif;
                                if ($tournament['Match_system'] == 3): ?>
                                    <p> League format </p>
                                <?php endif;
                                ?>
                            </div>
                            <div class="item">
                                <?php
                                if ($tournament['participant'] == 1): ?>
                                    <p> Type of participant : Singleplayer </p>
                                <?php endif;
                                if ($tournament['participant'] == 2): ?>
                                    <p> Type of participant : Team </p>
                                <?php endif; ?>
                            </div>
                        </div>
                        <input class="button" type="hidden" name="Form" value="1">
                        <input class="button" type="submit" name="condition" value="Valid" required>
                    </form>
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
                        if ($tournament['participant'] == 1) {
                            $sql = "SELECT pt.player_id, pt.Date_joined, pt.Administrator, pt.round, p.username FROM player_tournaments pt INNER JOIN players p ON pt.player_id = p.id WHERE pt.tournament_id = :tournament_id ORDER BY pt.Administrator";
                            $rep = $conn->prepare($sql);
                            $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                            $rep->execute();
                            $Member = $rep->fetchAll(PDO::FETCH_ASSOC);
                        } else {
                            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                            $sql = "SELECT p.username, pt.Date_joined, pt.Administrator, pt.is_substitue FROM players p INNER JOIN player_teams pt ON p.id = pt.player_id WHERE pt.team_id = :team_id ORDER BY pt.player_id";
                            $rep = $conn->prepare($sql);
                            $rep->bindParam(':team_id', $team['id'], PDO::PARAM_INT);
                            $rep->execute();
                            $Member = $rep->fetchAll(PDO::FETCH_ASSOC);
                        }

                        ?>
                        <tr>
                            <th> Roles </th>
                            <th> Username </th>
                            <th> Join Date </th>
                            <th> round </th>
                        </tr>
                        <tr>
                            <td>
                                <?php foreach ($Member as $M): ?>
                                    <p>
                                        <?php
                                        if ($M['Administrator'] == 2) {
                                            echo 'Creator';
                                        }
                                        if ($M['Administrator'] == 1) {
                                            echo 'Admin';
                                        }
                                        if ($M['Administrator'] == 0) {
                                            echo 'Member';
                                        }
                                        ?>
                                    </p>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach ($Member as $M): ?>
                                    <p><?php echo htmlspecialchars($M['username']); ?></p>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach ($Member as $M): ?>
                                    <p><?php echo htmlspecialchars($M['Date_joined']); ?></p>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach ($Member as $M): ?>
                                    <p><?php echo htmlspecialchars($M['round']); ?></p>
                                <?php endforeach; ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
            <section class="Match">
                <div class="information">
                    <div class="Menu_info">
                        <div class="sub_Title">Match</div>
                    </div>
                    <table class="Tab">
                        <?php
                        if ($tournament['participant'] == 1) {

                            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                            $sql = "SELECT * FROM player_match_tournaments WHERE tournament_id = :tournament_id AND round = :round ORDER BY round ASC";
                            $rep = $conn->prepare($sql);
                            $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                            $rep->bindParam(':round', $tournament['round'], PDO::PARAM_INT);
                            $rep->execute();
                            $Match = $rep->fetchAll(PDO::FETCH_ASSOC);
                        } else {
                            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                            $sql = "SELECT p.username, pt.Date_joined, pt.Administrator, pt.is_substitue FROM players p INNER JOIN player_teams pt ON p.id = pt.player_id WHERE pt.team_id = :team_id ORDER BY pt.player_id";
                            $rep = $conn->prepare($sql);
                            $rep->bindParam(':team_id', $team['id'], PDO::PARAM_INT);
                            $rep->execute();
                            $Match = $rep->fetchAll(PDO::FETCH_ASSOC);
                        }

                        ?>
                        <tr>
                            <th> ID </th>
                            <th> round </th>
                            <th> Player1 </th>
                            <th> Player2 </th>
                            <th> win </th>
                        </tr>
                        <tr>
                            <td>
                                <?php foreach ($Match as $M): ?>
                                    <p><?php echo htmlspecialchars($M['id']); ?></p>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach ($Member as $M): ?>
                                    <p><?php echo htmlspecialchars($M['round']); ?></p>
                                <?php endforeach; ?>
                            </td>
                            <td>
                                <?php foreach ($Member as $M) {

                                    $sql = "SELECT username FROM players WHERE id = :id";
                                    $rep = $conn->prepare($sql);
                                    $rep->bindParam(':id', $Match['player1_id'], PDO::PARAM_INT);
                                    $rep->execute();
                                    $username = $rep->fetch();
                                    echo htmlspecialchars($username);
                                }
                                ?>
                            </td>
                            <td>
                                <?php foreach ($Member as $M) {
                                    if (empty($M['player2_username'])) {
                                        echo "";
                                    }
                                    if (!empty($M['player2_username'])) {
                                        echo htmlspecialchars($M['player1_username']);
                                    }
                                }
                                ?>
                            </td>
                            <td>
                                <?php foreach ($Member as $M):
                                    if ($M['win'] == $M['player1_id']): ?>
                                        <p><?php echo htmlspecialchars($M['player1_username']); ?></p>
                                    <?php endif;
                                    if ($M['win'] == $M['player2_id']): ?>
                                        <p><?php echo htmlspecialchars($M['player2_username']); ?></p>
                                <?php endif;
                                    if ($M['win'] == $M['player2_id']) {
                                        echo "the match was not played";
                                    }
                                endforeach;
                                ?>
                            </td>
                        </tr>
                    </table>
                </div>
            </section>
            <section class="insert">
                <div class="information">
                    <div class="Menu_info">
                        <div class="sub_Title">Request</div>
                    </div>
                    <form method="POST" action="Tournament_management_upg.php">
                        <div class="tab_item">
                            <div class="item">
                                <p> ID of match</p>
                                <input type="text" name="match_id" value="">
                            </div>
                            <div class="item">
                                <p> Username of winner</p>
                                <input type="text" name="Winner_username" value="">
                            </div>
                            <input class="button" type="hidden" name="Form" value="2">
                            <input class="button" type="submit" name="condition" value="Valid" required>
                    </form>
                </div>
            </section>
            <section class="History">

            </section>
            <section class="request">
                <div class="information">
                    <div class="Menu_info">
                        <div class="sub_Title">Request</div>
                        <div class="Menu_info">
                            <?php
                            $sql = "SELECT request.id AS request_id, request.Date AS request_Date, request.treated, players.username FROM request INNER JOIN players ON players.id = request.player_id WHERE request.team_id = :team_id";
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