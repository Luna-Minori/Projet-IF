<?php
session_start();

if (!isset($_SESSION['player_username'])) {
    header('Location: Login_user.php');
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $tournament_name = $_POST['Name'];
    $game_id = $_POST['game'];
    $Choice_participant = $_POST['Choice_participant'];
    $Choice_system = $_POST['Choice_system'];
    $Register_Time = $_POST['Register_Time'];

    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    $sql = "SELECT * FROM tournaments";
    $rep = $conn->prepare($sql);
    $rep->execute();

    $bool = false;
    while ($Basedata = $rep->fetch(PDO::FETCH_ASSOC)) {
        if ($Basedata['Name'] == $tournament_name && $Basedata['History'] == 0) {
            echo "this username is already use";
            $bool = true;
            exit();
        }
    }
    if ($bool == false) {
        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $sql = "INSERT INTO tournaments(Name, game_id, Match_system, participant, Register_time, creator_id) VALUES (:name, :game_id,:Choice_system,:Choice_participant,:Register_Time, (SELECT id FROM players WHERE username =:username LIMIT 1))";
        $rep = $conn->prepare($sql);
        $rep->bindParam(':name', $tournament_name, PDO::PARAM_STR);
        $rep->bindParam(':game_id', $game_id, PDO::PARAM_INT);
        $rep->bindParam(':Choice_system', $Choice_system, PDO::PARAM_INT);
        $rep->bindParam(':Choice_participant', $Choice_participant, PDO::PARAM_INT);
        $rep->bindParam(':Register_Time', $Register_Time, PDO::PARAM_INT);
        $rep->bindParam(':username', $_SESSION['username'], PDO::PARAM_INT);
        $rep->execute();

        if ($Choice_participant == 1) {
            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
            $sql = "SELECT id FROM players WHERE username = :username";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':username', $_SESSION['username'], PDO::PARAM_STR);
            $rep->execute();
            $_SESSION['player_id'] = $rep->fetchColumn();

            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
            $sql = "INSERT INTO player_tournaments(tournament_id, player_id, Administrator) VALUES ((SELECT id FROM tournaments WHERE Name = :name AND History=0), :player_id, 2)";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':name', $tournament_name, PDO::PARAM_STR);
            $rep->bindParam(':player_id', $_SESSION['player_id'], PDO::PARAM_INT);
            $rep->execute();
        }
        if ($Choice_participant == 2) {
            $team_name = $_POST['Team_name'];
            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
            $sql = "SELECT id FROM teams WHERE team = :team_name";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':team_name', $team_name, PDO::PARAM_STR);
            $rep->execute();
            $_SESSION['team_id'] = $rep->fetchColumn();

            $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
            $sql = "INSERT INTO team_tournaments(tournament_id, team_id) VALUES ((SELECT id FROM tournament WHERE Name = :name AND History=0), :team_id)";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':name', $tournament_name, PDO::PARAM_STR);
            $rep->bindParam(':team_name', $team_name, PDO::PARAM_STR);
            $rep->execute();
        }

        $_SESSION['tournament_name'] = $tournament_name;
        header('Location: Tournament_management.php');
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Create.css">
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
        <main>
            <div class="Create">
                <form method="post" action="Create_tournament.php">
                    <div class="bo">
                        <h2 class="Title_form">Tournament Creation</h2>
                        <div class="text_form">
                            <br>
                            <div class="arena_text">
                                <input class="left-space" type="text" name="Name" size="12" required>
                                <label> Name of Tournament</label>
                                <span> Name</span>
                            </div>
                            <div class="arena_text">
                                <div class="choice">
                                    <p> Choice game </p>
                                    <select name="game" id="game_select">
                                        <?php
                                        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
                                        $sql = "SELECT title, id FROM games";
                                        $rep = $conn->prepare($sql);
                                        $rep->execute();
                                        $game = $rep->fetchAll();
                                        foreach ($game as $g) {
                                            echo "<option value='" . htmlspecialchars($g['id']) . "'>" . htmlspecialchars($g['title']) . "</option>";
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="arena_text">
                                <div class="choice">
                                    <p> Choice tournament type </p>
                                    <select name="Choice_participant" id="Participant_select" required>
                                        <option value="">--Please choose an option--</option>
                                        <option value="1"> Single player</option>
                                        <option value="2"> Team</option>
                                    </select>
                                </div>
                            </div>
                            <div class="arena_text" id="champ_hidden" style="display:none;">
                                <input class="left-space" type="text" name="Team_Name" size="12">
                                <label> Name your Team</label>
                                <span> Name your Team</span>
                            </div>
                            <div class="arena_text">
                                <div class="choice">
                                    <p> Match type </p>
                                    <select name="Choice_system" id="Match_system_select" required>
                                        <option value="">--Please choose an option--</option>
                                        <option value="1"> elimnation rounds</option>
                                        <option value="2"> Swiss system</option>
                                        <option value="3"> league format</option>
                                    </select>
                                </div>
                            </div>
                            <div class="arena_text">
                                <div class="choice">
                                    <p> Register time </p>
                                    <select name="Register_Time" id="Register_time_select" required>
                                        <option value="">--Please choose an option--</option>
                                        <option value="1800"> 30 m</option>
                                        <option value="3600"> 1 hour</option>
                                        <option value="10800"> 3 hours</option>
                                        <option value="43200"> 12 hours</option>
                                        <option value="86400"> 1 day </option>
                                        <option value="259200"> 3 days</option>
                                        <option value="604800"> 1 week</option>
                                    </select>
                                </div>
                            </div>

                            <input class="button" type="submit" name="condition" value="Creation">
                        </div>
                    </div>
                </form>
                <script>
                    const participantSelect = document.getElementById("Participant_select");
                    const teamName = document.getElementById("champ_hidden");

                    participantSelect.addEventListener("change", function() {
                        if (this.value === "2") {
                            teamName.style.display = "block";
                            teamInput.setAttribute('required', 'required');
                        } else {
                            teamName.style.display = "none";
                            teamInput.removeAttribute('required');
                        }
                    });
                </script>
            </div>
            </div>
        </main>
    </section>
</body>

</html>