<?php
session_start();

if (!isset($_SESSION['player_username'])) {
    header('Location: Login_user.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $Name_newgame = $_POST['Name_newgame'];
    $Game_type = $_POST['Game_type'];

    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    $sql = "SELECT COUNT(title) FROM games WHERE title = :title";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':title', $Name_newgame, PDO::PARAM_STR);
    $rep->execute();
    $number = $rep->fetchColumn();

    if ($number == 0) {
        $sql = "INSERT INTO games (title, team_based) VALUES (:title, :Game_type)";
        $rep = $conn->prepare($sql);
        $rep->bindParam(':Game_type', $Game_type, PDO::PARAM_STR);
        $rep->bindParam(':title', $Name_newgame, PDO::PARAM_STR);
        $rep->execute();
        header('Location: Profile_user.php');
        exit();
    } else {
        echo "<div class='popup'><p>This game is already in the Database<div class='popup'><p>";
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
    <div class="Box_sections">
        <section class="Profile_Main">
            <?php $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
            $sql = "SELECT * FROM players WHERE username = :session_username";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':session_username', $_SESSION['player_username'], PDO::PARAM_STR);
            $rep->execute();
            $user = $rep->fetch(PDO::FETCH_ASSOC);

            ?>
            <div class="information">
                <div class="Menu_info">
                    <h2>Information</h2>
                    <div class="button">
                        <a href="Profile_user_upg.php"><img src="Image/Menu.png" class="img_button"></a>
                    </div>
                </div>
                <div class="tab_item">
                    <div class="item">
                        <?php echo "Username : " . $user['username']; ?>
                    </div>
                    <div class="item">
                        <?php echo "email : " . $user['email']; ?>
                    </div>
                    <div class="item">
                        <?php echo "creation_acc : " . $user['creation_date']; ?>
                    </div>
                    <div class="item">
                        <?php echo "Bio : " . $user['bio']; ?>
                    </div>
                </div>
            </div>
        </section>
        <section class="Your_game">
            <div class="information">
                <div class="Menu_info">
                    <h2>Your games</h2>
                    <div class="button">
                        <a href="Profile_user_upg.php"><img src="Image/Menu.png" class="img_button"></a>
                    </div>
                </div>
                <?php
                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT title FROM games WHERE id IN (SELECT game_id FROM played_games WHERE player_id = :user_id)";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
                $rep->execute();
                $games = $rep->fetchAll(PDO::FETCH_ASSOC);
                ?>
                <div>
                    <?php foreach ($games as $game): ?>
                        <p><?php echo htmlspecialchars($game['title']); ?></p>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
        <section class="Team">
            <div class="information">
                <div class="Menu_info">
                    <h2>Team</h2>
                </div>
                <main>
                    <table>
                        <?php
                        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                        $sql = "SELECT COUNT(team_id) FROM player_teams WHERE player_id = :user_id";
                        $rep = $conn->prepare($sql);
                        $rep->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
                        $rep->execute();
                        $number = $rep->fetchColumn();
                        if ($number != 0):

                            $valid_columns_team = ['id', 'title', 'creation_date', 'games_won', 'games_lost', 'games_tied'];
                            $order_team = "ASC";
                            if (isset($_POST['order_team'])) {
                                if ($_POST['order_team'] === 'desc') {
                                    $order_team = 'DESC';
                                } else {
                                    $order_team = 'ASC';
                                }
                            }

                            if (isset($_POST['sort_team'])) {
                                if (in_array($_POST['sort_team'], $valid_columns_team)) {
                                    $sort_team = $_POST['sort_team'];
                                } else {
                                    $sort_team = "id";
                                }
                            } else {
                                $sort_team = "id";
                            }

                            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                            $sql = "SELECT * FROM teams INNER JOIN player_teams ON teams.id = player_teams.team_id WHERE player_teams.player_id = :user_id ORDER BY $sort_team $order_team";
                            $rep = $conn->prepare($sql);
                            $rep->bindParam(':user_id', $user['id'], PDO::PARAM_INT);
                            $rep->execute();
                            $Team = $rep->fetchAll(PDO::FETCH_ASSOC);
                        ?>

                            <tr>
                                <th><a href="?sort_team=id&order=<?= $order_team === 'ASC' ? 'desc' : 'asc' ?>">ID</a></th>
                                <th><a href="?sort_team=title&order=<?= $order_team === 'ASC' ? 'desc' : 'asc' ?>"> Name</a></th>
                                <th><a href="?sort_team=creation_date&order=<?= $order_team === 'ASC' ? 'desc' : 'asc' ?>">Creation Date</a></th>
                                <th>Game</th>
                                <th><a href="?sort_team=games_won&order=<?= $order_team === 'ASC' ? 'desc' : 'asc' ?>"> Win</a></th>
                                <th><a href="?sort_team=games_lost&order=<?= $order_team === 'ASC' ? 'desc' : 'asc' ?>">Lose</a></th>
                                <th><a href="?sort_team=games_tied&order=<?= $order_team === 'ASC' ? 'desc' : 'asc' ?>">Tied</a></th>
                                <th>Profile</th>
                            </tr>

                            <?php foreach ($Team as $T): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($T['id']) ?></td>
                                    <td><?php echo htmlspecialchars($T['title']) ?></td>
                                    <td><?php echo htmlspecialchars($T['creation_date']) ?></td>
                                    <td>
                                        <?php
                                        $sql_game = "SELECT g.title FROM games g INNER JOIN teams t ON t.game_id = g.id WHERE t.id = :team_id";
                                        $rep_game = $conn->prepare($sql_game);
                                        $rep_game->bindParam(':team_id', $T['id'], PDO::PARAM_INT);
                                        $rep_game->execute();
                                        $game = $rep_game->fetch();
                                        echo htmlspecialchars($game['title']);
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($T['games_won']) ?></td>
                                    <td><?php echo htmlspecialchars($T['games_lost']) ?></td>
                                    <td><?php echo htmlspecialchars($T['games_tied']) ?></td>
                                    <td>
                                        <form method="POST" action="Team_profile.php">
                                            <input type="submit" value="Team info" />
                                            <input type="hidden" name="team_id" value="<?= $T['id'] ?>" />
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                    </table>
                <?php endif; ?>
                </main>
        </section>
        <section class="History">
            <div class="information">
                <div class="Menu_info">
                    <div class="sub_Title">History</div>
                </div>
                <?php
                $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                $sql = "SELECT t.*, pt.round FROM tournaments t INNER JOIN player_tournaments pt ON pt.tournament_id = t.id WHERE id = :player_id";
                $rep = $conn->prepare($sql);
                $rep->bindParam(':player_id', $user['id'], PDO::PARAM_INT);
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
        <section class="Newgame">
            <div class="information">
                <div class="Menu_info">
                    <h2>New game</h2>
                </div>
                <main>
                    <form method="POST" action="Profile_user.php">
                        <div class="bo">
                            <div class="arena_text">
                                <label>Name</label>
                                <input class="left-space" type="text" name="Name_newgame" size="12" required>
                            </div>
                            <div class="arena_text">
                                <div class="choice">
                                    <p>Game type</p>
                                    <select name="Game_type" required>
                                        <option value="">--Please choose an option--</option>
                                        <option value="0"> Single player</option>
                                        <option value="1"> Team</option>
                                    </select>
                                </div>
                            </div>
                            <input class="button" type="submit" name="condition" value="Valid" required>
                        </div>
                    </form>
                </main>
            </div>
    </div>
    </section>
    </div>

    <a href=Main.php> Retour Main</a>
</body>

</html>