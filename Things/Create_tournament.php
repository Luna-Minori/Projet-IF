<?php
    session_start();
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $tournament_name = $_POST['Name'];
        $game_id = $_POST['game'];
        $Choice_participant = $_POST['Choice_participant'];
        $Choice_system = $_POST['Choice_system'];
        $Register_Time = $_POST['Register_Time'];

        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $sql = "INSERT INTO tournaments(Name, game_id, Match_system, participant, Register_time) VALUES (:name, :game_id,:Choice_system,:Choice_participant,:Register_Time)";
        $rep = $conn->prepare($sql);
        $rep->bindParam(':name', $tournament_name, PDO::PARAM_STR);
        $rep->bindParam(':game_id', $game_id, PDO::PARAM_INT);
        $rep->bindParam(':Choice_system', $Choice_system, PDO::PARAM_INT);
        $rep->bindParam(':Choice_participant', $Choice_participant, PDO::PARAM_INT);
        $rep->bindParam(':Register_Time', $Register_Time, PDO::PARAM_INT);
        $rep->execute();

        $_SESSION['tournament_name'] = $tournament_name;
        header('Location: Tournament_management.php');
        exit();
    }
?>
    
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Create_user.css">
</head>
<body>
<header>
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
                                <div class="arena_text">
                                    <select name="Choice_participant" id="Register_time_select" required>
                                        <option value="">--Please choose an option--</option>
                                        <option value="1"> Single player</option>
                                        <option value="2"> Team</option>
                                    </select>
                                </div>
                                <div class="arena_text">
                                    <select name="Choice_system" id="Register_time_select" required>
                                        <option value="">--Please choose an option--</option>
                                        <option value="1"> elimnation rounds</option>
                                        <option value="2"> Swiss system</option>
                                        <option value="3"> league format</option>
                                    </select>
                                </div>
                                <div class="arena_text">
                                    <select name="Register_Time" id="Register_time_select" required>
                                    <option value="">--Please choose an option--</option>
                                    <option value="1"> 30 m</option>
                                    <option value="2"> 1 hour</option>
                                    <option value="3"> 3 hours</option>
                                    <option value="4"> 12 hours</option>
                                    <option value="5"> 1 day </option>
                                    <option value="6"> 3 days</option>
                                    <option value="7"> 1 week</option>
                                    </select>
                                </div>
                                
                                <input class="button" type="submit" name="condition" value="Creation" value="1" required>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </main>

        <a href=Main.php> Retour Main</a>
    </body>

</html>