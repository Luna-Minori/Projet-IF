<?php
    session_start();
    if (!isset($_SESSION['username'])) {
        //$_SESSION['old_page'] = $_SERVER['REQUEST_URL'];
        header('Location: login_user.php');
        exit();
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
    <div class="Tab_game_select">
        <div name="game" id="game_select">
            <?php   
                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT title, id, creator_id FROM teams";
                $rep = $conn->prepare($sql);
                $rep->execute();
                $Basedata = $rep->fetchAll();
                foreach ($Basedata as $game) {
                    $_SESSION['title'] = $game['title'];
                    echo "<a href='Team_profile.php?id=" . urlencode($game['id']) . "'>" . htmlspecialchars($game['title']) . "   " . htmlspecialchars($game['creator_id']) . "</a><br>";
                }
            ?>
        </div>
    </div>
</body>
</html>
