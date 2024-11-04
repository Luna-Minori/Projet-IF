<?php
    session_start();
    echo  $_SESSION['username'];
    if (!isset($_SESSION['username'])) {
        header('Location: Login_user.php');
        exit();
    }
    echo  $_SESSION['username'];
    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $title = $_POST['title'];
        $password = $_POST['password'];

        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $sql = "SELECT hashed_password FROM players WHERE id = :id";
        $rep = $conn->prepare($sql);
        $rep->bindParam(':id', $_SESSION['id'], PDO::PARAM_INT);
        $rep->execute();
        $Hpassword = $rep->fetch(PDO::FETCH_ASSOC);

        if ($Hpassword && password_verify($password, $Hpassword['hashed_password'])) {

            $sql = "SELECT * FROM teams";
            $rep = $conn->prepare($sql);
            $rep->execute();

            $nameTaken = false;
            while ($Basedata = $rep->fetch(PDO::FETCH_ASSOC)) {
                if ($Basedata['title'] == $title) {
                    echo "This name is already taken";
                    $nameTaken = true;
                    break;
                }
            }

            if (!$nameTaken) {
                $sql = "INSERT INTO teams (title, id_creator) VALUES (:title, :id)";
                $rep = $conn->prepare($sql);
                $hashed_password = password_hash($password, PASSWORD_BCRYPT);
                $rep->bindParam(':name', $username, PDO::PARAM_STR);
                $rep->bindParam(':id', $id, PDO::PARAM_STR);
                $rep->execute();

                $_SESSION['username'] = $username;
                $_SESSION['hashed_password'] = $hashed_password;
                $_SESSION['email'] = $email;
                $_SESSION['bio'] = $bio;
                header('Location: Profile_user.php');
                exit();
            }
        }
    }
?>
    
<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tournament Manager</title>
    <link rel="stylesheet" href="Create_team.css">
</head>
<body>
<header>
    <main>
        <div class="Create">
            <form method="post" action="Create_team.php">
                <div class="bo">
                    <h2 class="Title_form">Account Creation</h2>
                        <div class="text_form">
                            <br>
                            <div class="arena_text">
                                <input class="left-space" type="text" id="username" name="title" size="12" required>
                                    <label>Name of your team</label>
                                    <span>Name of your team</span>
                                </div>
                                <div class="arena_text">
                                    <input class="left-space" type="text" name="password" size="12" required>
                                    <label>Your Password</label>
                                    <span>Your Password</span>
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