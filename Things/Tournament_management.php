<?php
session_start();
if (!isset($_SESSION['player_username'])) {
    header('Location: Login_user.php');
    exit();
}

if (!isset($_POST['tournament_id'])) {
    header('Location: Tournament_hub.php');
    exit();
}

function generate_round($tournament_participant, $round, $tournament)
{

    $Nparticipant = count($tournament_participant);
    if ($Nparticipant == 0) {
        return 0;
    }

    $temp = log($Nparticipant, 2);
    $entier = (int)$temp;
    if ($entier == $temp) {
        $Powof2 = pow(2, $entier);
    } else {
        $Powof2 = pow(2, $entier + 1);
    }

    while ($Nparticipant < $Powof2) {
        $tournament_participant[] = -1;
    }
    shuffle($tournament_participant);
    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    for ($i = 0; $i < $Nparticipant; $i += 2) {

        if ($tournament['participant'] == 1) {
            $sql = "INSERT INTO player_match_tournaments(tournament_id, player1_id, player2_id, round) VALUES (:tournament_id, :player1_id, :player2_id, :round)";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
            $rep->bindParam(':player1_id', $tournament_participant[$i], PDO::PARAM_INT);
            $rep->bindParam(':player2_id', $tournament_participant[$i + 1], PDO::PARAM_INT);
            $rep->bindParam(':round', $round, PDO::PARAM_INT);
            $rep->execute();
        } else {
            $sql = "INSERT INTO team_match_tournaments(tournament_id, team1_id, team2_id, round) VALUES (:tournament_id, :player1_id, :player2_id, :round)";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
            $rep->bindParam(':team1_id', $tournament_participant[$i], PDO::PARAM_INT);
            $rep->bindParam(':team2_id', $tournament_participant[$i + 1], PDO::PARAM_INT);
            $rep->bindParam(':round', $round, PDO::PARAM_INT);
            $rep->execute();
        }
    }
    $sql = "UPDATE tournaments SET tournament_tree = 1 WHERE id = :tournament_id";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
    $rep->execute();
}

$conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
$sql = "SELECT * FROM tournaments WHERE id = :id";
$rep = $conn->prepare($sql);
$rep->bindParam(':id', $_POST['tournament_id'], PDO::PARAM_STR);
$rep->execute();
$tournament = $rep->fetch(PDO::FETCH_ASSOC);
$creation_date = new DateTime($tournament['Creation_Date']);
$Register_time = $tournament['Register_time'];

$End_date = $creation_date;
$Between = new DateInterval('PT' . $Register_time . 'S');
$End_date->add($Between);

$Now = new DateTime();
$Between = $Now->diff($End_date);

if ($Now < $End_date) {
    $remaining_time = $Between->format('%a days %h Hours %i minutes');
} else {
    $remaining_time = "Register close";
    $sql = "UPDATE tournaments SET History = 1 WHERE id = :tournament_id";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
    $rep->execute();
}

