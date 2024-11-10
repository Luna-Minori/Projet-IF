<?php
    session_start();
    echo $_SESSION['old_page'];
    if ($_SERVER['REQUEST_METHOD'] == 'POST'){
        $username = $_POST['username'];
        $password = $_POST['password'];
        echo "1  " . $_POST['username'];
        
        $conn = new PDO('mysql:host=localhost;dbname=board_game_tournament', 'root', '');
        $sql = "SELECT username,hashed_password FROM players WHERE username = :username";
        $rep = $conn->prepare($sql);
        $rep->bindParam(':username', $username, PDO::PARAM_STR);
        $rep->execute();
        $user = $rep->fetch(PDO::FETCH_ASSOC);
        if($user != null){
            echo $password. $user["hashed_password"];
            echo "2   " . $_SESSION['username'];
            echo $user['username'];
            $user['hashed_password'] = password_hash($password, PASSWORD_BCRYPT);
            if (password_verify($password, $user['hashed_password'])){
                if(isset($_SESSION['old_page'])){
                    $old = $_SESSION['old_page'];
                    header("Location: $old");
                    exit();
                    }
                    else {
                        $_SESSION['username'] = $user['username'];
                        header('Location: Profile_user.php');
                        exit();
                    }
            }
            else {
                echo "password false";
            }
        } 
        else {
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
    <link rel="stylesheet" href="Login_user.css">
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
                                </ul>
                           </li>
                            <li class="deroulant_Main"><a href="#"> Teams &ensp;</a>
                                <ul class="deroulant_Second">
                                    <li><a href="Team_hub.php"> My Teams </a></li>
                                    <li><a> Join Teams </a></li>
                                </ul>
                            </li>
                            <li class="deroulant_Main"><a href="#"> Games &ensp;</a>
                                <ul class="deroulant_Second">
                                    <li><a href="Profile_user.php"> Add game </a></li>
                                    <li><a> Browse games </a></li>
                                </ul>
                            </li>
                            <li class="deroulant_Main"><a href="#"> Tournaments &ensp;</a>
                                <ul class="deroulant_Second">
                                    <li><a> My tournaments </a></li>
                                    <li><a> Join tournament </a></li>
                                    <li><a> Browse tournaments </a></li>    
                                </ul>
                            </li>
                        </li>
            </ul>   
        </nav>
    </header> 
    <main>
            <div class="Connexion">
                    <form method="post" action="login_user.php">
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
                                <input class="left-space" type="text" name="password" size="12" required>
                                    <label>Password</label>
                                    <span>Password</span>
                                </div>
                                <input class="button" type="submit" name="condition" value="Log in" value="1" required>
                                <a class="Button_create_user" href="Create_user.php"><p> Sign in </p></a>
                            </div>
                        </div>
                    </form>
            </div>
        </div>
    </main>
    <div class="Main_page">
</div>
</body>
</html>
