<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        header('Location: login_user.php');
        exit();
    }

    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    $sql = "SELECT id FROM players WHERE username = :username";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
    $rep->execute();
    $_SESSION['player_id'] = $rep->fetchColumn();

    $sql = "SELECT * FROM tournaments WHERE Name = :name";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':name', $_SESSION['tournament_name'], PDO::PARAM_STR);
    $rep->execute();
    $Tournament_basedata = $rep->fetch(PDO::FETCH_ASSOC);
    
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
    <?php
        if (isset($_GET['team_id'])) {
            $sql = "SELECT COUNT(*) id FROM player_tournament WHERE player_id = :player_id AND team_id = :team_id";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':player_id', $_SESSION['id'], PDO::PARAM_INT);
            $rep->bindParam(':team_id', $_GET['team_id'], PDO::PARAM_INT);
            $rep->execute();
            $Bool = $rep->fetchColumn();
            if($Bool == 0){
                $sql = "INSERT INTO tournament.request(player_id, team_id) VALUES (:player_id, :team_id)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':player_id', $_SESSION['id'], PDO::PARAM_INT);
                $rep->bindParam(':team_id', $_GET['team_id'], PDO::PARAM_INT);
                $rep->execute();
                $Basedata = $rep->fetchAll();
                echo "<div class='popup'><p>Your request has been sent </p></div>";
            }
            else{
                echo "<div class='popup'><p>Your are already in the team</p></div>";
            }
        }
    ?>
    <div class="Tournament_now">
        <div class="Tab">
            <table >
                <?php
                    $valid_columns_tournament = ['tournament_id', 'Name', 'creator_id','Match_system'];
                    $order_tournament_join = "ASC";
                    if(isset($_GET['order_tournament_join'])){
                        if ($_GET['order_tournament_join'] === 'desc'){
                            $order_tournament_join = 'DESC';
                        }
                        else{
                            $order_tournament_join = 'ASC';
                        }
                    } 
                    
                    if(isset($_GET['sort_tournament_join'])){
                        if(in_array($_GET['sort_tournament_join'], $valid_columns_tournament)){
                            $sort_tournament_join = $_GET['sort_tournament_join'];
                        }
                        else {
                            $sort_tournament_join = "t.id";
                        } 
                    }
                    else {
                        $sort_tournament_join = "t.id";
                    }

                    if($Tournament_basedata['participant'] == 1){
                        echo "coucou";
                        $sql = "SELECT t.Name, t.id, t.creator_id, t.Creation_Date, t.game_id, p.username, t.Match_system, t.Register_time FROM tournaments t INNER JOIN player_tournaments pt ON pt.tournament_id = t.id INNER JOIN players p ON pt.player_id = p.id WHERE pt.player_id = :player_id AND t.history=0 ORDER BY $sort_tournament_join $order_tournament_join";
                        $rep = $conn->prepare($sql);
                        $rep->bindParam(':player_id', $_SESSION['id'], PDO::PARAM_INT);
                        $rep->execute();
                        $Basedata = $rep->fetchAll();
                    }

                    if($Tournament_basedata['participant'] == 2){
                        echo "coucou2";
                        $sql ="SELECT t.Name, t.id, t.Creation_Date, t.creator_id, p.username, t.game_id, t.Match_system, t.Register_time FROM tournaments t INNER JOIN team_tournaments tt ON tt.tournament_id = t.id INNER JOIN player_teams pt ON pt.team_id = tt.team_id INNER JOIN players p ON pt.player_id = p.id WHERE t.history = 0 ORDER BY $sort_tournament_join $order_tournament_join";
                        $rep = $conn->prepare($sql);
                        $rep->bindParam(':player_id', $_SESSION['id'], PDO::PARAM_INT);
                        $rep->execute();
                        $Basedata = $rep->fetchAll();
                    }
                    foreach ($Basedata as $T) {
                        echo $T['id'];
                    }
                ?>

            <tr>
                <th><a href="?sort_tournament_join=tournament_id&order=<?= $order_tournament_join === 'ASC' ? 'desc' : 'asc' ?>">ID </a></th>
                <th><a href="?sort_tournament_join=Name&order=<?= $order_tournament_join === 'ASC' ? 'desc' : 'asc' ?>"> Tournament Name </a></th>
                <th><a href="?sort_tournament_join=Match_system&order=<?= $order_tournament_join === 'ASC' ? 'desc' : 'asc' ?>">Creator username </a></th>
                <th><a href="?sort_tournament_join=title&order=<?= $order_tournament_join === 'ASC' ? 'desc' : 'asc' ?>">Game </a></th>
                <th><a href="?sort_tournament_join=Match_system&order=<?= $order_tournament_join === 'ASC' ? 'desc' : 'asc' ?>">Match system </a></th> 
            </tr>
            <tr>
                <td> 
                    <?php 
                        foreach ($Basedata as $T) {
                            echo "<p>" . htmlspecialchars($T['id']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        foreach ($Basedata as $T) {
                            echo "<p>" . htmlspecialchars($T['Name']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        foreach ($Basedata as $T) {
                            echo "<p>" . htmlspecialchars($T['username']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php                      
                        foreach ($Basedata as $T) {
                            $valid_columns_game = ['title'];
                            $order_tournament_join = "ASC";
                            if(isset($_GET['order_tournament_join'])){
                                if ($_GET['order_tournament_join'] === 'desc'){
                                    $order_tournament_join = 'DESC';
                                }
                                else{
                                    $order_tournament_join = 'ASC';
                                }
                            } 
                            
                            if(isset($_GET['sort_tournament_join'])){
                                if(in_array($_GET['sort_tournament_join'], $valid_columns)){
                                    $sort_tournament_join = $_GET['sort_tournament_join'];
                                }
                                else {
                                    $sort_tournament_join = "g.id";
                                } 
                            }
                            else {
                                $sort_tournament_join = "g.id";
                            }

                            $sql = "SELECT g.title FROM games g INNER JOIN tournaments t ON t.game_id = g.id WHERE t.id = :tournament_id ORDER BY $sort_tournament_join $order_tournament_join";
                            $rep = $conn->prepare($sql);
                            $rep->bindParam(':tournament_id', $T['id'], PDO::PARAM_INT);
                            $rep->execute();
                            $game = $rep->fetch();
                
                            echo "<p>" . htmlspecialchars($game['title']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        foreach ($Basedata as $T):
                            if($T['Match_system'] == 1): ?>
                                <p> elimnation rounds </p>
                            <?php endif; 
                            if($T['Match_system'] == 2): ?>
                                <p> Swiss system </p>
                            <?php endif;
                            if($T['Match_system'] == 3): ?>
                                <p> league format </p>
                            <?php endif; endforeach; ?>                      
                </td>
                <td>
                    <?php 
                        foreach ($Basedata as $T) {

                            $creation_date = new DateTime($T['Creation_Date']);
                            $Register_time = $T['Register_time'];

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
                                $rep->bindParam(':tournament_id', $T['id'], PDO::PARAM_INT);
                                $rep->execute();
                            }
                            echo "<p>" . htmlspecialchars($remaining_time) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php
                        foreach ($Basedata as $T ){
                            echo "<form method='GET' action='Tournament_management.php'>
                                  <input type='submit' value='Tournament info' />
                                  <input type='hidden' name='tournament_id' value='" . $T['id'] . "' /> </form>";
                        }
                    ?>
                </td>
            </tr>
        </table></div></div>
    </div>
</div>
    <div class="Tournament_choices">
        <div class="Tab">
            <table >
                <?php
                    $valid_columns = ['tournament_id', 'tournament_Name', 'creator_id', 'title', 'Match_system'];
                    $order = "ASC";
                    if(isset($_GET['order'])){
                        if ($_GET['order'] === 'desc'){
                            $order = 'DESC';
                        }
                        else{
                            $order = 'ASC';
                        }
                    } 
                    
                    if(isset($_GET['sort'])){
                        if(in_array($_GET['sort'], $valid_columns)){
                            $sort = $_GET['sort'];
                        }
                        else {
                            $sort = "'team_id";
                        } 
                    }
                    else {
                        $sort = "team_id";
                    }
                    
                    $sql = "SELECT t.title AS team_title, t.id AS team_id, t.creator_id, p.username, g.title AS game_title FROM teams t INNER JOIN player_teams pt ON pt.team_id = t.id INNER JOIN players p ON pt.player_id = p.id INNER JOIN games g ON t.game_id = g.id  ORDER BY $sort $order";
                    $rep = $conn->prepare($sql);
                    $rep->execute();
                    $Basedata = $rep->fetchAll();
            ?>
            <tr>
                <th><a href="?sort=tournament_id&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">ID </a></th>
                <th><a href="?sort=tournament_Name&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Name </a></th>
                <th><a href="?sort=creator_id&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Creator ID </a></th>
                <th><a href="?sort=Match_system&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Creator username </a></th>
                <th><a href="?sort=game_title&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Game </a></th>     
            </tr>
            <tr>
                <td> 
                    <?php 
                        foreach ($Basedata as $team) {
                            echo "<p>" . htmlspecialchars($team['team_id']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        foreach ($Basedata as $team) {
                            echo "<p>" . htmlspecialchars($team['team_title']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        foreach ($Basedata as $team) {
                            echo "<p>" . htmlspecialchars($team['creator_id']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php
                        foreach ($Basedata as $team) {
                            echo "<p>" . htmlspecialchars($team['username']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php
                        foreach ($Basedata as $team) {
                            echo "<p>" . htmlspecialchars($team['game_title']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php
                        foreach ($Basedata as $team) {
                            echo "<form method='GET' action='Team_hub.php'>
                                    <input type='submit' value='Ask to Join' />
                                    <input type='hidden' name='team_id' value='" . $team['team_id'] . "' /> 
                                 </form>";
                        }
                    ?>
                </td>
            </tr>
            </table>
        </div>
    </div>
</body>
</html>
