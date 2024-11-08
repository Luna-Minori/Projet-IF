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
    <div class="Team_join">
        <div class="Tab">
            <table >
                <?php
                    $valid_columns = ['id', 'Name', 'creator_id', 'game_id', 'Match_system', 'Register_time'];
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

                    if($Tournament_basedata['participant'] == 1){
                        $sql = "SELECT t.Name, t.id, t.creator_id, t.game_id, p.username, t.Match_system, t.Register_time FROM tournaments t INNER JOIN player_tournaments pt ON pt.tournament_id = t.id INNER JOIN players p ON pt.player_id = p.id WHERE pt.player_id = :player_id AND t.history=0";
                        $rep = $conn->prepare($sql);
                        $rep->bindParam(':player_id', $_SESSION['id'], PDO::PARAM_INT);
                        $rep->execute();
                        $Basedata = $rep->fetchAll();
                    }

                    if($Tournament_basedata['participant'] == 2){
                        $sql = "SELECT t.title, t.id, t.creator_id, t.game_id, tt.title AS Team_name, t..Match_system, t.Register_time FROM tournaments t INNER JOIN team_tournaments tt ON tt.tournament_id = t.id INNER JOIN player_teams pt ON pt.team_id = tt.team_id INNER JOIN  players p ON pt.player_id = p.id WHERE pt.player_id = :player_id AND t.history=0";
                        $rep = $conn->prepare($sql);
                        $rep->bindParam(':player_id', $_SESSION['id'], PDO::PARAM_INT);
                        $rep->execute();
                        $Basedata = $rep->fetchAll();
                    }

                ?>

            <tr>
                <th> ID </th>
                <th> Tournament Name </th>
                <th> Creator_id </th>
                <th> Creator username </th>
                <th> Game </th>
                <th> Profile </th>
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
                            echo "<p>" . htmlspecialchars($T['creator_id']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php                      
                        foreach ($Basedata as $T) {
                            $sql = "SELECT g.title FROM games g INNER JOIN tournaments t ON t.game_id = g.id WHERE t.id = :tournament_id";
                            $rep = $conn->prepare($sql);
                            $rep->bindParam(':tournament', T['id'], PDO::PARAM_INT);
                            $rep->execute();
                            $game = $rep->fetch();
                
                            echo "<p>" . htmlspecialchars($game['title']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php 
                        foreach ($Basedata as $T) {
                            echo "<p>" . htmlspecialchars($T['Register_time']) . "</p>";
                        }
                    ?>
                </td>
                <td>
                    <?php
                        foreach ($Basedata as $T ){
                            echo "<form method='GET' action='Tournament_management.php'>
                                  <input type='submit' value='Tournament info' />
                                  <input type='hidden' name='team_id' value='" . $T['id'] . "' /> </form>";
                        }
                    ?>
                </td>
            </tr>
            </table>
        </div>
    </div>
    <div class="Tournament_choices">
        <div class="Tab">
            <table >
                <?php
                    $valid_columns = ['tournament_id', 'tournament_Name', 'creator_id', 'title', 'Match_system' ,'History', 'participant', 'Match_system'];
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
                <th><a href="?sort=team_id&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">ID </a></th>
                <th><a href="?sort=team_title&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Name </a></th>
                <th><a href="?sort=creator_id&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Creator ID </a></th>
                <th><a href="?sort=username&order=<?= $order === 'ASC' ? 'desc' : 'asc' ?>">Creator username </a></th>
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
