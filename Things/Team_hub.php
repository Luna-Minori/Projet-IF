<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        $_SESSION['old_page'] = $_SERVER['REQUEST_URL'];
        header('Location: login_user.php');
        exit();
    }
    else {
        $username = $_SESSION['username'];
        echo $username;
        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $sql = "SELECT teams.id, teams.title, teams.creator_id FROM teams INNER JOIN player_teams ON teams.id = player_teams.team_id INNER JOIN players ON players.id = player_teams.player_id WHERE players.username = :username";
        $rep = $conn->prepare($sql);
        $rep->bindParam(':username', $username, PDO::PARAM_STR);
        $rep->execute();
        $Team = $rep->fetch(PDO::FETCH_ASSOC);
        echo $Team['teams.id'];
    }

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
</body>
</html>
