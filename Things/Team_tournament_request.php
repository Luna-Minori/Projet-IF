<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $Name = $_POST['Name'];

    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    $sql = "SELECT * FROM team_tournaments WHERE tournament_id =:tournament_id AND team_id = (SELECT id FROM teams WHERE title =:title_team)";
    $rep->bindParam(':tournament_id', $_GET['tournament_id'], PDO::PARAM_INT);
    $rep->bindParam(':title_team', $Name, PDO::PARAM_STR);
    $rep = $conn->prepare($sql);
    $rep->execute();

    if (!empty($Basedata)) {
        $_SESSION[''] = $username;
        $_SESSION['hashed_password'] = $password;
        $_SESSION['email'] = $email;
        $_SESSION['bio'] = $bio;
        header('Location: Profile_user.php');
        exit();
    }
    while ($Basedata = $rep->fetch(PDO::FETCH_ASSOC)) {
        if (!empty($Basedata)) {
            echo "this username is already use";
            $bool = true;
            exit();
        }
        if ($email == $Basedata['email']) {
            echo "this email is already use";
            $bool = true;
            exit();
        }
    }
    if ($bool == false) {

        $sql = "INSERT INTO players(username, email, hashed_password, bio) VALUES (:username,:email,:hashed_password,:bio)";
        $rep = $conn->prepare($sql);
        $rep->bindParam(':username', $username, PDO::PARAM_STR);
        $rep->bindParam(':email', $email, PDO::PARAM_STR);
        $rep->bindParam(':hashed_password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
        $rep->bindParam(':bio', $bio, PDO::PARAM_STR);
        $rep->execute();
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
                <form method="post" action="Create_user.php">
                    <div class="bo">
                        <h2 class="Title_form">Register team tournament</h2>
                        <div class="text_form">
                            <br>
                            <div class="arena_text">
                                <input class="left-space" type="text" id="username" name="Name" size="12" required>
                                <label>Name of your team</label>
                                <span>Name of your team</span>
                            </div>
                            <input class="button" type="submit" name="condition" value="Creation" required>
                        </div>
                    </div>
                </form>
            </div>
            </div>
        </main>
    </section>
</body>

</html>