if ($tournament['round'] != -1 && ($remaining_time == "Register close" || $tournament['History'] == 1)) {
    if ($tournament['round'] == 0 && $tournament['tournament_tree'] == 0) {
        if ($tournament['participant'] == 1) {
            $sql = "SELECT player_id FROM player_tournaments WHERE tournament_id = :tournament_id";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
            $rep->execute();
            $tournament_participant = $rep->fetchAll(PDO::FETCH_COLUMN);
        } else {
            $sql = "SELECT team_id FROM team_tournaments WHERE tournaments_id = :tournament_id";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
            $rep->execute();
            $tournament_participant = $rep->fetchAll(PDO::FETCH_COLUMN);
        }
        $Nparticipant = count($tournament_participant);
        generate_round($tournament_participant, $tournament['round'], $tournament);
    } else {
        if ($tournament['tournament_tree'] == 0) {
            echo "je suis la 1 ";
            if ($tournament['participant'] == 1) {
                $sql = "SELECT win FROM player_match_tournaments WHERE tournament_id = :tournament_id AND win != null AND round = :round";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->bindParam(':round', $tournament['round'], PDO::PARAM_STR);
                $rep->execute();
                $tournament_participant = $rep->fetchAll(PDO::FETCH_COLUMN);

                foreach ($tournament_participant as $T) {
                    $sql = "UPDATE player_tournaments SET round = :round WHERE tournament_id = :tournament_id AND player_id =:player_id";
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                    $rep->bindParam(':player_id', $T['win'], PDO::PARAM_INT);
                    $rep->bindParam(':round', $round, PDO::PARAM_STR);
                    $rep->execute();
                }

                echo "valeurs" . count($tournament_participant);
                if (count($tournament_participant) != 1) {
                    generate_round($tournament_participant, $tournament['round'], $tournament);
                } else {
                    echo "GG";
                    $sql = "UPDATE tournaments SET History = 2 WHERE id = :tournament_id";
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                    $rep->execute();
                }
            } else {
                $sql = "SELECT win FROM team_match_tournaments WHERE tournaments_id = :tournament_id AND win != 0 AND round = :round";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->bindParam(':round', $tournament['round'], PDO::PARAM_STR);
                $rep->execute();
                $tournament_participant = $rep->fetchAll(PDO::FETCH_COLUMN);
                generate_round($tournament_participant, $tournament['round'], $tournament);
            }
        } else {
            if ($tournament['participant'] == 1) {
                $sql = "SELECT player1_id, player2_id, win FROM player_match_tournaments WHERE tournament_id =:tournament_id AND round =:round";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->bindParam(':round', $tournament['round'], PDO::PARAM_INT);
                $rep->execute();
                $Pmatch = $rep->fetchAll(PDO::FETCH_ASSOC);

                $winner = null;
                foreach ($Pmatch as $P) {
                    if ($P['win'] == null) {
                        if ($P['player1_id'] != null && $P['player2_id'] == null) {
                            $winner = $P['player1_id'];
                        } elseif ($P['player1_id'] == null && $P['player2_id'] != null) {
                            $winner = $P['player2_id'];
                        } else {
                            $winner = null;
                        }
                    }
                }
                echo "je suis la 2 ";
                $sql = "UPDATE player_match_tournaments SET win = :winner WHERE tournament_id = :tournament_id AND round =:round";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->bindParam(':round', $tournament['round'], PDO::PARAM_INT);
                $rep->bindParam(':winner', $winner, PDO::PARAM_INT);
                $rep->execute();

                $sql = "SELECT COUNT(win) FROM player_match_tournaments WHERE tournament_id = :tournament_id AND win = null";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->execute();
                $check = $rep->fetch(PDO::FETCH_ASSOC);
            }
            if ($tournament['participant'] == 2) {
                $sql = "SELECT player1_id, player2_id, win FROM player_match_tournaments WHERE tournament_id =:tournament_id AND round =:round";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->bindParam(':round', $tournament['round'], PDO::PARAM_INT);
                $rep->execute();
                $Pmatch = $rep->fetchAll(PDO::FETCH_ASSOC);

                $winner = null;
                foreach ($Pmatch as $P) {
                    if ($P['win'] == null) {
                        if ($P['player1_id'] != null && $P['player2_id'] == null) {
                            $winner = $P['player1_id'];
                        } elseif ($P['player1_id'] == null && $P['player2_id'] != null) {
                            $winner = $P['player2_id'];
                        } else {
                            $winner = null;
                        }
                    }
                }

                $sql = "UPDATE player_match_tournaments SET win = :winner WHERE tournament_id = :tournament_id AND round =:round";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->bindParam(':round', $tournament['round'], PDO::PARAM_INT);
                $rep->bindParam(':winner', $winner, PDO::PARAM_INT);
                $rep->execute();

                $sql = "SELECT COUNT(win) FROM player_match_tournaments WHERE tournament_id = :tournament_id AND win = null";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->execute();
                $checkround = $rep->fetch();
            }
            if ($check['COUNT(win)'] == 0) {
                echo "je suis la 3";
                $round = $tournament['id'] + 1;
                echo $round;
                $sql = "UPDATE tournaments SET tournament_tree = 0, round = :round WHERE id = :tournament_id";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->bindParam(':round', $round, PDO::PARAM_INT);
                $rep->execute();

                $sql = "SELECT win FROM player_match_tournaments WHERE tournament_id = :tournament_id AND win != null AND round = :round";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->bindParam(':round', $tournament['round'], PDO::PARAM_STR);
                $rep->execute();
                $tournament_participant = $rep->fetchAll(PDO::FETCH_COLUMN);

                foreach ($tournament_participant as $T) {
                    $sql = "UPDATE player_tournaments SET round = :round WHERE tournament_id = :tournament_id AND player_id =:player_id";
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                    $rep->bindParam(':player_id', $T['win'], PDO::PARAM_INT);
                    $rep->bindParam(':round', $round, PDO::PARAM_STR);
                    $rep->execute();
                }
            }
        }
    }
}

