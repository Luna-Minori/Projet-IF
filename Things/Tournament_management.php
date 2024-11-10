<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: Login_user.php');
        exit();
    }

    if (!isset($_GET['tournament_id'])) {
        header('Location: Tournament_hub.php');
        exit();
    }

    function round($tournament_participant, $round, $tournament){

        $Nparticipant = count($tournament_participant);
        if($Nparticipant == 0){
            return 0;
        }

        $temp = log($Nparticipant, 2);
        $entier = (int)$temp;
        if( $entier == $temp){
            $Powof2 = pow(2, $entier);
        }
        else{
            $Powof2 = pow(2, $entier + 1);
        }

        while($Nparticipant < $Powof2){
            $tournament_participant[] = -1;
        }
        shuffle($tournament_participant);
        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        for ($i = 0; $i < $Nparticipant; $i += 2) {
            
            if($tournament['participant'] == 1){
                $sql = "INSERT INTO player_match_tournaments(tournament_id, player1_id, player2_id, round) VALUES (:tournament_id, :player1_id, :player2_id, :round)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->bindParam(':player1_id', $tournament_participant[$i], PDO::PARAM_INT);
                $rep->bindParam(':player2_id', $tournament_participant[$i + 1], PDO::PARAM_INT);
                $rep->bindParam(':round', $round, PDO::PARAM_INT);                        
                $rep->execute();
            }
            else{
                $sql = "INSERT INTO team_match_tournaments(tournament_id, team1_id, team2_id, round) VALUES (:tournament_id, :player1_id, :player2_id, :round)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->bindParam(':team1_id', $tournament_participant[$i], PDO::PARAM_INT);
                $rep->bindParam(':team2_id', $tournament_participant[$i + 1], PDO::PARAM_INT);
                $rep->bindParam(':round', $round, PDO::PARAM_INT);                        
                $rep->execute();
            }
        }
    }

    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    $sql = "SELECT * FROM tournaments WHERE id = :id";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':id', $_GET['tournament_id'], PDO::PARAM_STR);
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
    } 
    else {
        $remaining_time = "Inscription fermée.";
        $sql = "UPDATE tournaments SET History = 1 WHERE id = :tournament_id";
        $rep = $conn->prepare($sql);
        $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
        $rep->execute();
    }

    if($tournament['rounds'] != -1 && ($remaining_time == "Inscription fermée." || $tournament['History'] == 1)){
        if($tournament['rounds']== 0){
            if($tournament['participant'] == 1){
                $sql = "SELECT player_id FROM player_tournaments WHERE tournaments_id = :tournament_id";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->execute();
                $tournament_participant = $rep->fetchAll(PDO::FETCH_COLUMN);
            }
            else{
                $sql = "SELECT team_id FROM team_tournaments WHERE tournaments_id = :tournament_id";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->execute();
                $tournament_participant = $rep->fetchAll(PDO::FETCH_COLUMN);
            }
            $Nparticipant = count($tournament_participant);
            round($tournament_participant, $tournament['round'], $tournament);
        }
        else{
            if($tournament['participant'] == 1){
                $sql = "SELECT COUNT(win) FROM player_match_tournaments WHERE tournaments_id = :tournament_id AND win = 0";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->execute();
                $checkround = $rep->fetch();
            }
            else{
                $sql = "SELECT COUNT(win) FROM team_match_tournaments WHERE tournaments_id = :tournament_id AND win = 0";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                $rep->execute();
                $checkround = $rep->fetch();
            }

            if($checkround == 0){
                    if($tournament['participant'] == 1){
                        $sql = "SELECT win FROM player_match_tournaments WHERE tournaments_id = :tournament_id AND win != 0 AND round = :round";
                        $rep = $conn->prepare($sql);
                        $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                        $rep->bindParam(':round', $tournament['round'], PDO::PARAM_STR);
                        $rep->execute();
                        $tournament_participant = $rep->fetchAll(PDO::FETCH_COLUMN);
                        round($tournament_participant, $tournament['round'], $tournament);
                }
                else{
                    $sql = "SELECT win FROM team_match_tournaments WHERE tournaments_id = :tournament_id AND win != 0 AND round = :round";
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':tournament_id', $tournament['id'], PDO::PARAM_INT);
                    $rep->bindParam(':round', $tournament['round'], PDO::PARAM_STR);
                    $rep->execute();
                    $tournament_participant = $rep->fetchAll(PDO::FETCH_COLUMN);
                    round($tournament_participant, $tournament['round'], $tournament);
                }
        }
    }
        if (isset($_GET['request_id'])) {
            if (isset($_GET['Update_request'])) {
                if ($_GET['Update_request'] == 1) {
                    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                    $sql = "INSERT INTO player_teams(player_id, team_id) VALUES ((SELECT player_id FROM request WHERE id = :request_id), :team_id)";  
                    $rep = $conn->prepare($sql);
                    $rep->bindParam(':request_id', $_GET['request_id'], PDO::PARAM_INT);
                    $rep->bindParam(':team_id', $_GET['team_id'], PDO::PARAM_INT);
                    $rep->execute();
                }
            }
            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
            $sql = "UPDATE request SET treated = 1 WHERE id = :request_id";
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
    <link rel="stylesheet" href="Team_profile.css">
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
    <div class="Box_section">
        <section class="Profile_Main">
        <?php   $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT * FROM tournaments WHERE id = :id";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':id', $_GET['tournament_id'], PDO::PARAM_STR);
                $rep->execute();
                $tournament = $rep->fetch(PDO::FETCH_ASSOC);
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
                    <?php echo "Username : " . $tournament['Name']; ?>
                </div>
                <div class="item">
                    <?php echo "creation_acc : " . $tournament['creation_date'];?>
                </div>
                <div class="item">
                    <?php echo "Bio : " . $tournament['bio'];?>
                <div class="item">
                    <?php
                            if($tournament['Match_system'] == 1): ?>
                                <p> elimnation rounds </p>
                            <?php endif; 
                            if($tournament['Match_system'] == 2): ?>
                                <p> Swiss system </p>
                            <?php endif;
                            if($tournament['Match_system'] == 3): ?>
                                <p> league format </p>
                            <?php endif; 
                    ?>    
                </div>
                <div class="item">
                    <?php echo "creation_acc : " . $tournament['creation_date'];?>
                </div>
                <div class="item">
                    <?php echo "Bio : " . $tournament['bio'];?>
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
                <tr>
                    <td>
                        <?php foreach ($Member as $M): ?>
                            <p>
                                <?php  
                                    if($M['Administrator'] == 1 ){
                                        echo 'Admin';
                                    } 
                                    else {
                                        if($M['is_substitue'] == 1){
                                            echo 'Substitue';
                                        }
                                        else{
                                            echo 'Member';
                                        }
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
                            <p><?php echo htmlspecialchars($M['games_tied']); ?></p>
                        <?php endforeach; ?>
                    </td>
                    <td>
                    <?php foreach ($Member as $M): ?>
                        <p><?php echo htmlspecialchars($M['games_won']); ?></p>
                    <?php endforeach; ?>
                    </td>
                    <td>
                        <?php foreach ($Member as $M): ?>
                            <p><?php echo htmlspecialchars($M['games_lost']); ?></p>
                        <?php endforeach; ?>
                    </td>
                </tr>
            </table>
        </div>
    </section>
    <section class="Team">
        <div class="information">
            <div class="Menu_info">
                <div class="sub_Title">Team</div>
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
                        if($r['treated'] == 0){
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
        <?php else:?>
            <p>No requests</p>
        <?php endif; ?>

            </section>
            </div>

        <a href=Main.php> Retour Main</a>
    </body>
</html>