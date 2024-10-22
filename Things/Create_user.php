<?php
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST"){
        $username = $_POST['username'];
        $password = $_POST['password'];
        $email = $_POST['email'];

        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $sql = "SELECT * FROM players";
        $rep = $conn->prepare($sql);
        $rep->execute();

        $bool = false;
        while ($Basedata = $rep->fetch(PDO::FETCH_ASSOC)) {
            if( $Basedata['username'] == $username){
                echo "this username is already use";
                $bool = true;
                exit();
            }
            if($email == $_POST['email']){
                echo "this email is already use";
                $bool = true;
                exit();
            }
        }
        if( $bool == false ){
            $sql = "INSERT INTO players(username, email, hashed_password) VALUES (:username,:email,:hashed_password)";
            $rep = $conn->prepare($sql);
            $rep->bindParam(':username', $username, PDO::PARAM_STR);
            $rep->bindParam(':email', $email, PDO::PARAM_STR);
            $rep->bindParam(':hashed_password', password_hash($password, PASSWORD_BCRYPT), PDO::PARAM_STR);
            $rep->execute();

            $_SESSION['username'] = $username;
            $_SESSION['hashed_password'] = $password;
            $_SESSION['email'] = $email;
            header('Location: Profile_user.php');
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
    <link rel="stylesheet" href="Create_user.css">
</head>
<body>
<header>
    <main>
        <div class="Create">
            <form method="post" action="Profile_user.php">
                <div class="bo">
                    <h2 class="Title_form">Account Creation</h2>
                        <div class="text_form">
                            <br>
                            <div class="arena_text">
                                <input class="left-space" type="text" id="username" name="username" size="12" required>
                                    <label>Username</label>
                                    <span>Username</span>
                                </div>
                                <div class="arena_text">
                                    <input class="left-space" type="text" name="password" size="12" required>
                                    <label>Password</label>
                                    <span>Password</span>
                                </div>
                                <div class="arena_text">
                                    <input class="left-space" type="email" name="email" size="12" required>
                                    <label>email</label>
                                    <span>email</span>
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