if (isset($_POST['request_id'])) {
    if (isset($_POST['Update_request'])) {
        if ($_POST['Update_request'] == 1) {
            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');

            $sql = "SELECT game_id FROM tournaments WHERE id = :tournament_id";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':tournament_id', $_POST['tournament_id'], PDO::PARAM_INT);
            $rep->execute();
            $game = $rep->fetchColumn();

            $sql = "SELECT COUNT(player_id) FROM played_games WHERE player_id = (SELECT player_id FROM team_request WHERE id = :request_id) AND game_id = :game_id";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':request_id', $_POST['request_id'], PDO::PARAM_INT);
            $rep->bindParam(':game_id', $game, PDO::PARAM_INT);
            $rep->execute();
            $number = $rep->fetchColumn();

            if ($number == 0) {
                $sql = "INSERT INTO played_games(player_id, game_id) VALUES ((SELECT player_id FROM tournament_request WHERE id = :request_id), :game_id)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':game_id', $game, PDO::PARAM_INT);
                $rep->bindParam(':request_id', $_POST['request_id'], PDO::PARAM_INT);
                $rep->execute();
            }

            $sql = "INSERT INTO player_tournaments(player_id, tournament_id) VALUES ((SELECT player_id FROM tournament_request WHERE id = :request_id), :tournament_id)";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':request_id', $_POST['request_id'], PDO::PARAM_INT);
            $rep->bindParam(':tournament_id', $_POST['tournament_id'], PDO::PARAM_INT);
            $rep->execute();
        }
    }
    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    $sql = "UPDATE tournament_request SET treated = 1 WHERE id = :request_id";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':request_id', $_POST['request_id'], PDO::PARAM_INT);
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
        <div class="Box_section">
            <section class="Profile_Main">
                <?php $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT * FROM tournaments WHERE id = :id";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':id', $_POST['tournament_id'], PDO::PARAM_STR);
                $rep->execute();
                $tournament = $rep->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="information">
                    <div class="Menu_info">
                        <div class="sub_Title">Information</div>
                        <div class="button">
                            <a href="Tournament_management_upg.php"><img src="Image/Menu.png" class="img_button"></a>
                        </div>
                    </div>
                    <div class="tab_item">
                        <div class="item">
                            <?php echo "Name : " . $tournament['Name']; ?>
                        </div>
                        <div class="item">
                            <?php echo "create the : " . $tournament['Creation_Date']; ?>
                        </div>
                        <?php
                        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                        $sql = "SELECT title, rules FROM games WHERE id = :id";
                        $rep = $conn->prepare($sql);
                        $rep->bindParam(':id', $tournament['game_id'], PDO::PARAM_INT);
                        $rep->execute();
                        $game = $rep->fetch(PDO::FETCH_ASSOC);

                        ?>
                    </div>
                    <div class="tab_item">
                        <div class="item">
                            <?php echo "Game : " . $game['title']; ?>
                        </div>
                        <div class="item">
                            <?php echo "Rules of game : " . $game['rules']; ?>
                        </div>
                        <div class="item">
                            <?php echo "Specific rules of tournament : " . $tournament['Rules']; ?>
                        </div>
                        <div class="item">
                            <?php
                            if ($tournament['Match_system'] == 1): ?>
                                <p> elimnation rounds </p>
                            <?php endif;
                            if ($tournament['Match_system'] == 2): ?>
                                <p> Swiss system </p>
                            <?php endif;
                            if ($tournament['Match_system'] == 3): ?>
                                <p> league format </p>
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
                </div>
            </section>
            <section class="Member">
                <div class="information">
                    <div class="Menu_info">
                        <div class="sub_Title">Member</div>
                        <div class="button">
                            <?php $_SESSION['tournament_id'] = $tournament['id']; ?>
                            <a href="Tournament_management_upg.php"><img src="Image/Menu.png" class="img_button"></a>
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
                        <?php foreach ($Member as $M): ?>
                            <tr>
                                <?php
                                if ($M['Administrator'] == 2) {
                                    echo '<td>Creator</td>';
                                }
                                if ($M['Administrator'] == 1) {
                                    echo '<td>Admin</td>';
                                }
                                if ($M['Administrator'] == 0) {
                                    echo '<td>Member</td>';
                                }
                                echo "<td> " . htmlspecialchars($M['username']) . "</td>";
                                echo "<td> " . htmlspecialchars($M['Date_joined']) . "</td>";
                                echo "<td> " . htmlspecialchars($M['round']) . "</td>";
                                ?>
                            </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </section>
            <section class="Match">
                <div class="information">
                    <div class="Menu_info">
                        <div class="sub_Title">Match</div>
                    </div>
                    <?php if ($tournament['History'] != 0): ?>
                        <table class="Tab">
                            <?php
                            if ($tournament['participant'] == 1) {

                                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                                $sql = "SELECT p1.username AS player1_username, p2.username AS player2_username, pmt.round, pmt.id, pmt.win, pmt.player1_id, pmt.player2_id FROM player_match_tournaments pmt INNER JOIN players p1 ON pmt.player1_id = p1.id INNER JOIN players p2 ON pmt.player2_id = p2.id WHERE pmt.tournament_id = :tournament_id AND pmt.round = :round ORDER BY pmt.round ASC";
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
                                $Member = $rep->fetchAll(PDO::FETCH_ASSOC);
                            }

                            ?>
                            <tr>
                                <th> ID </th>
                                <th> round </th>
                                <th> Player1 </th>
                                <th> Player2 </th>
                                <th> win </th>
                            </tr>

                            <?php foreach ($Match as $M): ?>
                                <tr>
                                    <td>
                                        <p><?php echo htmlspecialchars($M['id']); ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo htmlspecialchars($M['round']); ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo htmlspecialchars($M['player1_username']); ?></p>
                                    </td>
                                    <td>
                                        <p><?php echo htmlspecialchars($M['player2_username']); ?></p>
                                    </td>
                                    <td>
                                        <?php
                                        if ($M['win'] == $M['player1_id']): ?>
                                            <p><?php echo htmlspecialchars($M['player1_username']); ?></p>
                                        <?php endif;
                                        if ($M['win'] == $M['player2_id']): ?>
                                            <p><?php echo htmlspecialchars($M['player2_username']); ?></p>
                                        <?php endif;
                                        if ($M['win'] == $M['player2_id']) {
                                            echo "the match was not played";
                                        } ?>
                                    </td>
                                <?php endforeach; ?>
                        </table>
                    <?php else: ?>
                        <p>Wait for the register time</p>
                    <?php endif; ?>
                </div>
            </section>
            <section class="request">
                <div class="information">
                    <div class="Menu_info">
                        <div class="sub_Title">Request</div>
                    </div>
                </div>
                <?php if ($tournament['History'] == 0): ?>
                    <?php
                    $sql = "SELECT tr.id AS request_id, tr.Date AS request_Date, tr.treated, players.username FROM tournament_request tr INNER JOIN players ON players.id = tr.player_id WHERE tr.treated = 0 AND tr.tournament_id = :tournament_id";
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
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
                                    if ($tournament['participant'] == 1) {
                                        echo "<td>" . " <form method='POST' action='Tournament_management.php'>
                                                <input type='submit' value='Delete' />
                                                <input type='hidden' name='Update_request' value='0' />
                                                <input type='hidden' name='tournament_id' value='" . $tournament['id'] . "' />
                                                <input type='hidden' name='request_id' value='" . $r['request_id'] . "' /> </form>" .
                                            "</td>";
                                        echo "<td>" . " <form method='POST' action='Tournament_management.php'>
                                                <input type='submit' value='Accept' />
                                                <input type='hidden' name='Update_request' value='1' />
                                                <input type='hidden' name='tournament_id' value='" . $tournament['id'] . "' />
                                                <input type='hidden' name='request_id' value='" . $r['request_id'] . "' /> </form>" .
                                            "</td>";
                                        echo "</tr>";
                                    } else {
                                        echo "<td>" . " <form method='POST' action='Team_tournament_request.php'>
                                                <input type='submit' value='Delete' />
                                                <input type='hidden' name='team_id' value='" . $team['id'] . "' />
                                                <input type='hidden' name='Update_request' value='1' />
                                                <input type='hidden' name='tournament_id' value='" . $tournament['id'] . "' />
                                                <input type='hidden' name='request_id' value='" . $r['request_id'] . "' /> </form>" .
                                            "</td>";
                                        echo "<td>" . " <form method='POST' action='Team_tournament_request.php'>
                                                <input type='submit' value='Accept' />
                                                <input type='hidden' name='team_id' value='" . $team['id'] . "' />
                                                <input type='hidden' name='Update_request' value='2' />
                                                <input type='hidden' name='tournament_id' value='" . $tournament['id'] . "' />
                                                <input type='hidden' name='request_id' value='" . $r['request_id'] . "' /> </form>" .
                                            "</td>";
                                        echo "</tr>";
                                    }
                                }
                            }
                            ?>
                        </table>
                    <?php else: ?>
                        <p>No requests</p>
                    <?php endif; ?>
                <?php endif; ?>
            </section>
        </div>
    </div>
</body>

</html>