<?php
    session_start();

    if (!isset($_SESSION['username'])) {
        header('Location: Login_user.php');
        exit();
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
                $sql = "SELECT * FROM teams WHERE title = :title";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':title', $_SESSION['title'], PDO::PARAM_STR);
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
            <?php
                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT username FROM players p INNER JOIN player_teams pt ON p.id = pt.player_id WHERE pt.team_id = :team_id";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':team_id', $team['id'], PDO::PARAM_INT);
                $rep->execute();
                $Member = $rep->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div>
                    <?php foreach ($Member as $M): ?>
                        <p><?php echo htmlspecialchars($M['username']); ?></p>
                    <?php endforeach; ?>
                </div>
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
    </div>

        <a href=Main.php> Retour Main</a>
    </body>
</html>