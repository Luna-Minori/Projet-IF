<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
    $sql = "SELECT username,hashed_password FROM players WHERE username = :username";
    $rep = $conn->prepare($sql);
    $rep->bindParam(':username', $username, PDO::PARAM_STR);
    $rep->execute();
    $user = $rep->fetch(PDO::FETCH_ASSOC);
    if ($user != null) {
        echo $password . $user["hashed_password"];
        echo "2   " . $_SESSION['username'];
        echo $user['username'];
        $user['hashed_password'] = password_hash($password, PASSWORD_BCRYPT);
        if (password_verify($password, $user['hashed_password'])) {
            $_SESSION['player_username'] = $user['username'];
            header('Location: Profile_user.php');
            exit();
        } else {
            echo "password false";
        }
    } else {
        $error = "Username false";
        echo $error;
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
            </ul>
        </nav>
    </header>
    <section>
        <main>
            <div class="Connexion">
                <form method="POST" action="Login_user.php">
                    <div class="bo">
                        <h2 class="Title_form">Connexion</h2>
                        <div class="text_form">
                            <br>
                            <div class="arena_text">
                                <input class="left-space" type="text" id="username" name="username" size="12" required>
                                <label>Username</label>
                                <span>Username</span>
                            </div>
                            <div class="arena_text">
                                <input class="left-space" type="password" name="password" size="12" required>
                                <label>Password</label>
                                <span>Password</span>
                            </div>
                            <input class="button" type="submit" name="condition" value="Log in" required>
                            <a class="Button_create_user" href="Create_user.php">
                                <p> Sign in </p>
                            </a>
                        </div>
                    </div>
                </form>
            </div>
        </main>
    </section>
</body>

</html>