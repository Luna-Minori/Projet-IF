<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: Login_user.php');
        exit();
    }

    if (!isset($_GET['team_id'])) {
        header('Location: Team_hub.php');
        exit();
    }
    
    if (isset($_GET['request_id'])) {
        if(isset($_GET['Update_request'])){
            if($_GET['Update_request'] == 1){
                $sql = "INSERT INTO player_teams(player_id, team_id VALUES (SELECT player_id FROM request WHERE id = :request_id), :team_id)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':request_id', $_GET['request_id'], PDO::PARAM_INT);
                $rep->bindParam(':team_id', $_GET['team_id'], PDO::PARAM_INT);
                $rep->execute();
            }
        }
        $sql = "DELETE FROM request WHERE request_id = :request_id";
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
                    <?php echo "creation_acc : " . $team['creation_date'];?>
                </div>
                <div class="item">
                    <?php echo "Bio : " . $team['bio'];?>
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
            $sql = "SELECT request.id AS request_id, request.Date AS request_Date, players.username FROM request INNER JOIN players ON players.id = request.player_id WHERE request.team_id = :team_id";
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
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($r['request_id']) . "</td>";
                        echo "<td>" . htmlspecialchars($r['username']) . "</td>";
                        echo "<td>" . htmlspecialchars($r['request_Date']) . "</td>";
                        echo "<td>" . " <form method='GET' action='Team_profile.php'>
                                        <input type='submit' value='Delete' />
                                        <input type='hidden' name='team_id' value='" . $team['id'] . "' /> </form>
                                        <input type='hidden' name='Update_request' value='0' /> </form>
                                        <input type='hidden' name='request_id' value='" . $r['request_id'] . "' /> </form>" .
                            "</td>";
                        echo "<td>" . " <form method='GET' action='Team_profile.php'>
                                        <input type='submit' value='Accept' />
                                        <input type='hidden' name='team_id' value='" . $team['id'] . "' /> </form>
                                        <input type='hidden' name='Update_request' value='1' /> </form>
                                        <input type='hidden' name='request_id' value='" . $r['request_id'] . "' /> </form>" .
                            "</td>";
                        echo "</tr>";
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